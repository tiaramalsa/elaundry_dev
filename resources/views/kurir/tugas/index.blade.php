@extends('layouts.admin')

@section('title', 'Tugas Kurir')

@section('content')

<div class="container-fluid">

    <div class="main-card">

        <!-- HEADER -->
        <h4 class="font-weight-bold mb-3">🚀 Tugas Kurir</h4>

        <!-- TAB -->
        <ul class="nav custom-tabs mb-4" id="kurirTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#pickup">Pickup</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#delivery">Delivery</a>
            </li>
        </ul>

        <div class="tab-content">

            <!-- PICKUP -->
            <div class="tab-pane fade show active" id="pickup">
                <div class="row">
                    @forelse($pickup as $item)
                    <div class="col-12 col-md-6 mb-3">

                        <!-- CARD CLICKABLE TANPA LINK STYLE -->
                        <div class="card kurir-card pickup-card h-100 cursor-pointer"
                            data-url="{{ route('kurir.detail', $item->id_pemesanan) }}">

                            <div class="card-body">

                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 font-weight-bold">
                                        {{ $item->customer->nama_lengkap }}
                                    </h5>
                                    <span class="badge badge-warning">Pickup</span>
                                </div>

                                <p class="text-muted small mt-2 mb-3">
                                    {{ Str::limit($item->customer->alamat, 70) }}
                                </p>

                                <p class="mb-1">
                                    📞 {{ $item->customer->no_telp }}
                                </p>

                                <p class="small">
                                    Status: 
                                    @switch($item->status_proses)
                                        @case('menunggu_pickup') Belum diambil @break
                                        @case('sudah_diambil') Sudah diambil @break
                                        @case('siap_antar') Siap diantar @break
                                        @case('sedang_diantar') Sedang diantar @break
                                    @endswitch
                                </p>

                                <div class="d-flex align-items-center mt-3">
                                    <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}"onclick="event.stopPropagation()"
                                       target="_blank"
                                       class="btn btn-light flex-fill mr-2 btn-kurir">
                                       📍 Maps
                                    </a>

                                    @if($item->status_proses == 'menunggu_pickup')
                                    <form method="POST" action="{{ route('kurir.ambil', $item->id_pemesanan) }}" class="flex-fill d-flex">
                                        @csrf
                                        <button class="btn btn-success w-100 btn-kurir"
                                            onclick="event.stopPropagation()">
                                            Ambil
                                        </button>
                                    </form>
                                    @else
                                    <div class="flex-fill">
                                        <button class="btn btn-secondary w-100 btn-kurir" disabled>
                                            Sudah Diambil
                                        </button>
                                    </div>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                    @empty
                    <div class="col-12 text-center text-muted">Tidak ada pickup</div>
                    @endforelse
                </div>
            </div>

            <!-- DELIVERY -->
            <div class="tab-pane fade" id="delivery">
                <div class="row">
                    @forelse($delivery as $item)
                    <div class="col-12 col-md-6 mb-3">

                        <div class="card kurir-card delivery-card h-100 cursor-pointer"
                            data-url="{{ route('kurir.detail', $item->id_pemesanan) }}">

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
                                    onclick="event.stopPropagation()"
                                    class="btn btn-light flex-fill mr-2 btn-kurir">
                                    📍 Maps
                                    </a>

                                    <form method="POST" action="{{ route('kurir.antar', $item->id_pemesanan) }}" class="flex-fill">
                                        @csrf
                                        <button class="btn btn-primary w-100 btn-kurir"
                                            onclick="event.stopPropagation()">
                                            Antar
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>

                    </div>
                    @empty
                    <div class="col-12 text-center text-muted">Tidak ada delivery</div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.kurir-card').forEach(card => {

        card.addEventListener('click', function (e) {

            // kalau klik tombol / link → jangan redirect
            if (e.target.closest('a') || e.target.closest('button') || e.target.closest('form')) {
                return;
            }

            const url = this.dataset.url;

            if (url) {
                window.location.href = url;
            }
        });

    });

});
</script>

@endsection


@push('styles')
<style>

.main-card{
    background:#fff;
    border-radius:20px;
    padding:20px;
    box-shadow:0 4px 20px rgba(0,0,0,0.06);
}

.custom-tabs{
    border-bottom:2px solid #eee;
}
.custom-tabs .nav-link{
    border:none;
    color:#777;
    font-weight:600;
}
.custom-tabs .nav-link.active{
    color:#4e73df;
    border-bottom:3px solid #4e73df;
}

.kurir-card{
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:0.2s;
}

.pickup-card{
    background: linear-gradient(135deg, #fff3cd, #ffe8a1);
}
.delivery-card{
    background: linear-gradient(135deg, #e8f0ff, #ffffff);
}

.kurir-card:hover{
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.12);
}

.btn-kurir{
    height:50px;
    border-radius:12px;
    font-weight:600;
    display:flex;
    align-items:center;
    justify-content:center;
}

body{
    background:#f1f3f6;
}

.badge-warning{
    background-color:#f6c23e !important;
    color:#000;
    font-weight:600;
}

.cursor-pointer{
    cursor:pointer;
}

</style>
@endpush