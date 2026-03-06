@php
$role = auth()->user()->role;
@endphp

@extends(
    auth()->user()->role === 'admin'
        ? 'layouts.admin'
        : 'layouts.dashboard_kasir'
)

@section('title','Riwayat Pemesanan')

@section('content')

<h3 class="page-title mb-4">Riwayat Pemesanan Laundry</h3>

<div class="card">
<div class="card-body">

{{-- ================= FILTER ================= --}}
<form method="GET" action="{{ route($role.'.riwayat.index') }}">

<div class="row mb-4">

<div class="col-md-4">
<select name="layanan" class="form-control">

<option value="">Jenis Layanan</option>

<option value="cuci"
{{ request('layanan')=='cuci'?'selected':'' }}>
Cuci
</option>

<option value="setrika"
{{ request('layanan')=='setrika'?'selected':'' }}>
Setrika
</option>

<option value="cuci_setrika"
{{ request('layanan')=='cuci_setrika'?'selected':'' }}>
Cuci Setrika
</option>

<option value="sprei"
{{ request('layanan')=='sprei'?'selected':'' }}>
Sprei
</option>

</select>
</div>

<div class="col-md-4">
<input
type="date"
name="from"
value="{{ request('from') }}"
class="form-control">
</div>

<div class="col-md-4">
<button class="btn btn-primary btn-block">
<i class="mdi mdi-filter"></i> Terapkan
</button>
</div>

</div>

</form>


{{-- ================= TABLE ================= --}}
<div class="table-responsive">

<table id="table-riwayat" class="table table-striped">

<thead class="bg-dark text-white">
<tr>
<th>No Order</th>
<th>Nama</th>
<th>Total</th>
<th>Pembayaran</th>
<th>Status</th>
<th class="text-center">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($pemesanans as $p)

@php
$history = $p->historyPemesanan->last();
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

<span class="badge badge-success">
Lunas
</span>

@else

<span class="badge badge-warning">
Belum Bayar
</span>

@endif

</td>

<td>

<span class="badge badge-info">
{{ ucfirst($p->status_proses) }}
</span>

</td>

<td class="text-center">

<div class="d-flex justify-content-center align-items-center">

{{-- UNDUH --}}
@if(auth()->user()->role === 'admin')

<a
href="{{ route('admin.riwayat.download',$p->id_pemesanan) }}"
class="btn btn-sm btn-outline-primary mr-2"
title="Unduh">

<i class="mdi mdi-download"></i>

</a>

@endif


{{-- HAPUS --}}
@if(auth()->user()->role === 'admin')

<form
method="POST"
action="{{ route('admin.riwayat.destroy',$p->id_pemesanan) }}"
onsubmit="return confirm('Hapus riwayat ini?')">

@csrf
@method('DELETE')

<button
class="btn btn-sm btn-outline-danger"
title="Hapus">

<i class="mdi mdi-delete"></i>

</button>

</form>

@endif

</div>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center">
Tidak ada riwayat pemesanan
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

$('#table-riwayat').DataTable();

});

</script>

@endpush