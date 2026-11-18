@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<style>
    .form-container {
        background: #FFF;
        border: 4px solid #111;
        box-shadow: 6px 6px 0px #111;
        padding: 30px;
        max-width: 600px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .form-control-bauhaus {
        width: 100%;
        padding: 12px;
        border: 3px solid #111;
        font-family: 'Jost', sans-serif;
        font-size: 1rem;
        background: #F1FAEE;
    }
    .form-control-bauhaus:focus {
        outline: none;
        background: #FFF;
        box-shadow: 4px 4px 0px #111;
        transform: translate(-2px, -2px);
    }
    .btn-bauhaus {
        padding: 12px 20px;
        border: 3px solid #111;
        font-family: 'Jost', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        box-shadow: 4px 4px 0px #111;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }
    .btn-bauhaus:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0px #111;
    }
    .btn-primary { background: #1D3557; color: white; }
    .btn-secondary { background: #F4A261; color: #111; }
    .alert-danger {
        background: #FEE2E2;
        color: #991B1B;
        border: 3px solid #991B1B;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 4px 4px 0px #991B1B;
    }
</style>

<h2 style="font-weight: 900; text-transform: uppercase; margin-bottom: 20px;">Tambah Produk Baru</h2>

@if ($errors->any())
    <div class="alert-danger">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-container">
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Kode Produk</label>
            <input type="text" name="kode_produk" class="form-control-bauhaus" value="{{ old('kode_produk') }}" required placeholder="Contoh: PRD-006">
        </div>
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control-bauhaus" value="{{ old('nama_produk') }}" required placeholder="Contoh: Susu UHT">
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" class="form-control-bauhaus" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="form-control-bauhaus" value="{{ old('harga') }}" required placeholder="Contoh: 5000">
        </div>
        <div class="form-group">
            <label>Stok Awal</label>
            <input type="number" name="stok" class="form-control-bauhaus" value="{{ old('stok') }}" required placeholder="Contoh: 50">
        </div>
        
        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button type="submit" class="btn-bauhaus btn-primary">Simpan Produk</button>
            <a href="{{ route('products.index') }}" class="btn-bauhaus btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection