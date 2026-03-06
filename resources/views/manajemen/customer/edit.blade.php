@extends('layouts.admin')

@section('title','Edit Customer')

@section('content')

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h4 class="card-title mb-4">Form Edit Customer</h4>

<form method="POST" action="{{ route('manajemen.customer.update', $customer->id_cust) }}">
@csrf
@method('PUT')


{{-- NAMA & NO HP --}}
<div class="row">

<div class="col-md-6">
<div class="form-group">
<label>Nama Lengkap</label>
<input type="text"
       name="nama_lengkap"
       class="form-control"
       placeholder="Masukkan nama customer"
       value="{{ old('nama_lengkap', $customer->nama_lengkap) }}">
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label>No WhatsApp</label>
<input type="text"
       name="no_telp"
       class="form-control"
       placeholder="08xxxxxxxx"
       value="{{ old('no_telp', $customer->no_telp) }}">
</div>
</div>

</div>


{{-- ALAMAT --}}
<div class="form-group">
<label>Alamat</label>
<textarea name="alamat"
          rows="3"
          class="form-control"
          placeholder="Masukkan alamat customer">{{ old('alamat', $customer->alamat) }}</textarea>
</div>


{{-- AMBIL LOKASI --}}
<div class="form-group">

<a onclick="ambilLokasi()" class="btn btn-outline-primary btn-sm">
<i class="mdi mdi-map-marker"></i> Ambil Titik Lokasi
</a>

<small id="lokasiStatus" class="text-muted d-block mt-2">
@if($customer->latitude && $customer->longitude)
Lokasi tersimpan ✔
@endif
</small>

</div>


<input type="hidden" name="latitude" id="latitude"
value="{{ old('latitude', $customer->latitude) }}">

<input type="hidden" name="longitude" id="longitude"
value="{{ old('longitude', $customer->longitude) }}">


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
       {{ $customer->is_member ? 'checked' : '' }}>

</div>

</div>


{{-- DETAIL MEMBER --}}
@if($customer->is_member)
<div class="mt-3 p-3 bg-light border rounded" style="max-width:400px;">

<h6 class="mb-2">Detail Member</h6>

<p class="mb-1"><b>Kode Member:</b> {{ $customer->member_code ?? '-' }}</p>
<p class="mb-1"><b>Tanggal Bergabung:</b> {{ $customer->member_since ?? '-' }}</p>
<p class="mb-0"><b>Poin:</b> {{ $customer->member_points ?? 0 }}</p>

</div>
@endif


{{-- BUTTON --}}
<div class="text-right mt-4">

<a href="{{ route('manajemen.customer.index') }}"
class="btn btn-light">
Batal
</a>

<button class="btn btn-primary">
<i class="mdi mdi-content-save"></i> Simpan Perubahan
</button>

</div>


</form>

</div>
</div>

</div>
</div>


<style>

.form-group label{
font-weight:500;
margin-bottom:6px;
display:block;
}

</style>


<script>
function ambilLokasi(){

if(!navigator.geolocation){
alert("Browser tidak mendukung GPS.");
return;
}

navigator.geolocation.getCurrentPosition(function(position){

document.getElementById('latitude').value = position.coords.latitude;
document.getElementById('longitude').value = position.coords.longitude;

document.getElementById('lokasiStatus').innerHTML =
"Lokasi berhasil diperbarui ✔";

}, function(){
alert("Gagal mengambil lokasi. Pastikan GPS aktif.");
});

}
</script>

@endsection