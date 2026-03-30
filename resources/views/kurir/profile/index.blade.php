@extends('layouts.admin')

@section('title','Profile Kurir')

@section('content')

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h4 class="card-title font-weight-bold d-flex justify-content-between align-items-center">
    Profile Kurir

    <a href="{{ route('kurir.profile.edit') }}" class="btn btn-primary btn-sm">
        Edit Profile
    </a>
</h4>

<div class="row">

{{-- DATA DIRI --}}
<div class="col-md-6">

<h5 class="mb-3">Data Diri</h5>

<p><span class="font-weight-bold">Nama :</span> {{ $user->nama }}</p>
<p><span class="font-weight-bold">Email :</span> {{ $user->email }}</p>
<p><span class="font-weight-bold">No HP :</span> {{ $user->no_telp ?? '-' }}</p>
<p><span class="font-weight-bold">Alamat :</span> {{ $user->alamat ?? '-' }}</p>

<div class="mt-2">
    @if($kurir && $kurir->foto)
        <img src="{{ asset('storage/'.$kurir->foto) }}" width="120" class="rounded">
    @else
        <img src="https://via.placeholder.com/120x120.png?text=No+Photo" class="rounded">
    @endif
</div>

</div>

{{-- DATA PEKERJAAN --}}
<div class="col-md-6">

<h5 class="mb-3">Data Pekerjaan</h5>

<p><strong>ID Kurir :</strong> {{ $kurir->id_kurir ?? '-' }}</p>

<p>
<strong>Status :</strong> 
<span class="badge badge-success">
{{ $kurir->status ?? '-' }}
</span>
</p>

<p><strong>Bergabung :</strong> {{ $kurir->bergabung_sejak ?? '-' }}</p>
<p><strong>Plat Nomor :</strong> {{ $kurir->plat_nomor ?? '-' }}</p>

</div>

</div>

<hr>

{{-- UBAH PASSWORD --}}
<h5 class="mb-3">Ubah Password</h5>

<form method="POST" action="{{ route('password.update') }}">
@csrf

<div class="row">
<div class="col-md-4">
<input type="password" name="current_password" class="form-control" placeholder="Password Lama">
</div>

<div class="col-md-4">
<input type="password" name="password" class="form-control" placeholder="Password Baru">
</div>

<div class="col-md-4">
<input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
</div>
</div>

<button class="btn btn-primary mt-3">Update Password</button>

</form>

<hr>

{{-- STATISTIK --}}
<h5 class="mb-3">Statistik Kurir</h5>

<div class="row text-center">

<div class="col-md-4">
<h4>{{ $totalDiantar }}</h4>
<p>Total Diantar</p>
</div>

<div class="col-md-4">
<h4>{{ $totalDiambil }}</h4>
<p>Total Diambil</p>
</div>

<div class="col-md-4">
<h4>{{ $orderHariIni }}</h4>
<p>Order Hari Ini</p>
</div>

</div>

</div>
</div>

</div>
</div>

@endsection