@extends('layouts.admin')

@section('title', 'Dashboard Inventory')

@section('content')
<div class="stat-grid">
    <div class="card" style="margin-bottom: 0;">
        <h3 style="margin-top: 0; color: var(--secondary-accent); font-size: 0.9rem; text-transform: uppercase;">Total Produk</h3>
        <p style="font-size: 2.5rem; font-weight: 800; margin: 0.5rem 0 0 0;">{{ $totalProducts }}</p>
    </div>
    <div class="card" style="margin-bottom: 0;">
        <h3 style="margin-top: 0; color: var(--secondary-accent); font-size: 0.9rem; text-transform: uppercase;">Total Stok</h3>
        <p style="font-size: 2.5rem; font-weight: 800; margin: 0.5rem 0 0 0;">{{ $totalStock }}</p>
    </div>
    <div class="card" style="margin-bottom: 0; border-color: var(--danger);">
        <h3 style="margin-top: 0; color: var(--danger); font-size: 0.9rem; text-transform: uppercase;">Stok Menipis</h3>
        <p style="font-size: 2.5rem; font-weight: 800; margin: 0.5rem 0 0 0; color: var(--danger);">{{ $lowStockItems->count() }}</p>
    </div>
</div>

<div class="dashboard-grid">
    <div class="card">
        <h2 style="margin-top: 0; font-size: 1.25rem;">Stok Menipis (Di Bawah 10)</h2>
        @if($lowStockItems->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Stok Tersisa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockItems as $item)
                        <tr>
                            <td data-label="Produk"><strong>{{ $item->name }}</strong></td>
                            <td data-label="Kategori">{{ $item->category->name ?? '-' }}</td>
                            <td data-label="Stok Tersisa">
                                <div class="val-wrap">
                                    <span style="color: var(--danger); font-weight: 800;">{{ $item->stock }}</span>
                                </div>
                            </td>
                            <td data-label="Aksi">
                                <div class="val-wrap" style="grid-template-columns: 1fr;">
                                    <a href="{{ route('admin.stock.form', [$item->id, 'in']) }}" class="btn btn-sm" style="padding: 0.6rem 1.25rem;">Restock</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: var(--secondary-accent);">Semua stok produk saat ini aman.</p>
        @endif
    </div>

    <div class="card">
        <h2 style="margin-top: 0; font-size: 1.25rem;">Transaksi Terakhir</h2>
        @if($recentTransactions->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($recentTransactions as $tx)
                    <div style="border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                            <strong style="display: block;">{{ $tx->product->name ?? 'Produk Terhapus' }}</strong>
                            <span style="font-weight: 800; color: {{ $tx->type == 'in' ? 'var(--text-color)' : '#a3a3a3' }}">
                                {{ $tx->type == 'in' ? '+' : '-' }}{{ $tx->quantity }}
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--secondary-accent);">
                            <span>{{ $tx->type == 'in' ? 'Barang Masuk' : 'Barang Keluar' }}</span>
                            <span>{{ $tx->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('admin.stock.history') }}" style="display: block; text-align: center; margin-top: 1rem; color: var(--text-color); font-size: 0.85rem;">Lihat Semua Transaksi</a>
        @else
            <p style="color: var(--secondary-accent);">Belum ada histori pergerakan stok.</p>
        @endif
    </div>
</div>
@endsection
