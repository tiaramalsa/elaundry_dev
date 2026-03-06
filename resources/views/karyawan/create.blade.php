@extends('layouts.admin')

@section('title','Tambah Karyawan')

@section('content')

<div class="row">
<div class="col-12">

<div class="card">
<div class="card-body">

<h3 class="card-title page-title">Form Tambah Karyawan</h3>

<form method="POST" action="{{ route('karyawan.store') }}">
@csrf

@if ($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

{{-- DATA PRIBADI --}}
<h5 class="section-title">Data Pribadi</h5>

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Nama Karyawan</label>
<input type="text" name="nama_karyawan" class="form-control"
value="{{ old('nama_karyawan') }}" placeholder="Nama Karyawan">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Jenis Kelamin</label>
<select name="jenis_kelamin" class="form-select">
<option value="">Pilih Jenis Kelamin</option>
<option value="L">Laki-laki</option>
<option value="P">Perempuan</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Tempat Lahir</label>
<input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Agama</label>
<select name="agama" class="form-select">
<option value="">Pilih Agama</option>
<option value="Islam">Islam</option>
<option value="Kristen">Kristen</option>
<option value="Katolik">Katolik</option>
<option value="Hindu">Hindu</option>
<option value="Buddha">Buddha</option>
<option value="Konghucu">Konghucu</option>
<option value="Kepercayaan Lain">Kepercayaan Lain</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Tanggal Lahir</label>
<input type="date" name="tanggal_lahir" class="form-control">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">NIK</label>
<input type="text" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="NIK">
</div>

</div>

{{-- DATA PEKERJAAN --}}
<h5 class="section-title">Data Pekerjaan</h5>

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Jabatan</label>
<select name="jabatan" class="form-select">
<option value="">Pilih Jabatan</option>
<option value="Kasir">Kasir</option>
<option value="Admin">Admin</option>
<option value="Supervisor">Supervisor</option>
<option value="Kurir">Kurir</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Outlet</label>
<select name="id_outlet" class="form-select" required>
<option value="">Pilih Outlet</option>
@foreach($outlets as $outlet)
<option value="{{ $outlet->id_outlet }}">
{{ $outlet->nama_outlet }}
</option>
@endforeach
</select>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Status Karyawan</label>
<select name="status" class="form-select">
<option value="">Pilih Status</option>
<option value="Aktif">Aktif</option>
<option value="Tidak Aktif">Tidak Aktif</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Tanggal Masuk</label>
<input type="date" name="tanggal_masuk" class="form-control">
</div>

</div>

{{-- KONTAK --}}
<h5 class="section-title">Kontak</h5>

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">No HP</label>
<input type="text" name="no_hp" class="form-control" placeholder="No HP">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" placeholder="Email">
</div>

<div class="col-md-12 mb-3">
<label class="form-label">Alamat</label>
<textarea name="alamat" rows="3" class="form-control" placeholder="Alamat"></textarea>
</div>

</div>

{{-- BUTTON --}}
<div class="d-flex justify-content-end gap-2 mt-4">

<a href="{{ route('karyawan.index') }}" class="btn btn-light">
Batal
</a>

<button type="submit" class="btn btn-primary">
<i class="mdi mdi-plus"></i> Tambah
</button>

</div>

</form>

</div>
</div>

</div>
</div>

@endsection
@push('styles')
<style>

.form-label{
display:block;
margin-bottom:6px;
font-weight:500;
}

.form-control,
.form-select{
width:100%;
height:45px;           /* samakan tinggi */
padding:10px 12px;     /* samakan padding */
border-radius:6px;
border:1px solid #ced4da;
font-size:14px;
}

textarea.form-control{
height:auto;           /* supaya textarea tidak kependekan */
}

.row{
row-gap:10px;
}

.card-body{
max-width:900px;
margin:auto;
}

/* subjudul */
.page-title{
font-size:26px;
font-weight:600;
margin-bottom:30px;
}

.section-title{
font-size:16px;
font-weight:600;
padding-bottom:6px;
margin-bottom:20px;   /* jarak ke form di bawahnya */
margin-top:35px;      /* jarak dari section sebelumnya */
border-bottom:1px solid #e5e7eb;
}

.section-title:first-of-type{
margin-top:30px;
}

</style>
@endpush