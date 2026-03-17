@extends('layouts.admin')

@section('title','Detail Pemesanan')

@section('content')

<div class="form-row">
<div class="col-lg-12 form-grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h3 class="card-title">Detail Pemesanan</h3>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif


<div class="card-section">

<div class="row mb-3">
    <div class="col-md-4 font-weight-bold">No Order</div>
    <div class="col-md-8">{{ $pemesanan->no_order }}</div>
</div>

<div class="row mb-3">
    <div class="col-md-4 font-weight-bold">Customer</div>
    <div class="col-md-8">{{ $pemesanan->customer->nama_lengkap }}</div>
</div>

<div class="row mb-3">
    <div class="col-md-4 font-weight-bold">No Telepon</div>
    <div class="col-md-8">{{ $pemesanan->customer->no_telp }}</div>
</div>

<div class="row mb-3">
    <div class="col-md-4 font-weight-bold">Alamat</div>
    <div class="col-md-8">{{ $pemesanan->customer->alamat }}</div>
</div>

<div class="row mb-3">
    <div class="col-md-4 font-weight-bold">Status</div>
    <div class="col-md-8">
        <span class="badge badge-info">
            {{ $pemesanan->trackPemesanan->proses }}
        </span>
    </div>
</div>

</div>


<div class="mt-4">
<a href="{{ route('pemesanan.index') }}" class="btn btn-secondary">
<i class="mdi mdi-arrow-left"></i> Kembali
</a>
</div>


</div>
</div>

</div>
</div>

@endsection