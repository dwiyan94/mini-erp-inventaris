<?php  
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('view-products')) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman produk.');
        }

        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'updated_at');
        
        $direction = $request->input('direction', 'desc'); 

        $allowedSorts = ['sku', 'name', 'category', 'price', 'stock', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'updated_at';
        }

        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'desc';

        $products = Product::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('sku', 'like', "%{$search}%")
                             ->orWhere('name', 'like', "%{$search}%")
                             ->orWhere('category', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $direction)
            ->paginate(10)
            ->appends([
                'search' => $search,
                'sort_by' => $sortBy,
                'direction' => $direction,
            ]);

        return view('products.index.index', compact('products', 'search', 'sortBy', 'direction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'price.min' => 'Harga produk harus bernilai lebih dari 0.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok tidak boleh bernilai negatif.',
        ]);

        $data = $request->except('photo');
        $data['user_id'] = auth()->id(); 

        // Proses upload file foto produk
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            
            $slugName = \Illuminate\Support\Str::slug($request->name);
            $extension = $file->getClientOriginalExtension();
            
            $filename = $slugName . '_' . time() . '.' . $extension;
            
            $file->move(public_path('uploads/products/items/'), $filename);
            $data['photo'] = $filename;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:1',
            'stock' => 'nullable|integer|min:0', 
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'sku.unique' => 'SKU ini sudah digunakan oleh produk lain.',
            'price.min' => 'Harga produk harus bernilai lebih dari 0.',
        ]);
        
        $data = $request->except(['photo']);

        if (is_null($data['stock'])) {
            unset($data['stock']);
        }

        if ($request->hasFile('photo')) {

            if ($product->photo && file_exists(public_path('uploads/products/items/' . $product->photo))) {
                @unlink(public_path('uploads/products/items/' . $product->photo));
            }

            $file = $request->file('photo');
            
            $slugName = \Illuminate\Support\Str::slug($request->name);
            $extension = $file->getClientOriginalExtension();
            $filename = $slugName . '_' . time() . '.' . $extension;

            $destinationPath = public_path('uploads/products/items/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data['photo'] = $filename;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->photo) {

            $oldPath = public_path('uploads/products/items/' . $product->photo);
            $deletedDir = public_path('uploads/products/items/deleted');

            if (!file_exists($deletedDir)) {
                mkdir($deletedDir, 0755, true);
            }

            $newPath = $deletedDir . '/' . $product->photo;

            if (file_exists($oldPath)) {
                rename($oldPath, $newPath);
            }
        }
        
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show(Request $request, Product $product)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $stockMutations = $product->stockMutations()
            ->with('user')
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('created_at', '<=', $endDate);
            })
            ->latest()
            ->paginate(10)
            ->appends([
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

        return view('products.index.show', compact('product', 'stockMutations'));
    }

    public function importDemo()
    {
        if (!auth()->user()->can('view-users')) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        $response = Http::withoutVerifying()->get('https://dummyjson.com/products');

        if ($response->successful()) {
            $items = $response->json('products');

            foreach ($items as $item) {
                $sku = 'SKU-DUMMY-' . $item['id'];

                Product::withTrashed()->updateOrCreate(
                    ['sku' => $sku],
                    [
                        'name' => $item['title'],
                        'category' => ucfirst($item['category']),
                        'unit' => 'Pcs',
                        'price' => $item['price'] * 17000,
                        'stock' => $item['stock'],
                        'photo' => null,
                        'user_id' => auth()->id(),
                        'deleted_at' => null,
                    ]
                );
            }

            return redirect()->route('products.index')->with('success', 'Data demo produk berhasil dimuat dari DummyJSON!');
        }

        return redirect()->route('products.index')->with('error', 'Gagal mengambil data dari server DummyJSON.');
    }

    public function resetDemo()
    {
        if (!auth()->user()->can('view-users')) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        // Menonaktifkan sementara pengecekan relasi foreign key
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        // Kosongkan tabel produk dan tabel relasinya (misal: mutasi)
        \App\Models\Product::truncate();
        // Jika ada tabel mutasi yaml_emit(data)ng ikut dikosongkan:
        // \App\Models\ProductMutation::truncate(); 

        // Mengaktifkan kembali pengecekan relasi
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        return redirect()->route('products.index')->with('success', 'Data produk dan riwayat mutasi berhasil di-reset total.');
    }
}