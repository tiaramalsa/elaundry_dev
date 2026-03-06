@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/promo.css') }}">
@endpush

@section('title', 'Promo & Loyalty')

@section('content')

<h3 class="page-title mb-4">Promo & Loyalty</h3>

<div class="card">

    {{-- HEADER CARD --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Daftar Promo</h4>

        <a href="{{ route('manajemen.createpromo') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Tambah Promo
        </a>
    </div>


    <div class="card-body">

        {{-- GRID PROMO --}}
        <div class="promo-grid">

        @foreach($promos as $promo)

            <div class="promo-card {{ $promo->status === 'aktif' ? 'aktif' : 'nonaktif' }}">

                <div class="promo-icon">
                    <i class="mdi mdi-tag"></i>
                </div>

                {{-- NAMA PROMO --}}
                <div class="promo-title">
                    {{ $promo->nama_promo }}
                </div>

                {{-- JENIS PROMO --}}
                <div class="promo-desc">

                    @if($promo->basis_promo === 'nominal')

                        <strong>Potongan :</strong>
                        Rp{{ number_format($promo->nilai_promo, 0, ',', '.') }}

                    @else

                        <strong>Diskon :</strong>
                        {{ $promo->nilai_promo }}%

                    @endif

                </div>


                {{-- DESKRIPSI --}}
                <div class="promo-desc">
                    {{ Str::limit($promo->deskripsi_promo, 80) }}
                </div>


                {{-- STATUS --}}
                <div class="promo-desc">
                    <strong>Status :</strong>
                    {{ ucfirst($promo->status) }}
                </div>


                <div class="promo-footer">

                    <span>
                        Berlaku :
                        {{ $promo->tanggal_mulai }} -
                        {{ $promo->tanggal_selesai }}
                    </span>


                    @if($promo->status === 'aktif')

                        <a href="{{ route('manajemen.showpromo', $promo->id_promo) }}"
                            class="btn btn-sm btn-light btn-detail">
                            Lihat Detail
                        </a>

                    @else

                        <span class="btn btn-sm btn-secondary disabled">
                            Promo Nonaktif
                        </span>

                    @endif

                </div>

            </div>

        @endforeach

        </div>

    </div>

</div>


<style>

    .promo-card.aktif {
        background: linear-gradient(
            135deg,
            #9aa7ff,
            #5e50f9
        );
        color: #fff;
    }

    .promo-card.aktif .promo-icon i{
        color: #ffffff;
    }

    .promo-card.aktif .promo-title{
        color: #ffffff;
    }

    .promo-card.aktif .promo-desc{
        color: rgba(255,255,255,0.9);
    }

    .promo-detail-btn{
        font-size:12px;
        padding:4px 10px;
        background:white;
        color:#1e3a8a;
        border-radius:6px;
        text-decoration:none;
        white-space:nowrap;
    }

    .promo-detail-btn:hover{
        background:#e0e7ff;
        color:#1e40af;
    }

    .promo-card.nonaktif .promo-detail-btn{
        background: #cbd5e1;
        color: #475569;
    }

    .promo-card.nonaktif {
        background: linear-gradient(
            to right,
            #8e8e8e,
            #6f6f6f
        );
        color: #f1f5f9;
        opacity: 0.85;
    }

    .promo-icon{
        background: rgba(255,255,255,0.2);
        padding:8px;
        border-radius:50%;
    }

    .btn-detail{
        white-space: nowrap;
    }

    .btn-detail.disabled {
        background: #cbd5e1;
        cursor: not-allowed;
    }

</style>

@endsection