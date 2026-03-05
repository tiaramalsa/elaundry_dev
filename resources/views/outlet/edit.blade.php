@extends('layouts.admin')

@section('title','Edit Outlet')

@section('content')

<div class="page-header">
    <h3 class="page-title">Edit Outlet</h3>
</div>

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">

<form method="POST" action="{{ route('outlet.update', $outlet->id_outlet) }}">
@csrf
@method('PUT')

{{-- NAMA OUTLET --}}
<div class="form-group">
    <label>Nama Outlet</label>
    <input type="text"
           name="nama_outlet"
           class="form-control"
           value="{{ $outlet->nama_outlet }}">
</div>

{{-- JALAN --}}
<div class="form-group">
    <label>Jalan</label>
    <input type="text"
           name="jalan"
           class="form-control"
           value="{{ $outlet->jalan }}">
</div>

{{-- KECAMATAN --}}
<div class="form-group">
    <label>Kecamatan</label>
    <input type="text"
           name="kecamatan"
           class="form-control"
           value="{{ $outlet->kecamatan }}">
</div>

{{-- KOTA / KAB --}}
<div class="form-group">
    <label>Kota / Kabupaten</label>
    <input type="text"
           name="kota_kab"
           class="form-control"
           value="{{ $outlet->kota_kab }}">
</div>

{{-- PROVINSI --}}
<div class="form-group">
    <label>Provinsi</label>
    <input type="text"
           name="provinsi"
           class="form-control"
           value="{{ $outlet->provinsi }}">
</div>

{{-- KODE POS --}}
<div class="form-group">
    <label>Kode Pos</label>
    <input type="text"
           name="kode_pos"
           class="form-control"
           value="{{ $outlet->kode_pos }}">
</div>

{{-- TELEPON --}}
<div class="form-group">
    <label>No Telepon</label>
    <input type="text"
           name="no_telp"
           class="form-control"
           value="{{ $outlet->no_telp }}">
</div>

{{-- EMAIL --}}
<div class="form-group">
    <label>Email</label>
    <input type="email"
           name="email"
           class="form-control"
           value="{{ $outlet->email }}">
</div>

{{-- WEBSITE --}}
<div class="form-group">
    <label>Website</label>
    <input type="text"
           name="website"
           class="form-control"
           value="{{ $outlet->website }}">
</div>

{{-- BUTTON --}}
<div class="mt-4 d-flex gap-2">

    <a href="{{ route('outlet.index') }}"
       class="btn btn-secondary btn-sm">
        Kembali
    </a>

    <button type="submit" class="btn btn-primary btn-sm">
        Update
    </button>

</div>

</form>

</div>
</div>
</div>
</div>

@endsection