@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
    <a href="{{ route('admin.products.create') }}" class="btn">Tambah Produk</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $p)
            <tr>
                <td data-label="Produk">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        @if($p->image)
                            <img src="{{ str_starts_with($p->image, 'products/') ? url('/img-view/' . $p->image) : asset($p->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                        @else
                            <div style="width: 50px; height: 50px; background: #222; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.6rem; color: #555; border: 1px solid rgba(255,255,255,0.1);">No Img</div>
                        @endif
                        <div>
                            <strong>{{ $p->name }}</strong><br>
                            <small style="color: var(--secondary-accent)">{{ $p->description }}</small>
                        </div>
                    </div>
                </td>
                <td data-label="Kategori"><div class="val-wrap"><span>{{ $p->category->name ?? '-' }}</span></div></td>
                <td data-label="Harga Modal"><div class="val-wrap"><span>Rp {{ number_format($p->purchase_price, 0, ',', '.') }}</span></div></td>
                <td data-label="Harga Jual"><div class="val-wrap"><span>Rp {{ number_format($p->price, 0, ',', '.') }}</span></div></td>
                <td data-label="Stok" class="stok-cell">
                    <div class="stok-number val-wrap">
                        <span style="font-size: 1.2rem; font-weight: 800;">{{ $p->stock }}</span>
                    </div>
                    <div class="stok-buttons" style="display: flex; gap: 6px;">
                        <a href="{{ route('admin.stock.form', [$p->id, 'in']) }}" style="color:#ffffff; font-size:0.75rem; text-decoration:none; background:#333333; padding:4px 10px; border-radius:6px; font-weight:700; white-space:nowrap;">+ IN</a>
                        <a href="{{ route('admin.stock.form', [$p->id, 'out']) }}" style="color:#000000; font-size:0.75rem; text-decoration:none; background:#e5e5e5; padding:4px 10px; border-radius:6px; font-weight:700; white-space:nowrap;">- OUT</a>
                    </div>
                </td>
                <td data-label="Aksi">
                    <div class="val-wrap">
                        <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-sm" style="background:transparent; border: 1px solid var(--border-color); color:var(--text-color); padding: 0.6rem 1rem;">Edit</a>
                        <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" class="delete-form" style="display: inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" style="padding: 0.6rem 1rem;">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--secondary-accent); padding: 2rem 0;">Belum ada produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
