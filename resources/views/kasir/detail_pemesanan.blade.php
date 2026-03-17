@extends('layouts.admin')

@section('title','Detail Pemesanan')

@section('content')

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h4 class="card-title">Detail Pemesanan</h4>

<div class="row">

<div class="col-md-6">

<p><strong>No Order :</strong> {{ $data->no_order }}</p>

<hr>

<h5 class="mb-3">Data Customer</h5>

<p><strong>Nama :</strong> {{ $data->customer->nama_lengkap ?? '-' }}</p>
<p><strong>No Telepon :</strong> {{ $data->customer->no_telp ?? '-' }}</p>
<p><strong>Alamat :</strong> {{ $data->customer->alamat ?? '-' }}</p>

<hr>

<h5 class="mb-3">Detail Pesanan</h5>

<p><strong>Outlet :</strong> {{ $data->outlet->nama_outlet ?? '-' }}</p>
<p><strong>Jenis Layanan :</strong> {{ $data->jenis_layanan }}</p>
<p><strong>Berat Cucian :</strong> {{ $data->berat_cucian }} Kg</p>
<p><strong>Jumlah Item :</strong> {{ $data->jumlah_item }}</p>
<p><strong>Catatan :</strong> {{ $data->catatan_khusus ?? '-' }}</p>

</div>


<div class="col-md-6">

<hr class="d-md-none">

<h5 class="mb-3">Status Pesanan</h5>

<p>
<strong>Status Proses :</strong> 
<span class="badge badge-warning">
{{ ucfirst($data->status_proses) }}
</span>
</p>

<p>
<strong>Status Bayar :</strong> 
<span class="badge badge-success">
{{ ucfirst($data->status_bayar) }}
</span>
</p>

<hr>

<h5 class="mb-3">Pembayaran</h5>

<p>
<strong>Total Harga :</strong>  
Rp {{ number_format($data->total_harga,0,',','.') }}
</p>

<p>
<strong>Tanggal Masuk :</strong>  
{{ \Carbon\Carbon::parse($data->tanggal_masuk)->format('d M Y H:i') }}
</p>

</div>

</div>


<div class="mt-4">
<a href="{{ route('kasir.dashboard') }}" class="btn btn-light">
<i class="mdi mdi-arrow-left"></i> Kembali
</a>
</div>

</div>
</div>

</div>
</div>

@endsection