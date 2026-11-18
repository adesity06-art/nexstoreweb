@extends('layouts.app')

@section('title', 'Edit Produk')

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
</style>

<h2 style="font-weight: 900; text-transform: uppercase; margin-bottom: 20px;">Edit Produk</h2>

<div class="form-container">
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Kode Produk</label>
            <input type="text" name="kode_produk" class="form-control-bauhaus" value="{{ $product->kode_produk }}" required>
        </div>
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control-bauhaus" value="{{ $product->nama_produk }}" required>
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" class="form-control-bauhaus" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="form-control-bauhaus" value="{{ $product->harga }}" required>
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control-bauhaus" value="{{ $product->stok }}" required>
        </div>
        
        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button type="submit" class="btn-bauhaus btn-primary">Update Produk</button>
            <a href="{{ route('products.index') }}" class="btn-bauhaus btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection