<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMutationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $sortBy = $request->input('sort_by', 'created_at');
        $direction = $request->input('direction', 'desc');

        $allowedSorts = ['created_at', 'type', 'quantity', 'stock_before', 'stock_after'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'desc';

        $mutations = StockMutation::with(['product', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('notes', 'like', "%{$search}%")
                             ->orWhereHas('product', function ($q) use ($search) {
                                 $q->where('sku', 'like', "%{$search}%")
                                   ->orWhere('name', 'like', "%{$search}%");
                             });
            })
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->orderBy($sortBy, $direction)
            ->paginate(15)
            ->appends([
                'search' => $search,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'sort_by' => $sortBy,
                'direction' => $direction,
            ]);

        $products = Product::all();

        return view('stock_mutations.index.index', compact('products','mutations', 'search', 'sortBy', 'direction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'quantity.required' => 'Jumlah (Qty) wajib diisi.',
            'quantity.integer' => 'Jumlah (Qty) harus berupa bilangan bulat (tanpa desimal).',
            'quantity.min' => 'Jumlah (Qty) minimal adalah 1 (tidak boleh nol atau negatif).',
        ]);
    
        DB::beginTransaction();
    
        try {
            $product = Product::lockForUpdate()
                ->findOrFail($request->product_id);
    
            // ==========================================
            // VALIDASI STOK KELUAR
            // ==========================================
            if (
                $request->type === 'out' &&
                $request->quantity > $product->stock
            ) {
                DB::rollBack();
    
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Gagal! Jumlah stok keluar (' .
                        $request->quantity .
                        ') melebihi sisa stok saat ini (' .
                        $product->stock .
                        ').'
                    );
            }
    
            // ==========================================
            // HITUNG STOK
            // ==========================================
            $stockBefore = $product->stock;
    
            if ($request->type === 'in') {
                $stockAfter = $stockBefore + $request->quantity;
            } else {
                $stockAfter = $stockBefore - $request->quantity;
            }
    
            // ==========================================
            // UPLOAD FOTO
            // ==========================================
            $photoPath = null;
    
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
    
                $slugName = \Illuminate\Support\Str::slug($product->name);
                $dateFormatted = date('Y-m-d_H-i-s');
                $extension = $file->getClientOriginalExtension();
    
                $filename = '[MUT]_' .
                    $slugName . '_' .
                    $dateFormatted . '.' .
                    $extension;
    
                $destinationPath = public_path('uploads/products/mutasi');
    
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
    
                $file->move($destinationPath, $filename);
    
                $photoPath = $filename;
            }
    
            // ==========================================
            // SIMPAN MUTASI
            // ==========================================
            StockMutation::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => $request->type,
                'quantity' => $request->quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'notes' => $request->notes,
                'photo' => $photoPath,
            ]);
    
            // ==========================================
            // UPDATE STOK PRODUK
            // ==========================================
            $product->update([
                'stock' => $stockAfter,
            ]);
    
            DB::commit();
    
            return back()->with(
                'success',
                'Transaksi mutasi stok berhasil dicatat.'
            );
    
        } catch (\Exception $e) {
    
            DB::rollBack();
    
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terjadi kesalahan sistem: ' . $e->getMessage()
                );
        }
    }

    public function show($id)
    {
        try {
            $mutation = StockMutation::with(['product', 'user'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'created_at' => $mutation->created_at->format('d/m/Y H:i'),
                    'type' => $mutation->type,
                    'quantity' => $mutation->quantity,
                    'stock_before' => $mutation->stock_before,
                    'stock_after' => $mutation->stock_after,
                    'notes' => $mutation->notes ?? '-',
                    'product_name' => $mutation->product->name ?? 'Produk Dihapus',
                    'product_sku' => $mutation->product->sku ?? '-',
                    'user_name' => $mutation->user->name ?? 'System',
                    'photo_url' => $mutation->photo ? asset('uploads/products/mutasi/' . $mutation->photo) : null,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data mutasi tidak ditemukan.'
            ], 404);
        }
    }
    
    public function destroy($id)
    {
        if (!auth()->user()->can('delete-employess')) {
            abort(403, 'Anda tidak memiliki hak akses.');
        }
        
        DB::beginTransaction();
        try {
            $mutation = StockMutation::findOrFail($id);
            $product = Product::lockForUpdate()->find($mutation->product_id);

            if ($product) {
                if ($mutation->type === 'in') {
                    $newStock = $product->stock - $mutation->quantity;
                } else {
                    $newStock = $product->stock + $mutation->quantity;
                }

                $product->update([
                    'stock' => max(0, $newStock)
                ]);
            }

            if ($mutation->photo) {
                $oldPath = public_path('uploads/products/mutase/' . $mutation->photo);
                $deletedFolder = public_path('uploads/products/mutasi/deleted');

                if (!file_exists($deletedFolder)) {
                    mkdir($deletedFolder, 0755, true);
                }

                if (file_exists($oldPath)) {
                    $newPath = $deletedFolder . '/' . $mutation->photo;
                    rename($oldPath, $newPath);
                }
            }

            $mutation->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Riwayat mutasi berhasil dihapus, stok produk telah disesuaikan kembali, dan foto diarsipkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus mutasi: ' . $e->getMessage());
        }
    }
}
