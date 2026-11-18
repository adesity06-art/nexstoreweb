@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Styling Khusus Dashboard Bauhaus */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #FFFFFF;
        border: 4px solid #111;
        padding: 25px;
        box-shadow: 6px 6px 0px #111;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translate(-3px, -3px);
        box-shadow: 9px 9px 0px #111;
    }

    .stat-card.blue { background-color: #1D3557; color: white; }
    .stat-card.yellow { background-color: #F4A261; color: #111; }
    .stat-card.red { background-color: #E63946; color: white; }
    .stat-card.white { background-color: #FFFFFF; color: #111; }

    .stat-label {
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 900;
        line-height: 1;
    }

    /* Tabel Bauhaus */
    .table-container {
        background: #FFFFFF;
        border: 4px solid #111;
        box-shadow: 6px 6px 0px #111;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .table-header {
        background-color: #1D3557;
        color: white;
        padding: 20px;
        font-size: 1.2rem;
        font-weight: 900;
        text-transform: uppercase;
        border-bottom: 4px solid #111;
    }

    .table-bauhaus {
        width: 100%;
        border-collapse: collapse;
    }

    .table-bauhaus th {
        text-align: left;
        padding: 15px 20px;
        font-weight: 700;
        text-transform: uppercase;
        border-bottom: 2px solid #111;
        background-color: #F1FAEE;
    }

    .table-bauhaus td {
        padding: 15px 20px;
        border-bottom: 1px solid #DDD;
        font-weight: 500;
    }

    .badge-bauhaus {
        background-color: #F4A261;
        color: #111;
        padding: 4px 10px;
        font-weight: 700;
        border: 2px solid #111;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .chart-container {
        background: #FFFFFF;
        border: 4px solid #111;
        box-shadow: 6px 6px 0px #111;
        padding: 25px;
        margin-bottom: 30px;
    }

    @media (max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- 4 Kartu Statistik -->
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-label">Total Produk</div>
        <div class="stat-value">{{ $totalProducts }}</div>
    </div>
    
    <div class="stat-card yellow">
        <div class="stat-label">Total Transaksi</div>
        <div class="stat-value">{{ $totalTransactions }}</div>
    </div>
    
    <div class="stat-card red">
        <div class="stat-label">Pendapatan Hari Ini</div>
        <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>
    
    <div class="stat-card white">
        <div class="stat-label">Stok Menipis (< 10)</div>
        <div class="stat-value">{{ $lowStockProducts->count() }} <span style="font-size: 1rem;">Produk</span></div>
    </div>
</div>

<!-- Grafik Penjualan -->
<div class="chart-container">
    <h3 style="font-weight: 900; text-transform: uppercase; margin-bottom: 20px;">Grafik Penjualan (7 Hari Terakhir)</h3>
    <canvas id="salesChart" height="80"></canvas>
</div>

<!-- Tabel Transaksi Terbaru -->
<div class="table-container">
    <div class="table-header">Transaksi Terbaru</div>
    <table class="table-bauhaus">
        <thead>
            <tr>
                <th>No. Transaksi</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentTransactions as $trx)
            <tr>
                <td><strong>{{ $trx->no_transaksi }}</strong></td>
                <td>{{ $trx->user->name ?? 'N/A' }}</td>
                <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                <td><span class="badge-bauhaus">Selesai</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 30px;">Belum ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const labels = {!! json_encode($salesData->pluck('date')) !!};
    const data = {!! json_encode($salesData->pluck('total')) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: data,
                backgroundColor: '#E63946',
                borderColor: '#111',
                borderWidth: 3,
                borderRadius: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#DDD', lineWidth: 2 },
                    ticks: { font: { family: 'Jost', weight: 'bold' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Jost', weight: 'bold' } }
                }
            }
        }
    });
</script>
@endsection