@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
    <a href="{{ route('admin.categories.index') }}" class="btn" style="background:#333333; color:#ffffff; border:none;">Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Non Coffee" required autofocus>
            @error('name') <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn" style="width: 100%;">SIMPAN KATEGORI</button>
    </form>
</div>
@endsection
