@extends('layouts.admin')

@section('title', 'Stok ' . ucfirst($type) . ' - ' . $product->name)

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
    <a href="{{ route('admin.products.index') }}" class="btn" style="background:#333333; color:#ffffff; border:none;">Kembali</a>
</div>

<div class="card" style="max-width: 500px;">
    
    <div style="margin-bottom: 1.5rem; padding: 1.5rem; background: var(--bg-color); border: 1px solid var(--border-color); border-radius: 12px; text-align: center;">
        <div style="color: var(--secondary-accent); font-size: 0.9rem; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em;">Stok Saat Ini</div>
        <div style="font-size: 3rem; font-weight: 800; color: var(--text-color); line-height: 1;">{{ $product->stock }}</div>
    </div>

    @if($errors->any())
        <div style="color: var(--danger); margin-bottom: 1rem; font-weight: 600;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.stock.store', [$product->id, $type]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Jumlah (Quantity)</label>
            <input type="number" name="quantity" class="form-control" required min="1" max="999">
        </div>

        <div class="form-group">
            <label>Catatan</label>
            <input type="text" name="note" class="form-control" value="Stok {{ $type == 'in' ? 'masuk' : 'keluar' }}" required>
        </div>

        <button type="submit" class="btn" style="width: 100%; border: 1px solid var(--primary-accent); {{ $type == 'out' ? 'background: #ffffff; color: #000000;' : '' }}">
            {{ $type == 'in' ? 'Tambahkan Stok' : 'Kurangi Stok' }}
        </button>
    </form>
</div>
@endsection
