@extends('layouts.admin')

@section('title','Edit Profile Kurir')

@section('content')

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h4 class="card-title font-weight-bold">Edit Profile</h4>

<form action="{{ route('kurir.profile.update') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row">

{{-- DATA DIRI --}}
<div class="col-md-6">

<h5 class="mb-3 font-weight-bold">Data Diri</h5>

<div class="form-group">
<label class="font-weight-bold">Nama</label>
<input type="text" name="name" class="form-control" value="{{ $user->name }}">
</div>

<div class="form-group">
<label class="font-weight-bold">Email</label>
<input type="text" class="form-control" value="{{ $user->email }}" disabled>
</div>

<div class="form-group">
<label class="font-weight-bold">No HP</label>
<input type="text" name="no_hp" class="form-control" value="{{ $user->no_hp }}">
</div>

<div class="form-group">
<label class="font-weight-bold">Alamat</label>
<textarea name="alamat" class="form-control">{{ $user->alamat }}</textarea>
</div>

<div class="form-group">
<label class="font-weight-bold">Foto Profile</label><br>

@if($kurir && $kurir->foto)
<img src="{{ asset('storage/'.$kurir->foto) }}" width="120" class="rounded mb-2">
@endif

<input type="file" name="foto" class="form-control">
</div>

</div>

{{-- DATA PEKERJAAN --}}
<div class="col-md-6">

<h5 class="mb-3 font-weight-bold">Data Pekerjaan</h5>

<div class="form-group">
<label class="font-weight-bold">ID Kurir</label>
<input type="text" name="id_kurir" class="form-control" value="{{ $kurir->id_kurir }}">
</div>

<div class="form-group">
<label class="font-weight-bold">Status</label>
<select name="status" class="form-control">
    <option value="aktif" {{ $kurir->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
    <option value="tidak_aktif" {{ $kurir->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
</select>
</div>

<div class="form-group">
<label class="font-weight-bold">Bergabung</label>
<input type="date" name="bergabung_sejak" class="form-control" value="{{ $kurir->bergabung_sejak }}">
</div>

<div class="form-group">
<label class="font-weight-bold">Plat Nomor</label>
<input type="text" name="plat_nomor" class="form-control" value="{{ $kurir->plat_nomor }}">
</div>

<div class="form-group">
<label class="font-weight-bold">Jenis Kendaraan</label>
<input type="text" name="jenis_kendaraan" class="form-control" value="{{ $kurir->jenis_kendaraan }}">
</div>

</div>

</div>

<button class="btn btn-success mt-3">Simpan</button>
<a href="{{ route('kurir.profile') }}" class="btn btn-secondary mt-3">Kembali</a>

</form>

</div>
</div>

</div>
</div>

@endsection