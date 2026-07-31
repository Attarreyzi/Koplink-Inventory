@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
    <a href="{{ route('admin.products.index') }}" class="btn" style="background:#333333; color:#ffffff; border:none;">Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Harga Modal (Beli)</label>
                <input type="number" name="purchase_price" class="form-control" required min="0" placeholder="Contoh: 10000">
            </div>
            <div class="form-group">
                <label>Harga Jual</label>
                <input type="number" name="price" class="form-control" required min="0" placeholder="Contoh: 15000">
            </div>
        </div>

        <div class="form-group">
            <label>Stok Awal</label>
            <input type="number" name="stock" class="form-control" value="0" required min="0">
        </div>

        <div class="form-group">
            <label>Foto Produk (Opsional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="form-group">
            <label>Deskripsi (Opsional)</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn">Simpan Produk</button>
    </form>
</div>
@endsection
