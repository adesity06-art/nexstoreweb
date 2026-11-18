
@extends('layouts.app')

@section('title', 'Kelola Produk')

@section('content')
<style>
    /* =====================================
       NEXSTORE - BAUHAUS THEME
    ===================================== */

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .search-box {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .form-control-bauhaus {
        padding: 12px 15px;
        border: 3px solid #111;
        background: #FFF;
        font-family: 'Jost', sans-serif;
        font-size: 1rem;
        font-weight: 500;
        box-shadow: 4px 4px 0 #111;
        transition: all 0.2s ease;
    }

    .form-control-bauhaus:focus {
        outline: none;
        box-shadow: 6px 6px 0 #111;
        transform: translate(-2px, -2px);
    }

    .btn-bauhaus {
        padding: 12px 20px;
        border: 3px solid #111;
        font-family: 'Jost', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        box-shadow: 4px 4px 0 #111;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        box-sizing: border-box;
    }

    .btn-bauhaus:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0 #111;
    }

    .btn-primary {
        background: #1D3557;
        color: #FFF;
    }

    .btn-success {
        background: #F4A261;
        color: #111;
    }

    .btn-danger {
        background: #E63946;
        color: #FFF;
    }

    .btn-warning {
        background: #F4A261;
        color: #111;
    }

    /* =====================================
       TABEL PRODUK
    ===================================== */

    .table-container {
        background: #FFF;
        border: 4px solid #111;
        box-shadow: 6px 6px 0 #111;
        overflow-x: auto;
    }

    .table-bauhaus {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
    }

    .table-bauhaus th {
        text-align: left;
        padding: 15px 20px;
        font-weight: 900;
        text-transform: uppercase;
        border-bottom: 4px solid #111;
        background-color: #1D3557;
        color: #FFF;
    }

    .table-bauhaus td {
        padding: 15px 20px;
        border-bottom: 2px solid #111;
        font-weight: 500;
        color: #111;
        vertical-align: middle;
    }

    .table-bauhaus tbody tr:hover {
        background: #FFF4E8;
    }

    .table-bauhaus tbody tr:last-child td {
        border-bottom: none;
    }

    /* =====================================
       TOMBOL EDIT DAN HAPUS
       SELALU MENDATAR
    ===================================== */

    .table-bauhaus th:last-child,
    .table-bauhaus td:last-child {
        width: 180px;
        min-width: 180px;
        white-space: nowrap;
        text-align: center;
    }

    .action-buttons {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .action-buttons .btn-bauhaus {
        display: inline-flex;
        flex: 0 0 65px;
        width: 65px;
        min-width: 65px;
        height: 36px;
        padding: 0;
        margin: 0;
        font-size: 0.75rem;
        line-height: 1;
    }

    .action-buttons form {
        display: inline-flex;
        flex: 0 0 auto;
        margin: 0;
        padding: 0;
    }

    /* =====================================
       NOTIFIKASI
    ===================================== */

    .alert-success {
        background: #F4A261;
        border: 3px solid #111;
        padding: 15px;
        margin-bottom: 20px;
        font-weight: 700;
        box-shadow: 4px 4px 0 #111;
    }

    /* =====================================
       PAGINATION NEXSTORE
    ===================================== */

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 18px;
        margin-top: 25px;
        padding: 18px 20px;
        background: #FFF;
        border: 3px solid #111;
        box-shadow: 5px 5px 0 #111;
        font-family: 'Jost', sans-serif;
    }

    .pagination-info {
        font-size: 0.95rem;
        font-weight: 700;
        color: #111;
    }

    .pagination-info strong {
        color: #1D3557;
    }

    .pagination-nav {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pagination-nav a,
    .pagination-nav span {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        min-width: 40px;
        min-height: 40px;
        padding: 8px 12px;
        border: 2px solid #111;
        background: #FFF;
        color: #111;
        font-size: 0.95rem;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 3px 3px 0 #111;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .pagination-nav a:hover {
        background: #F4A261;
        color: #111;
        transform: translate(-2px, -2px);
        box-shadow: 5px 5px 0 #111;
    }

    .pagination-nav .active-page {
        background: #1D3557;
        color: #FFF;
        border-color: #111;
        box-shadow: 3px 3px 0 #111;
    }

    .pagination-nav .disabled-page {
        background: #E5E5E5;
        color: #999;
        box-shadow: none;
        cursor: not-allowed;
    }

    /* =====================================
       RESPONSIVE
    ===================================== */

    @media (max-width: 768px) {
        .page-header {
            align-items: stretch;
        }

        .search-box {
            width: 100%;
        }

        .search-box .form-control-bauhaus {
            flex: 1;
            min-width: 0;
        }

        .page-header > .btn-bauhaus {
            width: 100%;
        }

        .pagination-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .pagination-nav {
            gap: 6px;
        }

        .pagination-nav a,
        .pagination-nav span {
            min-width: 35px;
            min-height: 35px;
            padding: 6px 9px;
        }
    }
</style>

{{-- =====================================
     HEADER DAN PENCARIAN
===================================== --}}

<div class="page-header">
    <form
        action="{{ route('products.index') }}"
        method="GET"
        class="search-box"
    >
        <input
            type="text"
            name="search"
            class="form-control-bauhaus"
            placeholder="Cari produk..."
            value="{{ $search }}"
        >

        <button type="submit" class="btn-bauhaus btn-primary">
            Cari
        </button>
    </form>

    <a
        href="{{ route('products.create') }}"
        class="btn-bauhaus btn-success"
    >
        + Tambah Produk
    </a>
</div>

{{-- =====================================
     NOTIFIKASI
===================================== --}}

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-success" style="background:#d62828;color:#fff;">
        {{ session('error') }}
    </div>
@endif

{{-- =====================================
     TABEL PRODUK
===================================== --}}

<div class="table-container">
    <table class="table-bauhaus">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $index => $product)
                <tr>
                    <td>
                        {{ $products->firstItem() + $index }}
                    </td>

                    <td>
                        <strong>{{ $product->kode_produk }}</strong>
                    </td>

                    <td>
                        {{ $product->nama_produk }}
                    </td>

                    <td>
                        {{ $product->category->name ?? '-' }}
                    </td>

                    <td>
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $product->stok }}
                    </td>

                    {{-- TOMBOL EDIT DAN HAPUS --}}
                    <td>
                        <div class="action-buttons">
                            <a
                                href="{{ route('products.edit', $product->id) }}"
                                class="btn-bauhaus btn-warning"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('products.destroy', $product->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus produk ini?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn-bauhaus btn-danger"
                                >
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td
                        colspan="7"
                        style="text-align: center; padding: 30px; font-weight: 700;"
                    >
                        Tidak ada produk ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- =====================================
     PAGINATION NEXSTORE
===================================== --}}

<div class="pagination-container">
    <div class="pagination-info">
        @if ($products->total() > 0)
            Menampilkan
            <strong>{{ $products->firstItem() }}</strong>
            sampai
            <strong>{{ $products->lastItem() }}</strong>
            dari
            <strong>{{ $products->total() }}</strong>
            produk
        @else
            Tidak ada produk untuk ditampilkan
        @endif
    </div>

    @if ($products->hasPages())
        <nav
            class="pagination-nav"
            aria-label="Navigasi halaman produk"
        >
            {{-- SEBELUMNYA --}}
            @if ($products->onFirstPage())
                <span class="disabled-page" aria-disabled="true">
                    &laquo; Prev
                </span>
            @else
                <a
                    href="{{ $products->previousPageUrl() }}"
                    rel="prev"
                >
                    &laquo; Prev
                </a>
            @endif

            {{-- NOMOR HALAMAN --}}
            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if ($page == $products->currentPage())
                    <span class="active-page" aria-current="page">
                        {{ $page }}
                    </span>
                @else
                    <a
                        href="{{ $url }}"
                        aria-label="Halaman {{ $page }}"
                    >
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- BERIKUTNYA --}}
            @if ($products->hasMorePages())
                <a
                    href="{{ $products->nextPageUrl() }}"
                    rel="next"
                >
                    Next &raquo;
                </a>
            @else
                <span class="disabled-page" aria-disabled="true">
                    Next &raquo;
                </span>
            @endif
        </nav>
    @endif
</div>

@endsection
