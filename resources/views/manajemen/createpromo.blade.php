@extends('layouts.admin')

@section('title', 'Input Promo')

@section('content')

<h3 class="page-title mb-4">Input Promo</h3>

<div class="card">
<div class="card-body">

@if ($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


<form method="POST" action="{{ route('manajemen.storepromo') }}">
@csrf


{{-- NAMA & SKEMA --}}
<div class="row">

<div class="col-md-6 mb-3">
<label>Nama Promo</label>
<input type="text"
name="nama_promo"
class="form-control"
placeholder="Nama Promo"
required>
</div>

<div class="col-md-6 mb-3">
<label>Skema Promo</label>
<input type="text"
name="skema"
class="form-control"
placeholder="Skema Promo"
required>
</div>

</div>



{{-- BASIS & NILAI --}}
<div class="row">

<div class="col-md-6 mb-3">
<label>Basis Promo</label>
<select name="basis_promo" class="form-control" required>
<option value="">Basis Promo</option>
<option value="nominal">Promo Nominal (Rp)</option>
<option value="persentase">Promo Persentase (%)</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Nilai Promo</label>
<input type="number"
name="nilai_promo"
class="form-control"
placeholder="Nilai Promo (Rp / %)"
min="0"
required>
</div>

</div>



{{-- STATUS & TANGGAL --}}
<div class="row">

<div class="col-md-4 mb-3">
<label>Status</label>
<select name="status" class="form-control" required>
<option value="">Status</option>
<option value="aktif">Aktif</option>
<option value="nonaktif">Non Aktif</option>
</select>
</div>

<div class="col-md-4 mb-3">
<label>Tanggal Mulai</label>
<input type="date"
name="tanggal_mulai"
class="form-control"
required>
</div>

<div class="col-md-4 mb-3">
<label>Tanggal Selesai</label>
<input type="date"
name="tanggal_selesai"
class="form-control"
required>
</div>

</div>



{{-- MIN TRANSAKSI | MAX PROMO | KUOTA --}}
<div class="row">

<div class="col-md-4 mb-3">
<label>Minimal Transaksi</label>
<input type="number"
name="minimal_transaksi"
class="form-control"
placeholder="Rp Min. Transaksi"
min="0">
</div>

<div class="col-md-4 mb-3">
<label>Maksimal Promo</label>
<input type="number"
name="maksimal_diskon"
class="form-control"
placeholder="Rp Max. Promo"
min="0">
</div>

<div class="col-md-4 mb-3">
<label>Kuota Promo</label>
<input type="number"
name="kuota"
class="form-control"
placeholder="Kuota Promo"
min="1">
</div>

</div>



{{-- ROLE | TARGET | MEMBER --}}
<div class="row">

<div class="col-md-4 mb-3">
<label>Role Akses</label>
<select name="role_akses" class="form-control" required>
<option value="">Role Akses</option>
<option value="admin">Admin</option>
<option value="kasir">Kasir</option>
<option value="semua">Semua</option>
</select>
</div>

<div class="col-md-4 mb-3">
<label>Target Promo</label>
<select name="target_diskon" class="form-control" required>
<option value="">Target Promo</option>
<option value="produk">Harga Produk</option>
<option value="ongkir">Ongkir</option>
<option value="pelayanan">Biaya Pelayanan</option>
</select>
</div>

<div class="col-md-4 mb-3">
<label>Khusus Member?</label>
<select name="khusus_member" class="form-control" required>
<option value="">Khusus Member?</option>
<option value="1">Ya</option>
<option value="0">Tidak</option>
</select>
</div>

</div>



{{-- DESKRIPSI --}}
<div class="form-group mb-4">
<label>Deskripsi Promo</label>
<textarea
name="deskripsi_promo"
class="form-control"
rows="4"
placeholder="Deskripsi Promo"
required></textarea>
</div>



{{-- BUTTON --}}
<div class="d-flex">

<a href="{{ route('manajemen.indexpromo') }}"
class="btn btn-secondary mr-2">
Batal
</a>

<button type="submit"
class="btn btn-primary">
Tambah Promo
</button>

</div>


</form>

</div>
</div>

@endsection