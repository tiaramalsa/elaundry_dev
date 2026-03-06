@extends('layouts.admin')

@section('title', 'Detail Promo')

@section('content')

<div class="card" style="max-width:100%; padding:25px;">

    {{-- HEADER --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">

        <div>
            <h2 style="margin:0;">{{ $promo->nama_promo }}</h2>
            <small style="color:#64748b;">
                {{ $promo->tanggal_mulai }} - {{ $promo->tanggal_selesai }}
            </small>
        </div>

        {{-- STATUS BADGE --}}
        <div>
            @if($promo->status === 'aktif')
                <span style="
                    background:#dcfce7;
                    color:#15803d;
                    padding:6px 12px;
                    border-radius:20px;
                    font-size:13px;
                    font-weight:600;">
                    Aktif
                </span>
            @else
                <span style="
                    background:#fee2e2;
                    color:#b91c1c;
                    padding:6px 12px;
                    border-radius:20px;
                    font-size:13px;
                    font-weight:600;">
                    Non Aktif
                </span>
            @endif
        </div>
    </div>

    {{-- SECTION 1 : INFO UTAMA --}}
    <div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:20px;">

        <div style="flex:1; min-width:250px; background:#f8fafc; padding:15px; border-radius:10px;">
            <strong>Skema Promo</strong>
            <div style="margin-top:5px;">{{ $promo->skema }}</div>
        </div>

        <div style="flex:1; min-width:250px; background:#f8fafc; padding:15px; border-radius:10px;">
            <strong>Jenis Promo</strong>
            <div style="margin-top:5px;">
                @if($promo->basis_promo === 'nominal')
                    Potongan Rp{{ number_format($promo->nilai_promo,0,',','.') }}
                @else
                    Potongan {{ $promo->nilai_promo }}%
                @endif
            </div>
        </div>

    </div>

    {{-- SECTION 2 : RULE PROMO --}}
    <div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:20px;">

        <div style="flex:1; min-width:200px; background:#f1f5f9; padding:15px; border-radius:10px;">
            <strong>Minimal Transaksi</strong>
            <div style="margin-top:5px;">
                Rp{{ number_format($promo->minimal_transaksi,0,',','.') }}
            </div>
        </div>

        <div style="flex:1; min-width:200px; background:#f1f5f9; padding:15px; border-radius:10px;">
            <strong>Maksimal Diskon</strong>
            <div style="margin-top:5px;">
                @if($promo->maksimal_diskon)
                    Rp{{ number_format($promo->maksimal_diskon,0,',','.') }}
                @else
                    Tidak dibatasi
                @endif
            </div>
        </div>

        <div style="flex:1; min-width:200px; background:#f1f5f9; padding:15px; border-radius:10px;">
            <strong>Kuota</strong>
            <div style="margin-top:5px;">
                {{ $promo->kuota ?? 'Tidak dibatasi' }}
            </div>
        </div>

    </div>

    {{-- SECTION 3 : TARGET & AKSES --}}
    <div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:20px;">

        <div style="flex:1; min-width:200px; background:#f8fafc; padding:15px; border-radius:10px;">
            <strong>Target Diskon</strong>
            <div style="margin-top:5px;">
                {{ ucfirst($promo->target_diskon) }}
            </div>
        </div>

        <div style="flex:1; min-width:200px; background:#f8fafc; padding:15px; border-radius:10px;">
            <strong>Role Akses</strong>
            <div style="margin-top:5px;">
                {{ ucfirst($promo->role_akses) }}
            </div>
        </div>

        <div style="flex:1; min-width:200px; background:#f8fafc; padding:15px; border-radius:10px;">
            <strong>Khusus Member</strong>
            <div style="margin-top:5px;">
                {{ $promo->khusus_member ? 'Ya' : 'Tidak' }}
            </div>
        </div>

    </div>

    {{-- DESKRIPSI --}}
    <div style="background:#ffffff; border:1px solid #e2e8f0; padding:20px; border-radius:12px; margin-bottom:20px;">
        <strong>Deskripsi Promo</strong>
        <p style="margin-top:10px; color:#475569;">
            {{ $promo->deskripsi_promo }}
        </p>
    </div>

    {{-- ACTION BUTTON --}}
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('manajemen.indexpromo') }}"
           class="btn btn-secondary btn-sm">Kembali</a>

        @if($promo->status === 'aktif')
        <form method="POST"
              action="{{ route('manajemen.promo.nonaktifkan', $promo->id_promo) }}">
            @csrf
            <button class="btn btn-danger btn-sm">
                Nonaktifkan
            </button>
        </form>
        @endif
    </div>

</div>
@endsection
