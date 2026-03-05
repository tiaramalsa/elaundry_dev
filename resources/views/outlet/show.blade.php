@extends('layouts.admin')

@section('title','Detail Outlet')

@section('content')

<div class="page-header">
    <h3 class="page-title">Detail Outlet</h3>
</div>

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h4 class="card-title mb-1">{{ $outlet->nama_outlet }}</h4>
            <small class="text-muted">
                ID Outlet : {{ $outlet->id_outlet }}
            </small>
        </div>

        <a href="{{ route('outlet.index') }}"
           class="btn btn-secondary btn-sm">
            Kembali
        </a>
    </div>


    {{-- INFORMASI KONTAK --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="border rounded p-3 h-100 bg-light">
                <strong>Telepon</strong>
                <div class="mt-2">
                    {{ $outlet->no_telp ?? '-' }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="border rounded p-3 h-100 bg-light">
                <strong>Email</strong>
                <div class="mt-2">
                    {{ $outlet->email ?? '-' }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="border rounded p-3 h-100 bg-light">
                <strong>Website</strong>
                <div class="mt-2">
                    {{ $outlet->website ?? '-' }}
                </div>
            </div>
        </div>

    </div>


    {{-- ALAMAT OUTLET --}}
    <div class="border rounded p-4 mb-4 bg-light">
        <h6 class="mb-3">Alamat Outlet</h6>

        <div class="text-muted" style="line-height:1.7;">
            {{ $outlet->jalan }} <br>
            {{ $outlet->kelurahan }}, {{ $outlet->kecamatan }} <br>
            {{ $outlet->kota_kab }}, {{ $outlet->provinsi }} <br>
            Kode Pos: {{ $outlet->kode_pos }}
        </div>
    </div>


    {{-- ACTION BUTTON --}}
    <div class="d-flex gap-2 flex-wrap">

        <a href="{{ route('outlet.edit', $outlet->id_outlet) }}"
           class="btn btn-primary btn-sm">
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
</div>
</div>
</div>

@endsection