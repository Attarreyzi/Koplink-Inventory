@extends('layouts.admin')

@section('title', 'Riwayat Stok')

@section('content')
{{-- Tabel Riwayat Mutasi Stok (Barang Masuk / Keluar) --}}
<div class="card">
    <table>
        <thead>
            <tr>
                <th style="width: 35%; text-align: left;">Produk</th>
                <th style="width: 20%; text-align: left;">Waktu</th>
                <th style="width: 25%; text-align: center;">Jumlah</th>
                <th style="width: 20%; text-align: left;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr>
                {{-- Nama Produk & Thumbnail --}}
                <td data-label="Produk">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        @if($t->product && $t->product->image)
                            <img src="{{ str_starts_with($t->product->image, 'products/') ? url('/img-view/' . $t->product->image) : asset($t->product->image) }}" alt="" style="width: 35px; height: 35px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1);">
                        @else
                            <div style="width: 35px; height: 35px; background: #222; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.5rem; color: #555;">No Img</div>
                        @endif
                        <span>{{ $t->product->name ?? 'Produk Terhapus' }}</span>
                    </div>
                </td>
                
                {{-- Waktu Transaksi --}}
                <td data-label="Waktu"><div class="val-wrap"><span>{{ $t->created_at->format('d M Y H:i') }}</span></div></td>
                
                {{-- Jumlah Mutasi Stok (+ / -) --}}
                <td data-label="Jumlah" style="text-align: center;">
                    <div class="val-wrap">
                        <strong style="font-size: 1.1rem; color: {{ $t->type == 'in' ? 'var(--text-color)' : 'var(--secondary-accent)' }};">
                            {{ $t->type == 'in' ? '+' : '-' }}{{ $t->quantity }}
                        </strong>
                    </div>
                </td>

                {{-- Catatan Transaksi --}}
                <td data-label="Catatan">
                    <div class="val-wrap">
                        <span style="color: var(--secondary-accent);">{{ $t->note ?: '-' }}</span>
                    </div>
                </td>
            </tr>
            @empty
            {{-- State Jika Belum Ada Riwayat --}}
            <tr>
                <td colspan="4" style="text-align: center; color: var(--secondary-accent); padding: 2rem 0;">Belum ada riwayat pergerakan stok.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

