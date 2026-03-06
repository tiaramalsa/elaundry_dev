@extends('layouts.admin')

@section('title','Tambah Customer')

@section('content')

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h1 class="card-title mb-5">Form Data Customer</h1>

<form method="POST" action="{{ route('manajemen.customer.store') }}">
@csrf


{{-- NAMA & NO HP --}}
<div class="row">

<div class="col-md-6">
<div class="form-group">
<label>Nama Lengkap</label>
<input type="text"
       name="nama_lengkap"
       class="form-control"
       placeholder="Masukkan nama customer"
       value="{{ old('nama_lengkap') }}">
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label>No WhatsApp</label>
<input type="text"
       name="no_telp"
       class="form-control"
       placeholder="08xxxxxxxx"
       value="{{ old('no_telp') }}">
</div>
</div>

</div>


{{-- ALAMAT --}}
<div class="form-group">
<label>Alamat</label>
<textarea name="alamat"
          rows="3"
          class="form-control"
          placeholder="Masukkan alamat customer">{{ old('alamat') }}</textarea>
</div>


{{-- AMBIL LOKASI --}}
<div class="form-group">

<a onclick="ambilLokasi()" class="btn btn-outline-primary btn-sm">
<i class="mdi mdi-map-marker"></i> Ambil Titik Lokasi
</a>

<small id="lokasiStatus" class="text-muted d-block mt-2"></small>

</div>


<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">


<hr>


{{-- MEMBER --}}
<div class="form-group d-flex align-items-center justify-content-between" style="max-width:400px;">

<div>
<label class="mb-0">Customer Member</label>
<br>
<small class="text-muted">Aktifkan jika customer adalah member</small>
</div>

<div class="form-check form-switch">
<input type="hidden" name="is_member" value="0">

<input type="checkbox"
       name="is_member"
       value="1"
       class="form-check-input"
       {{ old('is_member') ? 'checked' : '' }}>
</div>

</div>


{{-- BUTTON --}}
<div class="text-right mt-4">

<a href="{{ route('manajemen.customer.index') }}"
   class="btn btn-light">
   Batal
</a>

<button class="btn btn-primary">
<i class="mdi mdi-content-save"></i> Simpan
</button>

</div>


</form>

</div>
</div>

</div>
</div>

<style>

    .card-title{
        margin-bottom: 50px; /* jarak title ke input */
    }

    .form-group{
        margin-bottom: 20px;
    }

    .form-group label{
        font-weight: 500;
        margin-bottom: 6px;
        display:block;
    }

</style>

@endsection