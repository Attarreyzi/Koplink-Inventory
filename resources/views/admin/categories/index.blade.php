@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
    <a href="{{ route('admin.categories.create') }}" class="btn">Tambah Kategori</a>
</div>



<div class="card">
    <table>
        <thead>
            <tr>
                <th style="width: 20%; text-align: left;">Kategori</th>
                <th style="width: 50%; text-align: left;">Daftar Produk</th>
                <th style="width: 15%; text-align: center;">Jumlah Produk</th>
                <th style="text-align: center; width: 15%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td data-label="Kategori" style="vertical-align: middle;">
                        <strong>{{ $category->name }}</strong>
                    </td>
                    <td data-label="Daftar Produk" class="stack-on-mobile" style="vertical-align: middle; padding: 1rem 0;">
                        <div class="val-wrap" style="width: 100%;">
                            @if($category->products->isEmpty())
                                <span style="color: #64748b; font-style: italic;">Tidak ada produk</span>
                            @else
                                <div class="product-pills">
                                    @foreach($category->products as $product)
                                        <span style="display: inline-block; background: rgba(255, 255, 255, 0.05); color: var(--text-color); padding: 0.3rem 0.7rem; border-radius: 6px; font-size: 0.85rem; border: 1px solid var(--border-color); font-weight: 600;">
                                            {{ $product->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </td>
                    <td data-label="Jumlah Produk" style="text-align: center; vertical-align: middle;">
                        <div class="val-wrap">
                            <span style="font-weight: 600;">{{ $category->products_count }}</span>
                        </div>
                    </td>
                    <td data-label="Aksi" style="text-align: center; vertical-align: middle;">
                        <div class="val-wrap" style="grid-template-columns: 1fr;">
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="delete-form" style="display: block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="padding: 0.6rem 1rem;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem; color: #94a3b8; font-style: italic;">
                        Belum ada data kategori yang ditambahkan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
