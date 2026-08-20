@extends('layouts.admin')

@section('title', 'Laporan Inventory')

@section('content')
<div class="card filter-form">
    <form action="{{ route('admin.reports.index') }}" method="GET">
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 5px; color: #94a3b8; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; margin-bottom: 5px; color: #94a3b8; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
        </div>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <button type="submit" class="btn" style="flex: 1; min-width: 150px;">TAMPILKAN</button>
            <button type="button" onclick="downloadPDF()" class="btn" style="flex: 1; min-width: 150px; background-color: var(--success); color: white; border: none;">CETAK LAPORAN (PDF)</button>
        </div>
    </form>
</div>

<div id="report-to-print">
    <!-- Halaman Utama (Tampilan di Web - Tetap Dark Mode) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card" style="margin-bottom: 0;">
            <div style="color: #94a3b8; font-size: 0.9rem; text-transform: uppercase;">Total Omset</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: var(--text-color);">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
        </div>
        <div class="card" style="margin-bottom: 0;">
            <div style="color: #10b981; font-size: 0.9rem; text-transform: uppercase;">Total Keuntungan</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: #10b981;">
                Rp {{ number_format($totalProfit, 0, ',', '.') }}
            </div>
        </div>
        <div class="card" style="margin-bottom: 0;">
            <div style="color: #94a3b8; font-size: 0.9rem; text-transform: uppercase;">Stok Keluar</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: var(--primary-accent);">
                {{ $stockOutCount }} Item
            </div>
        </div>
        <div class="card" style="margin-bottom: 0;">
            <div style="color: #94a3b8; font-size: 0.9rem; text-transform: uppercase;">Stok Masuk</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: var(--primary-accent);">
                {{ $stockInCount }} Item
            </div>
        </div>
    </div>

    <style>
        /* Memaksa tabel web view tetap berbentuk tabel normal di HP (tidak jadi card) */
        .table-responsive-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
            border-radius: 8px;
        }
        @media (max-width: 768px) {
            table.force-normal-table { display: table !important; width: 100% !important; min-width: 700px !important; }
            table.force-normal-table thead { display: table-header-group !important; }
            table.force-normal-table tbody { display: table-row-group !important; }
            table.force-normal-table tr { display: table-row !important; margin: 0 !important; border-bottom: 1px solid rgba(255,255,255,0.1) !important; padding: 0 !important; }
            table.force-normal-table th, table.force-normal-table td { display: table-cell !important; padding: 12px 15px !important; border: none !important; border-bottom: 1px solid rgba(255,255,255,0.05) !important; }
            table.force-normal-table td::before { display: none !important; }
            table.force-normal-table td .val-wrap { display: block !important; text-align: left !important; padding: 0 !important; background: transparent !important; }
        }
    </style>

    <div class="card">
        <h2 style="margin-top: 0; margin-bottom: 15px;">Daftar Semua Transaksi</h2>
        <div class="table-responsive-scroll">
            <table class="force-normal-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">PRODUK</th>
                        <th style="width: 15%;">WAKTU</th>
                        <th style="text-align: center; width: 10%;">JENIS</th>
                        <th style="text-align: center; width: 10%;">JUMLAH</th>
                        <th style="text-align: right; width: 20%;">HARGA SATUAN</th>
                        <th style="text-align: right; width: 20%;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr>
                        <td data-label="Produk">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                @if($t->product && $t->product->image)
                                    <img src="{{ str_starts_with($t->product->image, 'products/') ? url('/img-view/' . $t->product->image) : asset($t->product->image) }}" alt="" style="width: 35px; height: 35px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1);">
                                @else
                                    <div style="width: 35px; height: 35px; background: #222; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.5rem; color: #555;">No Img</div>
                                @endif
                                <strong style="white-space: nowrap;">{{ $t->product->name ?? 'Produk' }}</strong>
                            </div>
                        </td>
                        <td data-label="Waktu"><div class="val-wrap"><span style="white-space: nowrap;">{{ $t->created_at->format('d/m/Y H:i') }}</span></div></td>
                        <td data-label="Jenis" style="text-align: center;">
                            <div class="val-wrap">
                                @if($t->type == 'in')
                                    <span style="background: #333333; color: #ffffff; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; white-space: nowrap;">MASUK</span>
                                @else
                                    <span style="background: #e5e5e5; color: #000000; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; white-space: nowrap;">KELUAR</span>
                                @endif
                            </div>
                        </td>
                        <td data-label="Jumlah" style="text-align: center;"><div class="val-wrap"><span>{{ $t->quantity }}</span></div></td>
                        <td data-label="Harga Satuan" style="text-align: right;">
                            <div class="val-wrap">
                                <span style="white-space: nowrap; font-size: 0.9rem; color: var(--secondary-accent);">
                                    Rp {{ number_format($t->type == 'in' ? ($t->product->purchase_price ?? 0) : ($t->product->price ?? 0), 0, ',', '.') }}
                                </span>
                            </div>
                        </td>
                        <td data-label="Total" style="text-align: right;">
                            <div class="val-wrap">
                                @php
                                    $price = $t->type == 'in' ? ($t->product->purchase_price ?? 0) : ($t->product->price ?? 0);
                                    $total = $price * $t->quantity;
                                @endphp
                                <strong style="font-size: 1.1rem; color: {{ $t->type == 'in' ? 'var(--secondary-accent)' : 'var(--text-color)' }}; white-space: nowrap;">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </strong>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--secondary-accent); padding: 2rem 0;">Tidak ada data transaksi untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


</div>

<!-- Template Khusus PDF (Hidden, White Theme) -->
<div id="pdf-template" style="display: none;">
    <div id="pdf-content-wrapper" style="width: 700px; box-sizing: border-box; color: black; background: white; font-family: Arial, sans-serif;">
        <style>
            
            #pdf-content-wrapper table, #pdf-content-wrapper table * { box-sizing: border-box; }
            #pdf-content-wrapper table { display: table !important; width: 100% !important; margin: 0 !important; border-collapse: collapse !important; }
            #pdf-content-wrapper thead { display: table-header-group !important; }
            #pdf-content-wrapper tbody { display: table-row-group !important; }
            #pdf-content-wrapper tr { display: table-row !important; border: none !important; background: transparent !important; margin: 0 !important; padding: 0 !important; border-radius: 0 !important; box-shadow: none !important; }
            #pdf-content-wrapper th, #pdf-content-wrapper td { display: table-cell !important; border: 1px solid #ddd !important; padding: 8px !important; text-align: left; }
            #pdf-content-wrapper th { background: #f8f9fa !important; font-weight: bold !important; color: black !important; }
            #pdf-content-wrapper td::before { display: none !important; } /* Hide mobile data-labels */
            #pdf-content-wrapper td .val-wrap { display: inline !important; padding: 0 !important; background: transparent !important; }
        </style>
        <div style="text-align: center; border-bottom: 2px solid black; padding-bottom: 10px; margin-bottom: 20px;">
            <h1 style="margin: 0; font-size: 24px;">LAPORAN DATA PENJUALAN</h1>
            <h2 style="margin: 5px 0; font-size: 18px;">KOPLINK</h2>
            <p style="margin: 0;">Periode: {{ request('start_date') ? date('d/m/Y', strtotime(request('start_date'))) : '-' }} s/d {{ request('end_date') ? date('d/m/Y', strtotime(request('end_date'))) : '-' }}</p>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 20px; gap: 10px;">
            <div style="border: 1px solid #ddd; padding: 10px; flex: 1; text-align: center;">
                <p style="margin: 0; font-size: 12px; color: #666;">TOTAL OMSET</p>
                <p style="margin: 5px 0; font-size: 16px; font-weight: bold;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div style="border: 1px solid #ddd; padding: 10px; flex: 1; text-align: center;">
                <p style="margin: 0; font-size: 12px; color: #666;">TOTAL KEUNTUNGAN</p>
                <p style="margin: 5px 0; font-size: 16px; font-weight: bold; color: black;">Rp {{ number_format($totalProfit, 0, ',', '.') }}</p>
            </div>
            <div style="border: 1px solid #ddd; padding: 10px; flex: 1; text-align: center;">
                <p style="margin: 0; font-size: 12px; color: #666;">STOK KELUAR</p>
                <p style="margin: 5px 0; font-size: 16px; font-weight: bold;">{{ $stockOutCount }}</p>
            </div>
            <div style="border: 1px solid #ddd; padding: 10px; flex: 1; text-align: center;">
                <p style="margin: 0; font-size: 12px; color: #666;">STOK MASUK</p>
                <p style="margin: 5px 0; font-size: 16px; font-weight: bold;">{{ $stockInCount }}</p>
            </div>
        </div>

        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 5px;">Detail Semua Transaksi</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 12px; color: black; table-layout: fixed;">
            <thead>
                <tr style="background: #f8f9fa; color: black;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; width: 25%;">PRODUK</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; width: 15%;">WAKTU</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 10%;">JENIS</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 10%;">JUMLAH</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: right; width: 20%;">HARGA SATUAN</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: right; width: 20%;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                @php
                    $price = $t->type == 'in' ? ($t->product->purchase_price ?? 0) : ($t->product->price ?? 0);
                    $total = $price * $t->quantity;
                @endphp
                <tr style="background: #ffffff; color: #000000;">
                    <td style="border: 1px solid #ddd; padding: 8px; background: #ffffff; color: #000000; overflow: hidden; text-overflow: ellipsis;">
                        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $t->product->name ?? '-' }}</span>
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px; background: #ffffff; color: #000000;">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center; background: #ffffff; color: #000000;">
                        {{ $t->type == 'in' ? 'MASUK' : 'KELUAR' }}
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center; background: #ffffff; color: #000000;">{{ $t->quantity }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right; background: #ffffff; color: #000000;">Rp {{ number_format($price, 0, ',', '.') }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right; background: #ffffff; color: #000000;">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 30px; text-align: right; font-size: 12px;">
            <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
            <br><br>
            <p>( ____________________ )</p>
            <p>Admin Koplink</p>
        </div>
    </div>
</div>

<script>
    function showWarningToast(message) {
        let toast = document.getElementById('warning-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'warning-toast';
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.backgroundColor = '#ef4444';
            toast.style.color = '#ffffff';
            toast.style.padding = '12px 24px';
            toast.style.borderRadius = '8px';
            toast.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.5), 0 4px 6px -2px rgba(0, 0, 0, 0.5)';
            toast.style.zIndex = '9999';
            toast.style.fontFamily = "'Outfit', sans-serif";
            toast.style.fontWeight = '600';
            toast.style.fontSize = '0.9rem';
            toast.style.transition = 'all 0.3s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            document.body.appendChild(toast);
        }
        
        toast.innerText = message;
        
        // Show the toast
        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);
        
        // Hide the toast after 3 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
        }, 3000);
    }

    function downloadPDF() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (!startDate || !endDate) {
            showWarningToast('Silakan isi Tanggal Mulai dan Tanggal Selesai terlebih dahulu!');
            return;
        }

        // Check if url query params match current input values
        const urlParams = new URLSearchParams(window.location.search);
        const queryStart = urlParams.get('start_date');
        const queryEnd = urlParams.get('end_date');

        if (startDate !== queryStart || endDate !== queryEnd) {
            showWarningToast('Silakan klik TAMPILKAN terlebih dahulu untuk memperbarui data laporan!');
            return;
        }

        const element = document.getElementById('pdf-template');
        element.style.display = 'block'; // Tampilkan sementara
        
        // Buat elemen berada di luar layar tapi ter-render sempurna
        element.style.position = 'absolute';
        element.style.top = '0';
        element.style.left = '0';
        element.style.zIndex = '-9999';

        const opt = {
            margin:       10, // Margin kertas 10mm
            filename:     `Laporan_Penjualan_Koplink_Periode_${startDate}_s_d_${endDate}.pdf`,
            image:        { type: 'jpeg', quality: 1 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        const targetContent = document.getElementById('pdf-content-wrapper');

        html2pdf().set(opt).from(targetContent).save().then(() => {
            element.style.display = 'none'; // Sembunyikan kembali
            element.style.position = 'static';
        });
    }
</script>
@endsection
