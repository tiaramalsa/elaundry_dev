@extends('layouts.dashboard')

@section('title', 'Detail Outlet')

@section('content')
<h3 class="page-title">Detail Outlet</h3>

<div class="card" style="max-width:100%; padding:25px;">

    {{-- HEADER --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; flex-wrap:wrap; gap:10px;">

        <div>
            <h2 style="margin:0;">{{ $outlet->nama_outlet }}</h2>
            <small style="color:#64748b;">
                ID Outlet : {{ $outlet->id_outlet }}
            </small>
        </div>

        <div>
            <a href="{{ route('outlet.index') }}"
               class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>

    {{-- SECTION 1 : INFORMASI UMUM --}}
    <div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:20px;">

        <div style="flex:1; min-width:250px; background:#f8fafc; padding:15px; border-radius:10px;">
            <strong>Telepon</strong>
            <div style="margin-top:5px;">
                {{ $outlet->no_telp ?? '-' }}
            </div>
        </div>

        <div style="flex:1; min-width:250px; background:#f8fafc; padding:15px; border-radius:10px;">
            <strong>Email</strong>
            <div style="margin-top:5px;">
                {{ $outlet->email ?? '-' }}
            </div>
        </div>

        <div style="flex:1; min-width:250px; background:#f8fafc; padding:15px; border-radius:10px;">
            <strong>Website</strong>
            <div style="margin-top:5px;">
                {{ $outlet->website ?? '-' }}
            </div>
        </div>

    </div>

    {{-- SECTION 2 : ALAMAT --}}
    <div style="background:#f1f5f9; padding:20px; border-radius:12px; margin-bottom:20px;">

        <strong style="font-size:15px;">Alamat Outlet</strong>

        <div style="margin-top:10px; color:#475569; line-height:1.6;">
            {{ $outlet->jalan }} <br>
            {{ $outlet->kelurahan }}, {{ $outlet->kecamatan }} <br>
            {{ $outlet->kota_kab }}, {{ $outlet->provinsi }} <br>
            Kode Pos: {{ $outlet->kode_pos }}
        </div>

    </div>

    {{-- OPTIONAL : PENANGGUNG JAWAB (kalau mau aktifkan lagi) --}}
    {{-- 
    <div style="display:flex; flex-wrap:wrap; gap:15px; margin-bottom:20px;">
        <div style="flex:1; min-width:250px; background:#f8fafc; padding:15px; border-radius:10px;">
            <strong>Penanggung Jawab</strong>
            <div style="margin-top:5px;">
                {{ $outlet->pj_nama }}
            </div>
        </div>

        <div style="flex:1; min-width:250px; background:#f8fafc; padding:15px; border-radius:10px;">
            <strong>Kontak PJ</strong>
            <div style="margin-top:5px;">
                {{ $outlet->pj_kontak }}
            </div>
        </div>
    </div>
    --}}

    {{-- ACTION BUTTON --}}
    <div style="display:flex; gap:10px; flex-wrap:wrap;">

        <a href="{{ route('outlet.edit', $outlet->id_outlet) }}"
           class="btn btn-sm">
            Edit Outlet
        </a>

        <form action="{{ route('outlet.destroy', $outlet->id_outlet) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus outlet ini?')">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger btn-sm">
                Hapus Outlet
            </button>
        </form>

    </div>

</div>
@endsection
