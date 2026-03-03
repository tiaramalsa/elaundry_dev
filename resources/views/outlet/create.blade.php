@extends('layouts.dashboard')

@section('title', 'Tambah Outlet')

@section('content')
<div class="page-title">Form Tambah Outlet</div>

<div class="card" style="max-width:100%; padding:25px;">

    <h3 style="margin-bottom:20px;">Form Tambah Outlet</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('outlet.store') }}">
        @csrf

        {{-- NAMA OUTLET --}}
        <div style="margin-bottom:25px;">
            <input type="text"
                   name="nama_outlet"
                   placeholder="Nama Outlet"
                   style="width:100%; height:45px; padding:12px;">
        </div>

        {{-- SECTION ALAMAT --}}
        <div style="background:#f8fafc; padding:20px; border-radius:12px; margin-bottom:25px;">
            <h4 style="margin-bottom:15px;">Alamat Outlet</h4>

            {{-- Jalan --}}
            <div style="margin-bottom:15px;">
                <input type="text"
                       name="jalan"
                       placeholder="Jalan"
                       style="width:100%; height:45px; padding:12px;">
            </div>

            {{-- Kelurahan & Kecamatan --}}
            <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:15px;">
                <input type="text"
                       name="kelurahan"
                       placeholder="Desa / Kelurahan"
                       style="flex:1; min-width:220px; height:45px; padding:12px;">

                <input type="text"
                       name="kecamatan"
                       placeholder="Kecamatan"
                       style="flex:1; min-width:220px; height:45px; padding:12px;">
            </div>

            {{-- Kota | Provinsi | Kode Pos --}}
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <input type="text"
                       name="kota_kab"
                       placeholder="Kota / Kabupaten"
                       style="flex:1; min-width:200px; height:45px; padding:12px;">

                <input type="text"
                       name="provinsi"
                       placeholder="Provinsi"
                       style="flex:1; min-width:200px; height:45px; padding:12px;">

                <input type="text"
                       name="kode_pos"
                       placeholder="Kode Pos"
                       style="flex:1; min-width:150px; height:45px; padding:12px;">
            </div>
        </div>

        {{-- SECTION KONTAK --}}
        <div style="background:#f1f5f9; padding:20px; border-radius:12px; margin-bottom:25px;">
            <h4 style="margin-bottom:15px;">Kontak Outlet</h4>

            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <input type="text"
                       name="no_telp"
                       placeholder="Telepon"
                       style="flex:1; min-width:220px; height:45px; padding:12px;">

                <input type="email"
                       name="email"
                       placeholder="Email"
                       style="flex:1; min-width:220px; height:45px; padding:12px;">

                <input type="text"
                       name="website"
                       placeholder="Website"
                       style="flex:1; min-width:220px; height:45px; padding:12px;">
            </div>
        </div>

        {{-- BUTTON --}}
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('outlet.index') }}"
               class="btn btn-secondary btn-sm">
                Kembali
            </a>

            <button type="submit" class="btn">
                Tambah Outlet
            </button>
        </div>

    </form>
</div>
@endsection
