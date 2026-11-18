<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Produk
        $totalProducts = Product::count();

        // 2. Total Transaksi
        $totalTransactions = Sale::count();

        // 3. Total Pendapatan (Hari Ini)
        $totalRevenue = Sale::whereDate('created_at', today())->sum('total_harga');

        // 4. Stok Menipis (di bawah 10)
        $lowStockProducts = Product::where('stok', '<', 10)->get();

        // 5. Transaksi Terbaru (5 terakhir)
        $recentTransactions = Sale::with('user')->latest()->take(5)->get();

        // 6. Data Grafik Penjualan (7 Hari Terakhir)
        $salesData = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_harga) as total')
        )
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        return view('dashboard', compact(
            'totalProducts', 
            'totalTransactions', 
            'totalRevenue', 
            'lowStockProducts', 
            'recentTransactions',
            'salesData'
        ));
    }
}