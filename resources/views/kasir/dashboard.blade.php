@extends('layouts.admin')

@section('title', 'Dashboard Kasir')

@section('content')
<h3 class="page-title">Dashboard Kasir</h3>

{{-- ================= RINGKASAN HARI INI ================= --}}
<div class="stats-grid">
    <div class="stat-card">
        <p>Pesanan Hari Ini</p>
        <h2>{{ $totalPesanan }}</h2>
    </div>

    <div class="stat-card">
        <p>Total Transaksi Hari Ini</p>
        <h2>Rp {{ number_format($totalTransaksi,0,',','.') }}</h2>
    </div>

    <div class="stat-card">
        <p>Belum Dibayar</p>
        <h2>{{ $belumDibayar }}</h2>
    </div>

    <div class="stat-card">
        <p>Pesanan Selesai</p>
        <h2>{{ $pesananSelesai }}</h2>
    </div>
</div>

{{-- ================= TRACKING PESANAN ================= --}}
<div class="timeline">

@php
    $statuses = [
        'diterima' => 'fa-truck',
        'dicuci' => 'fa-soap',
        'dikeringkan' => 'fa-sun',
        'disetrika' => 'fa-shirt',
        'selesai' => 'fa-box'
    ];

    $active = request('status');
    $keys = array_keys($statuses);
@endphp

@foreach($statuses as $status => $icon)

@php
    $currentIndex = array_search($status, $keys);
    $activeIndex = array_search($active, $keys);
@endphp

<a href="{{ route('kasir.dashboard',['status'=>$status]) }}"
   class="timeline-step 
   {{ $activeIndex > $currentIndex ? 'completed' : '' }}
   {{ $active == $status ? 'active' : '' }}">

    <div class="icon">
        <i class="fa-solid {{ $icon }}"></i>
    </div>

    <div class="dot"></div>

    <div class="label">
        {{ ucfirst($status) }}
        <div class="count">{{ $statusCounts[$status] ?? 0 }}</div>
    </div>

</a>

@endforeach
</div>

{{-- ================= ANTRIAN PESANAN ================= --}}
<div class="card">
    <h4>Antrian Pesanan</h4>
    <div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Layanan</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($antrianPesanan as $item)
            
            <tr>
                <td>{{ $loop->iteration }}</td>
            @php
    $isSelesai = request('status') == 'selesai';
@endphp

<td>
    @if($isSelesai)
        {{ $item->pemesanan->customer->nama_lengkap ?? '-' }}
    @else
        {{ $item->customer->nama_lengkap ?? '-' }}
    @endif
</td>

<td>
    @if($isSelesai)
        {{ $item->pemesanan->jenis_layanan ?? '-' }}
    @else
        {{ $item->jenis_layanan ?? '-' }}
    @endif
</td>

<td>
    @if($isSelesai)
        Rp {{ number_format($item->pemesanan->total_harga ?? 0,0,',','.') }}
    @else
        Rp {{ number_format($item->total_harga ?? 0,0,',','.') }}
    @endif
</td>
                <td>
                    <span class="badge">
                        {{ ucfirst($item->status_proses ?? 'menunggu') }}
                    </span>
                </td>
                <td class="aksi">
    <div style="display:flex;gap:6px;">

        @php
            $isSelesai = request('status') == 'selesai';
        @endphp

        @if($isSelesai)

            {{-- Data dari HistoryPemesanan --}}
            <a href="{{ route('kasir.pemesanan.show', $item->id_pemesanan) }}" 
               class="icon-btn" title="Detail">
                <i class="fa-solid fa-eye"></i>
            </a>

            <a href="{{ route('pemesanan.nota', $item->id_pemesanan) }}" 
               class="icon-btn" title="Nota" target="_blank">
                <i class="fa-solid fa-book"></i>
            </a>

        @else

            {{-- Logic lama (pemesanan & reservasi biasa) --}}
            @if(isset($item->id_pemesanan))
                <a href="{{ route('kasir.pemesanan.show', $item->id_pemesanan) }}" 
                   class="icon-btn" title="Detail">
                    <i class="fa-solid fa-eye"></i>
                </a>

                <a href="{{ route('pemesanan.nota', $item->id_pemesanan) }}" 
                   class="icon-btn" title="Nota" target="_blank">
                    <i class="fa-solid fa-book"></i>
                </a>

            @elseif(isset($item->id_reservasi))
                <a href="{{ route('kasir.reservasi.show', $item->id_reservasi) }}" 
                   class="icon-btn" title="Detail">
                    <i class="fa-solid fa-eye"></i>
                </a>

                <a href="{{ route('reservasi.nota', $item->id_reservasi) }}" 
                   class="icon-btn" title="Nota" target="_blank">
                    <i class="fa-solid fa-book"></i>
                </a>
            @endif

        @endif

    </div>
</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#64748b;">
                    Tidak ada antrian hari ini
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>

@push('styles')
<style>
    .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 30px;
}

.stat-card {
    background: #f9fdff;
    border: 1px solid #dbeafe;
    border-radius: 12px;
    padding: 20px;
}

.stat-card p {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 6px;
}

.stat-card h2 {
    margin: 0;
    color: #0b2c4d;
    font-size: 22px;
    font-weight: 700;
}

.icon-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: #f3f4f6;
    color: #374151;
    text-decoration: none;
    transition: 0.2s;
}

.icon-btn:hover {
    background: #e67800;
    color: white;
}

.timeline {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 60px 0 50px;
    position: relative;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 55px;
    left: 5%;
    right: 5%;
    height: 3px;
    background: #e5e7eb;
    z-index: 0;
}

.timeline-step {
    flex: 1;
    text-align: center;
    position: relative;
    z-index: 1;
}

.timeline-step .icon {
    font-size: 28px;
    color: #9ca3af;
    margin-bottom: 12px;
}

.timeline-step .dot {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #d1d5db;
    margin: 0 auto 12px;
    border: 3px solid white;
}

.timeline-step .label {
    font-size: 13px;
    color: #6b7280;
}

.timeline-step .count {
    font-size: 16px;
    font-weight: 700;
    margin-top: 4px;
}

/* COMPLETED */
.timeline-step.completed .icon {
    color: #374151;
}

.timeline-step.completed .dot {
    background: #374151;
}

/* ACTIVE */
.timeline-step.active .icon {
    color: #e67800;
}

.timeline-step.active .dot {
    background: #e67800;
    box-shadow: 0 0 0 4px rgba(16,185,129,0.2);
}

.timeline-step.active .label {
    color: #e67800;
}

.icon {
    font-size: 28px;
}

.label {
    font-size: 14px;
}

.count {
    font-size: 20px;
    font-weight: 700;
}

.card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    overflow: hidden; /* biar gak bocor keluar */
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.table {
    width: 100%;
    min-width: 800px; /* penting supaya bisa scroll */
    border-collapse: collapse;
}

.timeline-step {
    text-decoration: none;
    color: inherit;
    cursor: pointer;
    transition: 0.3s ease;
}

.timeline-step:hover .icon {
    transform: translateY(-3px);
}

/* ================= MOBILE FIX ================= */
@media (max-width: 768px) {

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .stat-card {
        padding: 14px;
    }

    .stat-card h2 {
        font-size: 18px;
    }

}

@media (max-width: 768px) {

    .timeline {
        flex-wrap: wrap;
        gap: 20px;
        margin: 30px 0;
    }

    .timeline::before {
        display: none;
    }

    .timeline-step {
        width: 33.33%;
    }

    .timeline-step .icon {
        font-size: 22px;
    }

    .timeline-step .count {
        font-size: 14px;
    }
}

@media (max-width: 768px) {

    .table {
        min-width: 650px;
    }

    .icon-btn {
        width: 32px;
        height: 32px;
    }
}

@media (max-width: 768px) {

    .page-title {
        font-size: 18px;
        margin-bottom: 15px;
    }

    .card {
        padding: 15px;
    }
}

/* BIAR G GESER KANAN KIRI */
html, body {
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
}

.wrapper {
    overflow-x: hidden;
}

.content {
    overflow-x: hidden;
}

</style>
@endpush
@endsection
