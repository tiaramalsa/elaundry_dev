@extends('layouts.admin')

@section('title', 'Detail Tugas')

@section('content')

<div class="container-fluid">

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">

        <!-- HEADER WITH BACK -->
        <div class="d-flex align-items-center gap-3 mb-3 header-top">
            <a href="{{ route('kurir.tugas') }}" class="back-btn">
                ←
            </a>

            <h5 class="font-weight-bold m-0">Detail Tugas</h5>
        </div>

        <!-- TRACKING -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body text-center">

                <div class="d-flex justify-content-between align-items-center tracking">

                    <div class="step {{ in_array($order->status_proses,['menunggu_pickup','sudah_diambil'])?'active':'' }}">
                        <div class="circle">1</div>
                        <small>Pickup</small>
                    </div>

                    <div class="line"></div>

                    <div class="step {{ in_array($order->status_proses,['diterima','dicuci','dikeringkan','disetrika'])?'active':'' }}">
                        <div class="circle">2</div>
                        <small>Proses</small>
                    </div>

                    <div class="line"></div>

                    <div class="step {{ in_array($order->status_proses,['siap_antar','sedang_diantar'])?'active':'' }}">
                        <div class="circle">3</div>
                        <small>Diantar</small>
                    </div>

                    <div class="line"></div>

                    <div class="step {{ $order->status_proses=='selesai'?'active':'' }}">
                        <div class="circle">4</div>
                        <small>Selesai</small>
                    </div>

                </div>

            </div>
        </div>

        <!-- INFO GRID -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <h6 class="font-weight-bold">Order Info</h6>
                        <p><b>Status:</b> {{ $order->status_proses }}</p>
                        <p><b>Catatan:</b> {{ $order->catatan_khusus ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <h6 class="font-weight-bold">Lokasi</h6>
                        <p>{{ $order->customer->alamat }}</p>
                    </div>

                    <div class="col-md-4">
                        <h6 class="font-weight-bold">Customer</h6>
                        <p>{{ $order->customer->nama_lengkap }}</p>
                        <p>{{ $order->customer->no_telp }}</p>
                    </div>

                </div>

            </div>
        </div>

        <!-- ITEM LIST -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">

                <h6 class="font-weight-bold mb-3">Item Laundry</h6>

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>

                    @php $layanans = json_decode($order->detail_layanan, true); @endphp

                    @forelse($layanans as $i => $item)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $item['kode_layanan'] }}</td>
                            <td>{{ $item['qty'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3">-</td></tr>
                    @endforelse

                    </tbody>
                </table>

            </div>
        </div>

        <!-- MAP -->
        <div class="card border-0 shadow-sm mb-3">
            <iframe
                width="100%"
                height="250"
                style="border:0"
                loading="lazy"
                src="https://maps.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&z=15&output=embed">
            </iframe>
        </div>

        <!-- ACTION -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <a href="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}"
                   class="btn btn-dark w-100 mb-2">
                   📍 Navigasi
                </a>

                @if($order->status_proses == 'menunggu_pickup')
                <form method="POST" action="{{ route('kurir.ambil', $order->id_pemesanan) }}">
                    @csrf
                    <button class="btn btn-success w-100 mb-2">Ambil</button>
                </form>
                @endif

                @if($order->status_proses == 'siap_antar')
                <form method="POST" action="{{ route('kurir.sedang.antar', $order->id_pemesanan) }}">
                    @csrf
                    <button class="btn btn-warning w-100 mb-2">Sedang Diantar</button>
                </form>
                @endif

                @if($order->status_proses == 'sedang_diantar')
                <form method="POST" action="{{ route('kurir.antar', $order->id_pemesanan) }}">
                    @csrf
                    <button class="btn btn-primary w-100 mb-2">Selesai</button>
                </form>
                @endif

            </div>
        </div>

    </div>

</div>

@endsection


@push('styles')
<style>

/* MAIN WRAPPER */
.main-wrapper{
    background:#fff;
    border-radius:20px;
    padding:20px;
    box-shadow:0 6px 25px rgba(0,0,0,0.06);
}

/* BACK BUTTON MODERN */
.back-btn{
    padding:8px 16px;
    border-radius:999px;
    background:#f1f3f6;
    color:#333;
    font-weight:600;
    text-decoration:none;
    transition:0.2s;
}

.back-btn:hover{
    background:#e2e6ea;
    text-decoration:none;
    color:#000;
}

/* TRACKING */
.tracking{
    position:relative;
}

.step{
    text-align:center;
    flex:1;
}

.circle{
    width:32px;
    height:32px;
    border-radius:50%;
    background:#ccc;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
}

.step.active .circle{
    background:#28a745;
}

.line{
    height:2px;
    background:#ccc;
    flex:1;
}

/* BUTTON */
.btn{
    border-radius:12px;
    height:50px;
    font-weight:600;
}

.header-top{
    gap:10px;
}

/* BACK BUTTON ICON STYLE */
.back-btn{
    width:40px;
    height:40px;
    border-radius:50%;
    background:#f1f3f6;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    font-weight:600;
    color:#333;
    text-decoration:none;
    transition:0.2s;
}

.back-btn:hover{
    background:#e2e6ea;
    color:#000;
}

</style>
@endpush