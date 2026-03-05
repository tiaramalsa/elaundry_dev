@extends('layouts.admin')

@section('title','Tambah Outlet')

@section('content')

<div class="row">
<div class="col-12">

<div class="card">
<div class="card-body">

<h3 class="card-title page-title">Form Tambah Outlet</h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('outlet.store') }}">
@csrf

{{-- NAMA OUTLET --}}
<div class="mb-4">
    <label class="form-label">Nama Outlet</label>
    <input type="text" name="nama_outlet" class="form-control" placeholder="Nama Outlet">
</div>

{{-- ALAMAT --}}
<h5 class="section-title">Alamat Outlet</h5>
<div class="row mb-4">

    <div class="col-12 mb-3">
        <label class="form-label">Jalan</label>
        <input type="text" name="jalan" class="form-control" placeholder="Jalan">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Desa / Kelurahan</label>
        <input type="text" name="kelurahan" class="form-control" placeholder="Desa / Kelurahan">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Kecamatan</label>
        <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Kota / Kabupaten</label>
        <input type="text" name="kota_kab" class="form-control" placeholder="Kota / Kabupaten">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Provinsi</label>
        <input type="text" name="provinsi" class="form-control" placeholder="Provinsi">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Kode Pos</label>
        <input type="text" name="kode_pos" class="form-control" placeholder="Kode Pos">
    </div>

</div>

{{-- KONTAK --}}
<h5 class="section-title">Kontak Outlet</h5>
<div class="row mb-4">

    <div class="col-md-4 mb-3">
        <label class="form-label">Telepon</label>
        <input type="text" name="no_telp" class="form-control" placeholder="Telepon">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Email">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Website</label>
        <input type="text" name="website" class="form-control" placeholder="Website">
    </div>

</div>

{{-- BUTTON --}}
<div class="d-flex gap-2">
    <a href="{{ route('outlet.index') }}" class="btn btn-light">Kembali</a>
    <button type="submit" class="btn btn-primary">Tambah Outlet</button>
</div>

</form>

</div>
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

.section-title {
    font-size:16px;
    font-weight:600;
    margin-top:35px;
    margin-bottom:20px;
    padding-bottom:6px;
    border-bottom:1px solid #e5e7eb;
}

.form-label {
    display:block;
    margin-bottom:6px;
    font-weight:500;
}

.form-control {
    width:100%;
    height:45px;
    padding:10px 12px;
    border-radius:6px;
    border:1px solid #ced4da;
    font-size:14px;
}

.row {
    row-gap:10px;
}
</style>
@endpush