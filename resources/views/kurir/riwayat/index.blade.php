@extends('layouts.admin')

@section('title','Riwayat Kurir')

@section('content')

<h3 class="page-title mb-4">Riwayat Tugas Kurir</h3>

<div class="card">
<div class="card-body">

{{-- FILTER --}}
<form method="GET" action="{{ route('kurir.riwayat.index') }}">

<div class="row mb-4">

<div class="col-md-4">
<input type="date" name="from" value="{{ request('from') }}" class="form-control">
</div>

<div class="col-md-4">
<input type="date" name="to" value="{{ request('to') }}" class="form-control">
</div>

<div class="col-md-4">
<button class="btn btn-primary btn-block">
Filter
</button>
</div>

</div>

</form>

{{-- TABLE --}}
<div class="table-responsive">

<table class="table table-striped" id="table-riwayat">

<thead>
<tr>
<th>No Order</th>
<th>Customer</th>
<th>Total</th>
<th>Pembayaran</th>
<th>Status</th>
<th>Jenis</th>
</tr>
</thead>

<tbody>

@forelse($pemesanans as $p)

@php
$history = optional($p->historyPemesanan)->last();
$pembayaran = $history->pembayaran ?? 'belum_bayar';
@endphp

<tr>

<td>{{ $p->no_order }}</td>

<td>{{ $p->customer->nama_lengkap ?? '-' }}</td>

<td>
Rp {{ number_format($p->total_harga ?? 0,0,',','.') }}
</td>

<td>
@if($pembayaran === 'lunas')
<span class="badge badge-success">Lunas</span>
@else
<span class="badge badge-warning">Belum Bayar</span>
@endif
</td>

<td>
<span class="badge badge-info">
{{ ucfirst($p->status_proses) }}
</span>
</td>

<td>
@if($p->jenis_pengambilan == 'pickup_kurir')
<span class="badge badge-primary">Pickup</span>
@else
<span class="badge badge-success">Delivery</span>
@endif
</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center py-4">
Tidak ada riwayat tugas
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>
</div>

@endsection


@push('scripts')
<script>
$(document).ready(function(){
    //$('#table-riwayat').DataTable();
});
</script>
@endpush