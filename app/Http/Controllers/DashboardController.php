<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil data produk yang stoknya di bawah 5
        $lowStockProducts = Product::where('stock', '<', 5)->orderBy('stock', 'asc')->get();
        $lowStockCount = $lowStockProducts->count();

        // Jika user memiliki role owner atau gudang, dan ada stok menipis
        if ($user->hasRole(['owner', 'gudang']) && $lowStockCount > 0) {
            // Cek apakah session peringatan sudah dimunculkan sekali saat sesi login ini
            if (!session()->has('low_stock_alert_shown')) {
                session()->flash('warning_low_stock', 'Perhatian! Terdapat ' . $lowStockCount . ' jenis produk dengan stok menipis (< 5). Silakan periksa daftar di bawah.');
                session()->put('low_stock_alert_shown', true);
            }
        }

        $data = [
            'user' => $user,
            'totalEmployees' => Employee::count(),
            'totalSku' => Product::count(),
            'totalUnits' => Product::sum('stock'),
            'lowStockCount' => $lowStockCount,
            'totalInventoryValue' => Product::selectRaw('SUM(stock * price) as total')->value('total') ?? 0,
            'lowStockProducts' => $lowStockProducts,
        ];

        return view('dashboard', $data);
    }
}