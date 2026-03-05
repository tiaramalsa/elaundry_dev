@extends('layouts.admin')

@section('title','Daftar Outlet')

@section('content')

<h3 class="page-title">Daftar Outlet</h3>

{{-- NOTIFIKASI --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-body">

        {{-- HEADER DALAM CARD --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Daftar Outlet</h5>
            <a href="{{ route('outlet.create') }}" class="btn btn-primary btn-sm">
                + Tambah Outlet
            </a>
        </div>

        {{-- LIST OUTLET --}}
        <div class="row">
            @foreach($outlets as $outlet)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">

                        <h6 class="card-title mb-2">📍 {{ $outlet->nama_outlet }}</h6>
                        <p class="mb-1">
                            {{ $outlet->jalan }}, {{ $outlet->kecamatan }},<br>
                            {{ $outlet->kota_kab }}, {{ $outlet->provinsi }}
                        </p>
                        <p class="mb-2">📞 {{ $outlet->no_telp }}</p>

                        <a href="{{ route('outlet.show', $outlet->id_outlet) }}" class="btn btn-light btn-sm">
                            Lihat Detail
                        </a>

                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>

@endsection

@push('styles')
<style>
.page-title {
    font-size:26px;
    font-weight:600;
    margin-bottom:30px;
}

.card-body h5 {
    font-size:18px;
    font-weight:600;
}

.card-title {
    font-size:16px;
    font-weight:500;
}

.row {
    row-gap:15px;
}
</style>
@endpush