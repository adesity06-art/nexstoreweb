<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    private const TAX_RATE = 0.10;

    // Tampilkan halaman POS Kasir
    public function index()
    {
        $products = Product::where('stok', '>', 0)->get();
        return view('cashier.index', compact('products'));
    }

    // Proses transaksi
    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer|exists:products,id',
            'cart.*.jumlah' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:0',
        ]);

        $cart = $request->input('cart');
        $bayar = (int) $request->input('bayar');

        try {
            $sale = DB::transaction(function () use ($cart, $bayar) {
                $subtotal = 0;
                $lines = [];

                // Harga SELALU diambil dari database, bukan dari browser.
                foreach ($cart as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item['id']);
                    $jumlah = (int) $item['jumlah'];

                    if ($product->stok < $jumlah) {
                        throw new \Exception("Stok produk {$product->nama_produk} tidak mencukupi.");
                    }

                    $lineSubtotal = $product->harga * $jumlah;
                    $subtotal += $lineSubtotal;
                    $lines[] = [$product, $jumlah, $lineSubtotal];
                }

                // Total sama dengan yang tampil di layar kasir & struk (subtotal + pajak 10%).
                $pajak = (int) round($subtotal * self::TAX_RATE);
                $totalHarga = $subtotal + $pajak;

                if ($bayar < $totalHarga) {
                    throw new \Exception('Uang bayar kurang!');
                }

                $sale = Sale::create([
                    'no_transaksi' => 'TRX-' . date('YmdHis') . '-' . random_int(100, 999),
                    'user_id' => Auth::id(),
                    'total_harga' => $totalHarga,
                    'bayar' => $bayar,
                    'kembalian' => $bayar - $totalHarga,
                ]);

                foreach ($lines as [$product, $jumlah, $lineSubtotal]) {
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'jumlah' => $jumlah,
                        'subtotal' => $lineSubtotal,
                    ]);

                    $product->decrement('stok', $jumlah);
                }

                return $sale;
            });

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
                'sale_id' => $sale->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    // Halaman Struk
    public function receipt($id)
    {
        $sale = Sale::with(['user', 'saleDetails.product'])->findOrFail($id);
        return view('cashier.receipt', compact('sale'));
    }
}
