@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
{{-- Tombol Kembali --}}
<div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
    <a href="{{ route('admin.products.index') }}" class="btn" style="background:#333333; color:#ffffff; border:none;">Kembali</a>
</div>

{{-- Form Edit Data Produk --}}
<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        {{-- Input Nama Produk --}}
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        
        {{-- Pilihan Kategori --}}
        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        {{-- Input Harga Modal & Harga Jual --}}
        <div class="form-row">
            <div class="form-group">
                <label>Harga Modal (Beli)</label>
                <input type="number" name="purchase_price" class="form-control" value="{{ $product->purchase_price }}" required min="0">
            </div>
            <div class="form-group">
                <label>Harga Jual</label>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required min="0">
            </div>
        </div>

        {{-- Preview Foto Produk Saat Ini --}}
        @if($product->image)
        <div class="form-group">
            <label>Foto Saat Ini</label><br>
            <img src="{{ str_starts_with($product->image, 'products/') ? url('/img-view/' . $product->image) : asset($product->image) }}" alt="{{ $product->name }}" style="max-width: 150px; border-radius: 8px; margin-bottom: 10px; border: 1px solid rgba(255,255,255,0.1)">
        </div>
        @endif

        {{-- Upload Foto Baru --}}
        <div class="form-group">
            <label>Ganti Foto (Opsional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        {{-- Deskripsi Produk --}}
        <div class="form-group">
            <label>Deskripsi (Opsional)</label>
            <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
        </div>

        {{-- Catatan Pengubahan Stok --}}
        <div style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 20px;">
            * Stok tidak dapat diubah dari sini. Silakan gunakan fitur Stok Masuk / Keluar.
        </div>

        {{-- Tombol Submit Update --}}
        <button type="submit" class="btn">Update Produk</button>
    </form>
</div>
@endsection

