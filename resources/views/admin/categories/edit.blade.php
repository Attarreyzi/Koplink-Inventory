@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
    <a href="{{ route('admin.categories.index') }}" class="btn" style="background:#333333; color:#ffffff; border:none;">Kembali</a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required autofocus>
            @error('name') <div style="color: #ef4444; font-size: 0.85rem; margin-top: 5px;">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn" style="width: 100%;">UPDATE KATEGORI</button>
    </form>
</div>
@endsection
