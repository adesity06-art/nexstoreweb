@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<style>
    .filter-box {
        background: #FFF;
        border: 4px solid #111;
        box-shadow: 6px 6px 0px #111;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        gap: 20px;
        align-items: flex-end;
    }
    .filter-group { display: flex; flex-direction: column; gap: 5px; }
    .filter-group label { font-weight: 700; text-transform: uppercase; font-size: 0.8rem; }
    .form-control-bauhaus {
        padding: 10px 15px; border: 3px solid #111; font-family: 'Jost', sans-serif;
        font-size: 1rem; background: #F1FAEE;
    }
    .btn-bauhaus {
        padding: 10px 20px; border: 3px solid #111; font-family: 'Jost', sans-serif;
        font-weight: 700; text-transform: uppercase; cursor: pointer;
        box-shadow: 4px 4px 0px #111; transition: all 0.2s; text-decoration: none;
        display: inline-block; text-align: center;
    }
    .btn-bauhaus:hover { transform: translate(-2px, -2px); box-shadow: 6px 6px 0px #111; }
    .btn-primary { background: #1D3557; color: white; }
    .btn-success { background: #F4A261; color: #111; }
    .btn-danger { background: #E63946; color: white; }

    /* Grid 3 Kartu */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    .summary-card {
        background: #FFF; border: 4px solid #111; box-shadow: 6px 6px 0px #111; padding: 25px;
    }
    .summary-label { font-weight: 700; text-transform: uppercase; margin-bottom: 10px; font-size: 0.9rem; }
    .summary-value { font-size: 2.2rem; font-weight: 900; line-height: 1; }

    /* Container Grafik */
    .chart-container {
        background: #FFF; border: 4px solid #111; box-shadow: 6px 6px 0px #111;
        padding: 25px; margin-bottom: 30px;
    }

    /* Tabel */
    .table-container {
        background: #FFF; border: 4px solid #111; box-shadow: 6px 6px 0px #111;
        overflow: hidden; margin-bottom: 30px;
    }
    .table-header {
        background: #1D3557; color: white; padding: 20px; font-size: 1.2rem;
        font-weight: 900; text-transform: uppercase; border-bottom: 4px solid #111;
    }
    .table-bauhaus { width: 100%; border-collapse: collapse; }
    .table-bauhaus th {
        text-align: left; padding: 15px 20px; font-weight: 900; text-transform: uppercase;
        border-bottom: 4px solid #111; background-color: #F1FAEE; color: #111;
    }
    .table-bauhaus td { padding: 15px 20px; border-bottom: 2px solid #111; font-weight: 500; }

    @media (max-width: 900px) { .summary-grid { grid-template-columns: 1fr; } }

    /* CSS KHUSUS UNTUK CETAK (PRINT) */
    @media print {
        /* Sembunyikan sidebar, navbar, filter, dan tombol */
        .sidebar, .top-navbar, .filter-box, .btn-bauhaus, .alert {
            display: none !important;
        }
        /* Sesuaikan margin konten utama */
        .main-content { margin-left: 0 !important; width: 100% !important; }
        .content-area { padding: 0 !important; }
        /* Hilangkan bayangan agar hemat tinta */
        .summary-card, .chart-container, .table-container {
            box-shadow: none !important; border: 2px solid #000 !important;
        }
        .table-header { background-color: #FFF !important; color: #000 !important; border-bottom: 2px solid #000 !important; }
        body { background: #FFF !important; }
    }
</style>

<!-- Header Halaman & Tombol Cetak -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-weight: 900; text-transform: uppercase;">Laporan Penjualan</h2>
    <button onclick="window.print()" class="btn-bauhaus btn-danger">🖨️ Cetak Laporan</button>
</div>

<!-- Filter Tanggal -->
<div class="filter-box">
    <form action="{{ route('laporan') }}" method="GET" style="display: flex; gap: 20px; align-items: flex-end; width: 100%;">
        <div class="filter-group">
            <label>Periode Awal</label>
            <input type="date" name="start_date" class="form-control-bauhaus" value="{{ $startDate }}">
        </div>
        <div class="filter-group">
            <label>Periode Akhir</label>
            <input type="date" name="end_date" class="form-control-bauhaus" value="{{ $endDate }}">
        </div>
        <button type="submit" class="btn-bauhaus btn-primary">Tampilkan</button>
    </form>
</div>

<!-- 3 Kartu Ringkasan -->
<div class="summary-grid">
    <div class="summary-card" style="background-color: #F4A261;">
        <div class="summary-label">Total Transaksi</div>
        <div class="summary-value">{{ $totalTransactions }}</div>
    </div>
    <div class="summary-card" style="background-color: #F1FAEE;">
        <div class="summary-label">Total Item Terjual</div>
        <div class="summary-value">{{ $totalItems }}</div>
    </div>
    <div class="summary-card" style="background-color: #E63946; color: white;">
        <div class="summary-label">Total Pendapatan</div>
        <div class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>
</div>

<!-- Grafik Harian -->
<div class="chart-container">
    <h3 style="font-weight: 900; text-transform: uppercase; margin-bottom: 20px;">Grafik Penjualan Harian</h3>
    <canvas id="dailyChart" height="80"></canvas>
</div>

<!-- Tabel Produk Terlaris -->
<div class="table-container">
    <div class="table-header">Produk Terlaris</div>
    <table class="table-bauhaus">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Terjual</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topProducts as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product->nama_produk ?? 'N/A' }}</td>
                <td>{{ $item->total_qty }} pcs</td>
                <td>Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 30px; font-weight: 700;">Belum ada data penjualan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Tabel Riwayat Transaksi -->
<div class="table-container">
    <div class="table-header">Riwayat Transaksi</div>
    <table class="table-bauhaus">
        <thead>
            <tr>
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            <tr>
                <td><strong>{{ $sale->no_transaksi }}</strong></td>
                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $sale->user->name ?? 'N/A' }}</td>
                <td>Rp {{ number_format($sale->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 30px; font-weight: 700;">Tidak ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dailyChart').getContext('2d');
    const labels = {!! json_encode($chartData->pluck('date')) !!};
    const data = {!! json_encode($chartData->pluck('total')) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan Harian (Rp)',
                data: data,
                backgroundColor: '#1D3557',
                borderColor: '#111',
                borderWidth: 3,
                borderRadius: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#DDD', lineWidth: 2 } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection