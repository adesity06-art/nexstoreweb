<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Filter Tanggal
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // 1. Total Transaksi
        $totalTransactions = Sale::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();

        // 2. Total Item Terjual (INI YANG BELUM ADA SEBELUMNYA)
        $totalItems = SaleDetail::whereHas('sale', function($q) use ($startDate, $endDate) {
            $q->whereDate('created_at', '>=', $startDate)
              ->whereDate('created_at', '<=', $endDate);
        })->sum('jumlah');

        // 3. Total Pendapatan
        $totalRevenue = Sale::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('total_harga');

        // 4. Data Grafik Harian
        $chartData = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_harga) as total')
        )
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        // 5. Produk Terlaris (Top 5)
        $topProducts = SaleDetail::select(
            'product_id',
            DB::raw('SUM(jumlah) as total_qty'),
            DB::raw('SUM(subtotal) as total_revenue')
        )
        ->whereHas('sale', function($q) use ($startDate, $endDate) {
            $q->whereDate('created_at', '>=', $startDate)
              ->whereDate('created_at', '<=', $endDate);
        })
        ->groupBy('product_id')
        ->orderBy('total_qty', 'DESC')
        ->take(5)
        ->with('product')
        ->get();

        // 6. Riwayat Transaksi
        $sales = Sale::with('user')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->paginate(10);

        return view('reports.index', compact(
            'sales', 'startDate', 'endDate', 
            'totalTransactions', 'totalItems', 'totalRevenue', 
            'chartData', 'topProducts'
        ));
    }
}