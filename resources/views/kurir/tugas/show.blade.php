@extends('layouts.admin')

@section('title', 'Detail Tugas')

@section('content')


<div class="container-fluid" style="max-width:600px;margin:auto;">

    <!-- HEADER -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">

            <h5 class="font-weight-bold">
                {{ $order->customer->nama_lengkap }}
            </h5>

            <p class="text-muted small mb-2">
                {{ $order->customer->alamat }}
            </p>

            @php
                $statusText = match($order->status_proses) {
                    'menunggu_pickup' => 'Menunggu Pickup',
                    'sudah_diambil' => 'Sudah Dijemput',
                    'diterima', 'dicuci', 'dikeringkan', 'disetrika' => 'Sedang Diproses',
                    'siap_antar' => 'Siap Diantar',
                    'sedang_diantar' => 'Sedang Diantar',
                    'selesai' => 'Selesai',
                    default => '-'
                };
            @endphp

            <span class="badge badge-primary">
                {{ $statusText }}
            </span>

        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">

            <h6 class="mb-3 font-weight-bold">Detail Order</h6>

            <p><b>Nama:</b> {{ $order->customer->nama_lengkap }}</p>

            <p>
            <b>No HP:</b> 
            <a href="https://wa.me/{{ $order->customer->no_telp }}" target="_blank">
                {{ $order->customer->no_telp }}
            </a>
            </p>

            <p><b>Alamat:</b> {{ $order->customer->alamat }}</p>

            <p><b>Catatan:</b> {{ $order->catatan_khusus ?? '-' }}</p>

            <p><b>Jenis Laundry:</b></p>

            @php
                $layanans = json_decode($order->detail_layanan, true);
            @endphp

            @forelse($layanans as $item)
                <div class="layanan-item">
                    {{ $item['kode_layanan'] }} ({{ $item['qty'] }}x)
                </div>
            @empty
                <p>-</p>
            @endforelse
    </div>

    <!-- TIMELINE -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">

            <h6 class="mb-3 font-weight-bold">Progress</h6>

            <ul class="timeline">

                <li class="{{ in_array($order->status_proses, ['menunggu_pickup','sudah_diambil']) ? 'active' : '' }}">
                    Pickup
                </li>

                <li class="{{ in_array($order->status_proses, ['diterima','dicuci','dikeringkan','disetrika']) ? 'active' : '' }}">
                    Diproses
                </li>

                <li class="{{ in_array($order->status_proses, ['siap_antar','sedang_diantar','selesai']) ? 'active' : '' }}">
                    Diantar
                </li>

            </ul>

        </div>
    </div>

    <!-- MAP -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-0">

            <iframe
                width="100%"
                height="250"
                style="border:0"
                loading="lazy"
                allowfullscreen
                src="https://maps.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&z=15&output=embed">
            </iframe>

        </div>
    </div>

    <!-- ACTION -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <!-- NAVIGASI -->
            <a href="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}"
            class="btn btn-dark w-100 mb-2">
            📍 Navigasi
            </a>

            <!-- AKSI UTAMA -->

            @if($order->status_proses == 'pickup')
            <form method="POST" action="{{ route('kurir.ambil', $order->id_pemesanan) }}">
                @csrf
                <button class="btn btn-success w-100 mb-2">
                    ✅ Ambil Laundry
                </button>
            </form>
            @endif

            @if($order->status_proses == 'antar')
            <form method="POST" action="{{ route('kurir.antar', $order->id_pemesanan) }}">
                @csrf
                <button class="btn btn-primary w-100 mb-2">
                    🚚 Antar Laundry
                </button>
            </form>
            @endif

            <!-- 🔥 TAMBAHAN BARU TARUH DI SINI -->

            @if($order->status_proses == 'siap_antar')
            <form method="POST" action="{{ route('kurir.sedang.antar', $order->id_pemesanan) }}">
                @csrf
                <button class="btn btn-warning w-100 mb-2">
                    🚚 Sedang Diantar
                </button>
            </form>
            @endif

            @if($order->status_proses == 'sedang_diantar')
            <form method="POST" action="{{ route('kurir.antar', $order->id_pemesanan) }}">
                @csrf
                <button class="btn btn-primary w-100 mb-2">
                    ✅ Sudah Sampai
                </button>
            </form>
            @endif

            <!-- 🔥 BUTTON KEMBALI -->
            <a href="{{ route('kurir.tugas') }}"
            class="btn btn-outline-secondary w-100">
            ⬅️ Kembali
            </a>

        </div>
    </div>

</div>

@endsection


@push('styles')
<style>

.timeline{
    list-style:none;
    padding-left:0;
}

.timeline li{
    padding:8px 0;
    position:relative;
    padding-left:20px;
    color:#999;
}

.timeline li.active{
    color:#000;
    font-weight:bold;
}

.timeline li::before{
    content:'';
    width:10px;
    height:10px;
    background:#ccc;
    border-radius:50%;
    position:absolute;
    left:0;
    top:12px;
}

.timeline li.active::before{
    background:green;
}

.btn{
    border-radius:12px;
    height:50px;
    font-weight:600;
}

</style>
@endpush