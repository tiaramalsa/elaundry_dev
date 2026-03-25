@extends('layouts.admin')

@section('title', 'Tugas Kurir')

@section('content')

<div class="container-fluid kurir-wrapper">

    <h4 class="mb-3 font-weight-bold">📥 Pickup</h4>

    @forelse($pickup as $item)
    <a href="{{ route('kurir.detail', $item->id_pemesanan) }}" class="kurir-link">
    <div class="card kurir-card mb-3">

        <div class="card-body">

            <!-- HEADER -->
            <div class="d-flex justify-content-between">
                <h5 class="mb-0 font-weight-bold">
                    {{ $item->customer->nama_lengkap }}
                </h5>
                <span class="badge badge-warning">Pickup</span>
            </div>

            <!-- ALAMAT -->
            <p class="text-muted small mt-2 mb-3">
                {{ Str::limit($item->customer->alamat, 70) }}
            </p>

            <!-- ACTION DALAM CARD -->
            <div class="d-flex mt-3">
                <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}"
                   target="_blank"
                   class="btn btn-light flex-fill mr-2 btn-kurir">
                   📍 Maps
                </a>

                <form method="POST" action="{{ route('kurir.ambil', $item->id_pemesanan) }}" class="flex-fill">
                    @csrf
                    <button class="btn btn-success w-100 btn-kurir">
                        Ambil
                    </button>
                </form>
            </div>

        </div>
    </div>
</a>
    @empty
    <p class="text-center text-muted mt-4">Tidak ada pickup</p>
    @endforelse


    <h4 class="mt-4 mb-3 font-weight-bold">🚚 Delivery</h4>

    @forelse($delivery as $item)
    <div class="card kurir-card mb-3">

        <div class="card-body">

            <div class="d-flex justify-content-between">
                <h5 class="mb-0 font-weight-bold">
                    {{ $item->customer->nama_lengkap }}
                </h5>
                <span class="badge badge-primary">Delivery</span>
            </div>

            <p class="text-muted small mt-2 mb-3">
                {{ Str::limit($item->customer->alamat, 70) }}
            </p>

            <div class="d-flex mt-3">
                <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}"
                   target="_blank"
                   class="btn btn-light flex-fill mr-2 btn-kurir">
                   📍 Maps
                </a>

                <form method="POST" action="{{ route('kurir.antar', $item->id_pemesanan) }}" class="flex-fill">
                    @csrf
                    <button class="btn btn-primary w-100 btn-kurir">
                        Antar
                    </button>
                </form>
            </div>

        </div>
    </div>
    @empty
    <p class="text-center text-muted mt-4">Tidak ada delivery</p>
    @endforelse

</div>

@endsection


@push('styles')
<style>

/* WRAPPER biar beda dari admin */
.kurir-wrapper{
    max-width:500px;
    margin:auto;
    padding-top:10px;
}

/* CARD FIX */
.kurir-card{
    border-radius:18px;
    border:none;
    box-shadow:0 4px 12px rgba(0,0,0,0.06);
}

/* BUTTON */
.btn-kurir{
    height:50px;
    border-radius:12px;
    font-weight:600;
}

/* BACKGROUND HALAMAN */
body{
    background:#f1f3f6;
}

.kurir-link{
    text-decoration:none;
    color:inherit;
}

.kurir-card:active{
    transform:scale(0.98);
}

</style>
@endpush