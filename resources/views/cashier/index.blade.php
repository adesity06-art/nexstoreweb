
@extends('layouts.app')

@section('title', 'POS Kasir')
@section('body_class', 'pos-mode')

@section('content')
<style>
    .pos-container {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(310px, 1fr);
        gap: 20px;
        min-height: calc(100vh - 150px);
        align-items: stretch;
    }

    .product-area,
    .cart-area {
        min-width: 0;
        background: #FFF;
        border: 4px solid #111;
        box-shadow: 6px 6px 0 #111;
    }

    .product-area {
        padding: 20px;
        overflow-y: auto;
    }

    .product-area h3 {
        font-weight: 900;
        text-transform: uppercase;
        margin: 0 0 15px;
    }

    .product-search {
        width: 100%;
        height: 36px;
        padding: 8px;
        border: 2px solid #111;
        margin-bottom: 10px;
        font: inherit;
        box-sizing: border-box;
    }

    /* FILTER KATEGORI */
    .filter-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
    }

    .filter-row > span {
        font-weight: 700;
    }

    .filter-btn {
        padding: 7px 16px;
        border: 2px solid #111;
        background: #F1FAEE;
        color: #111;
        font: inherit;
        cursor: pointer;
        box-shadow: 2px 2px 0 #111;
        transition: background .15s, transform .15s;
    }

    .filter-btn:hover {
        background: #F4A261;
        transform: translateY(-1px);
    }

    .filter-btn.active {
        background: #DCE9FF;
        color: #1D3557;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .product-card {
        min-width: 0;
        min-height: 92px;
        box-sizing: border-box;
        background: #F1FAEE;
        border: 2px solid #111;
        border-radius: 12px;
        padding: 12px 5px;
        text-align: center;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #111;
        font-family: inherit;
        box-shadow: 3px 3px 0 #111;
        transition: background .15s, transform .15s;
    }

    .product-card:hover {
        background: #F4A261;
        transform: translateY(-2px);
    }

    .product-card:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .product-card[hidden] {
        display: none !important;
    }

    .product-name {
        font-weight: 700;
        font-size: 14px;
        overflow-wrap: anywhere;
        margin-bottom: 4px;
    }

    .product-price {
        font-weight: 900;
        color: #1D3557;
    }

    .product-stock {
        font-size: 12px;
        color: #666;
        margin-top: 4px;
    }

    /* KERANJANG */
    .cart-area {
        display: flex;
        flex-direction: column;
    }

    .cart-header {
        background: #1D3557;
        color: white;
        padding: 13px;
        text-align: center;
        font-weight: 900;
        text-transform: uppercase;
        border-bottom: 3px solid #111;
    }

    .cart-items {
        flex: 1;
        min-height: 100px;
        max-height: 350px;
        padding: 8px 14px;
        overflow-y: auto;
        background: #FFF;
    }

    .cart-empty {
        text-align: center;
        color: #999;
        margin-top: 20px;
    }

    .cart-item {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 12px;
        align-items: center;
        border-bottom: 1px solid #DDD;
        padding: 12px 0;
    }

    .cart-item-info {
        min-width: 0;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .cart-item-info small {
        display: block;
        margin-top: 5px;
        color: #666;
        font-weight: 400;
    }

    .cart-item-right {
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
    }

    .cart-item-total {
        white-space: nowrap;
        font-weight: 800;
        color: #1D3557;
    }

    .cart-item-controls {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 7px;
    }

    .btn-qty {
        flex-shrink: 0;
        background: #F1FAEE;
        color: #111;
        border: 1px solid #111;
        width: 28px;
        height: 28px;
        cursor: pointer;
    }

    .btn-qty.plus {
        background: #F4A261;
    }

    .btn-remove {
        border: none;
        background: transparent;
        color: #E63946;
        font-size: 20px;
        font-weight: 900;
        cursor: pointer;
    }

    .cart-footer {
        padding: 12px;
        border-top: 3px solid #111;
        background: #F1FAEE;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin: 7px 0;
        font-size: 14px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        border-top: 2px solid #111;
        padding-top: 13px;
        margin-top: 10px;
        margin-bottom: 12px;
        font-weight: 900;
        font-size: 20px;
    }

    .form-control-bauhaus {
        box-sizing: border-box;
        width: 100%;
        padding: 9px 12px;
        height: 42px;
        border: 2px solid #111;
        border-radius: 0;
        background: #FFF;
        color: #111;
        font-family: inherit;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .payment-label {
        display: block;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .change-row {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        margin: 2px 0 14px;
        font-weight: 700;
    }

    .btn-checkout,
    .btn-cancel {
        box-sizing: border-box;
        display: block;
        width: 100%;
        padding: 11px;
        border: 2px solid #111;
        font-family: inherit;
        font-size: 14px;
        font-weight: 900;
        text-transform: uppercase;
        cursor: pointer;
        box-shadow: 3px 3px 0 #111;
        transition: transform .15s;
    }

    .btn-checkout {
        background: #DCE9FF;
        color: #111;
        margin-bottom: 10px;
    }

    .btn-cancel {
        background: #F8D1D0;
        color: #111;
    }

    .btn-checkout:hover,
    .btn-cancel:hover {
        transform: translateY(-2px);
    }

    .btn-checkout:disabled {
        opacity: .5;
        cursor: not-allowed;
    }

    .pos-message {
        color: #B42318;
        font-size: 12px;
        margin-bottom: 8px;
    }

    @media (max-width: 1050px) {
        .pos-container {
            grid-template-columns: minmax(0, 1.3fr) minmax(280px, 1fr);
            gap: 14px;
        }

        .product-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .pos-container {
            grid-template-columns: 1fr;
            min-height: auto;
        }

        .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .cart-items {
            max-height: 350px;
        }
    }

    @media (max-width: 420px) {
        .product-area {
            padding: 12px;
        }

        .cart-item {
            grid-template-columns: minmax(0, 1fr);
        }

        .cart-item-right {
            align-items: flex-start;
        }

        .cart-item-controls {
            justify-content: flex-start;
        }

        .total-row {
            font-size: 18px;
        }
    }
</style>

@php
    $categories = $products
        ->pluck('category.name')
        ->filter()
        ->unique()
        ->sort()
        ->values();
@endphp

<div class="pos-container">
    <section class="product-area">
        <h3>Daftar Produk</h3>

        <input
            type="search"
            id="product-search"
            class="product-search"
            placeholder="Cari produk / scan barcode..."
            autocomplete="off"
        >

        <div class="filter-row">
            <span>Filter:</span>

            <button
                type="button"
                class="filter-btn active"
                data-category="all"
            >
                Semua
            </button>

            @foreach($categories as $category)
                <button
                    type="button"
                    class="filter-btn"
                    data-category="{{ $category }}"
                >
                    {{ $category }}
                </button>
            @endforeach

        </div>

        <div class="product-grid" id="product-grid">
            @foreach($products as $product)
                <button
                    type="button"
                    class="product-card"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->nama_produk }}"
                    data-price="{{ $product->harga }}"
                    data-stock="{{ $product->stok }}"
                    data-category="{{ $product->category->name ?? '' }}"
                    @disabled($product->stok < 1)
                >
                    <span class="product-name">
                        {{ $product->nama_produk }}
                    </span>

                    <span class="product-price">
                        {{ number_format($product->harga, 0, ',', '.') }}
                    </span>

                    <span class="product-stock">
                        Stok: {{ $product->stok }}
                    </span>
                </button>
            @endforeach
        </div>
    </section>

    <section class="cart-area">
        <div class="cart-header">Keranjang</div>

        <div class="cart-items" id="cart-items">
            <p class="cart-empty">Belum ada produk dipilih.</p>
        </div>

        <div class="cart-footer">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span id="subtotal-display">Rp 0</span>
            </div>

            <div class="summary-row">
                <span>Pajak 10%:</span>
                <span id="tax-display">Rp 0</span>
            </div>

            <div class="total-row">
                <span>TOTAL:</span>
                <span id="total-display">Rp 0</span>
            </div>

            <label class="payment-label" for="input-bayar">
                Bayar:
            </label>

            <input
                type="text"
                inputmode="numeric"
                id="input-bayar"
                class="form-control-bauhaus"
                placeholder="Masukkan uang pembayaran"
                autocomplete="off"
            >

            <div class="change-row">
                <span>Kembali:</span>
                <span id="kembalian-display">Rp 0</span>
            </div>

            <div id="pos-message" class="pos-message" role="status"></div>

            <button
                type="button"
                class="btn-checkout"
                id="btn-bayar"
                onclick="prosesTransaksi()"
            >
                BAYAR
            </button>

            <button
                type="button"
                class="btn-cancel"
                onclick="batalTransaksi()"
            >
                BATAL
            </button>
        </div>
    </section>
</div>

<script>
    const cart = [];
    let subtotal = 0;
    let pajak = 0;
    let totalHarga = 0;

    const rupiah = angka =>
        'Rp ' + Math.round(angka).toLocaleString('id-ID');

    const inputBayar = document.getElementById('input-bayar');
    const pesan = document.getElementById('pos-message');

    function formatRupiah(input) {
        const angka = input.value.replace(/\D/g, '');

        input.value = angka
            ? Number(angka).toLocaleString('id-ID')
            : '';
    }

    function jumlahBayar() {
        return Number(inputBayar.value.replace(/\D/g, '')) || 0;
    }

    function addToCart(id, nama, harga, stok) {
        id = Number(id);
        harga = Number(harga);
        stok = Number(stok);

        const item = cart.find(p => p.id === id);

        if (item) {
            if (item.jumlah >= stok) {
                pesan.textContent = 'Stok tidak mencukupi!';
                return;
            }

            item.jumlah++;
        } else {
            if (stok < 1) {
                pesan.textContent = 'Stok produk habis!';
                return;
            }

            cart.push({
                id,
                nama,
                harga,
                jumlah: 1,
                stok
            });
        }

        pesan.textContent = '';
        renderCart();
    }

    document.querySelectorAll('.product-card').forEach(button => {
        button.addEventListener('click', () => {
            addToCart(
                button.dataset.id,
                button.dataset.name,
                button.dataset.price,
                button.dataset.stock
            );
        });
    });

    function renderCart() {
        const container = document.getElementById('cart-items');

        container.replaceChildren();
        subtotal = 0;

        if (cart.length === 0) {
            const empty = document.createElement('p');
            empty.className = 'cart-empty';
            empty.textContent = 'Belum ada produk dipilih.';
            container.appendChild(empty);
        }

        cart.forEach((item, index) => {
            subtotal += item.harga * item.jumlah;

            const row = document.createElement('div');
            row.className = 'cart-item';

            const info = document.createElement('div');
            info.className = 'cart-item-info';

            const name = document.createElement('div');
            name.textContent = `${item.nama} x${item.jumlah}`;

            const price = document.createElement('small');
            price.textContent = rupiah(item.harga);

            info.append(name, price);

            const right = document.createElement('div');
            right.className = 'cart-item-right';

            const lineTotal = document.createElement('div');
            lineTotal.className = 'cart-item-total';
            lineTotal.textContent = rupiah(item.harga * item.jumlah);

            const controls = document.createElement('div');
            controls.className = 'cart-item-controls';

            const minus = document.createElement('button');
            minus.type = 'button';
            minus.className = 'btn-qty';
            minus.textContent = '−';
            minus.setAttribute('aria-label', 'Kurangi jumlah');
            minus.onclick = () => ubahJumlah(index, -1);

            const quantity = document.createElement('span');
            quantity.textContent = item.jumlah;

            const plus = document.createElement('button');
            plus.type = 'button';
            plus.className = 'btn-qty plus';
            plus.textContent = '+';
            plus.setAttribute('aria-label', 'Tambah jumlah');
            plus.onclick = () => ubahJumlah(index, 1);

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'btn-remove';
            remove.textContent = '×';
            remove.title = 'Hapus produk';
            remove.setAttribute('aria-label', 'Hapus produk');

            remove.onclick = () => {
                cart.splice(index, 1);
                pesan.textContent = '';
                renderCart();
            };

            controls.append(minus, quantity, plus, remove);
            right.append(lineTotal, controls);
            row.append(info, right);
            container.appendChild(row);
        });

        pajak = Math.round(subtotal * 0.10);
        totalHarga = subtotal + pajak;

        document.getElementById('subtotal-display').textContent =
            rupiah(subtotal);

        document.getElementById('tax-display').textContent =
            rupiah(pajak);

        document.getElementById('total-display').textContent =
            rupiah(totalHarga);

        hitungKembalian();
    }

    function ubahJumlah(index, perubahan) {
        const item = cart[index];

        if (!item) return;

        const jumlahBaru = item.jumlah + perubahan;

        if (jumlahBaru <= 0) {
            cart.splice(index, 1);
        } else if (jumlahBaru > item.stok) {
            pesan.textContent = 'Stok tidak mencukupi!';
            return;
        } else {
            item.jumlah = jumlahBaru;
        }

        pesan.textContent = '';
        renderCart();
    }

    function hitungKembalian() {
        const kembalian = Math.max(
            0,
            jumlahBayar() - totalHarga
        );

        document.getElementById('kembalian-display').textContent =
            rupiah(kembalian);
    }

    inputBayar.addEventListener('input', () => {
        formatRupiah(inputBayar);
        hitungKembalian();
    });

    function batalTransaksi() {
        if (
            cart.length &&
            !confirm('Kosongkan keranjang transaksi ini?')
        ) {
            return;
        }

        cart.length = 0;
        inputBayar.value = '';
        pesan.textContent = '';

        renderCart();
    }

    /* PENCARIAN DAN FILTER KATEGORI */
    document
        .getElementById('product-search')
        .addEventListener('input', filterProduk);

    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.toggle('active', btn === button);
            });

            filterProduk();
        });
    });

    function filterProduk() {
        const query = document.getElementById('product-search')
            .value.trim().toLowerCase();

        const active = document.querySelector('.filter-btn.active')
            ?.dataset.category || 'all';

        document.querySelectorAll('.product-card').forEach(button => {
            const nama = button.dataset.name.toLowerCase();
            const kategori = button.dataset.category || '';

            const cocokNama = nama.includes(query);

            let cocokKategori = true;

            if (active === 'other') {
                cocokKategori = kategori === '';
            } else if (active !== 'all') {
                cocokKategori = kategori === active;
            }

            button.hidden = !(cocokNama && cocokKategori);
        });
    }

    /* CHECKOUT: ROUTE DAN ALUR ASLI DIPERTAHANKAN */
    async function prosesTransaksi() {
        if (!cart.length) {
            pesan.textContent = 'Keranjang masih kosong!';
            return;
        }

        const bayar = jumlahBayar();

        if (bayar < totalHarga) {
            pesan.textContent = 'Uang pembayaran kurang!';
            return;
        }

        const button = document.getElementById('btn-bayar');

        button.disabled = true;
        button.textContent = 'MEMPROSES...';
        pesan.textContent = '';

        try {
            const response = await fetch(
                @json(route('kasir.store')),
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': @json(csrf_token())
                    },
                    body: JSON.stringify({
                        cart: cart.map(item => ({
                            id: item.id,
                            jumlah: item.jumlah,
                            harga: item.harga,
                            nama: item.nama
                        })),
                        bayar: bayar
                    })
                }
            );

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(
                    data.message || 'Transaksi gagal diproses.'
                );
            }

            window.location.href =
                @json(url('/kasir/receipt')) + '/' + data.sale_id;

        } catch (error) {
            pesan.textContent =
                error.message || 'Terjadi kesalahan sistem.';
        } finally {
            button.disabled = false;
            button.textContent = 'BAYAR';
        }
    }

    renderCart();
</script>
@endsection
