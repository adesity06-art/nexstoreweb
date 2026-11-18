<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $sale->no_transaksi }}</title>
    <style>
        /* Reset dasar agar lebar konsisten */
        * {
            box-sizing: border-box; 
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #F1FAEE;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .receipt-box {
            background: #FFF;
            width: 100%;
            max-width: 380px;
            padding: 30px;
            border: 2px dashed #111;
            box-shadow: 6px 6px 0px #111;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #111;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 900;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .header p {
            font-size: 0.8rem;
            margin: 0;
            color: #555;
        }

        .info {
            font-size: 0.85rem;
            margin-bottom: 15px;
            border-bottom: 2px dashed #111;
            padding-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .items {
            margin-bottom: 15px;
            border-bottom: 2px dashed #111;
            padding-bottom: 15px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .item-name { flex: 2; }
        .item-qty { flex: 0.5; text-align: center; }
        .item-total { flex: 1; text-align: right; }

        .totals {
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .grand-total {
            font-weight: 900;
            font-size: 1.2rem;
            border-top: 1px dashed #111;
            padding-top: 10px;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            font-size: 0.8rem;
            margin-top: 20px;
            color: #555;
        }

        /* Perbaikan Tombol */
        .action-buttons {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 15px; /* Jarak antar tombol */
            width: 100%;
        }

        /* Samakan style untuk button dan link */
        .btn-action {
            display: block;
            width: 100%; /* Memastikan lebar penuh */
            padding: 12px;
            border: 3px solid #111;
            font-family: 'Jost', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 4px 4px 0px #111;
            transition: all 0.2s;
            font-size: 1rem; /* Samakan ukuran font */
        }

        .btn-action:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px #111;
        }

        .btn-print {
            background-color: #1D3557;
            color: white;
        }

        .btn-back {
            background-color: #E63946;
            color: white;
        }

        /* Sembunyikan tombol saat dicetak */
        @media print {
            body { background: #FFF; }
            .receipt-box { border: none; box-shadow: none; }
            .action-buttons { display: none; }
        }
    </style>
</head>
<body>

    <div class="receipt-box">
        <div class="header">
            <h1>NEXSTORE</h1>
            <p>Jl. Teknologi No. 123, Jakarta</p>
            <p>Telp: 021-1234567</p>
        </div>

        <div class="info">
            <div class="info-row">
                <span>No. Transaksi</span>
                <span>: {{ $sale->no_transaksi }}</span>
            </div>
            <div class="info-row">
                <span>Tanggal</span>
                <span>: {{ $sale->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span>Kasir</span>
                <span>: {{ $sale->user->name ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="items">
            @foreach($sale->saleDetails as $detail)
            <div class="item-row">
                <div class="item-name">{{ $detail->product->nama_produk }}</div>
                <div class="item-qty">{{ $detail->jumlah }}x</div>
                <div class="item-total">{{ number_format($detail->subtotal, 0, ',', '.') }}</div>
            </div>
            @endforeach
        </div>

        
@php
    $subtotalBelanja = $sale->saleDetails->sum('subtotal');
    $pajak = round($subtotalBelanja * 0.10);
    $totalAkhir = $subtotalBelanja + $pajak;
@endphp


<div class="totals">
    <div class="total-row">
        <span>Subtotal</span>
        <span>Rp {{ number_format($subtotalBelanja, 0, ',', '.') }}</span>
    </div>

    <div class="total-row">
        <span>Pajak 10%</span>
        <span>Rp {{ number_format($pajak, 0, ',', '.') }}</span>
    </div>

    <div class="total-row grand-total">
        <span>TOTAL</span>
        <span>Rp {{ number_format($totalAkhir, 0, ',', '.') }}</span>
    </div>

    <div class="total-row">
        <span>Bayar</span>
        <span>Rp {{ number_format($sale->bayar, 0, ',', '.') }}</span>
    </div>

    <div class="total-row">
        <span>Kembalian</span>
        <span>Rp {{ number_format($sale->kembalian, 0, ',', '.') }}</span>
    </div>
</div>


        <div class="footer">
            <p>Terima Kasih Atas Kunjungan Anda</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan.</p>
        </div>

        <!-- Tombol Cetak & Kembali -->
        <div class="action-buttons">
            <button class="btn-action btn-print" onclick="window.print()">Cetak Struk</button>
            <a href="{{ route('kasir') }}" class="btn-action btn-back">Kembali ke Kasir</a>
        </div>
    </div>

</body>
</html>