@extends('layouts.admin')

@section('title','Manajemen Harga')

@section('content')

<div class="page-header">
    <h3 class="page-title">Manajemen Harga</h3>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <a href="{{ route('manajemen.harga.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Tambah Harga
        </a>
    </div>
</div>

{{-- FILTER TABS (disamakan dengan pemesanan) --}}
<div class="order-tabs mb-4">

<a href="{{ route('manajemen.harga.index') }}"
   class="tab {{ !request('kategori') ? 'active' : '' }}">
   Semua
</a>

<a href="{{ route('manajemen.harga.index',['kategori'=>'laundry']) }}"
   class="tab {{ request('kategori')=='laundry' ? 'active' : '' }}">
   Laundry
</a>

<a href="{{ route('manajemen.harga.index',['kategori'=>'jasa']) }}"
   class="tab {{ request('kategori')=='jasa' ? 'active' : '' }}">
   Jasa
</a>

</div>

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<div class="table-responsive">

<table class="table table-striped" id="tableHarga">

<thead>
<tr>
<th>No</th>
<th>Kategori</th>
<th>Jenis Layanan</th>
<th>Satuan</th>
<th>Jarak</th>
<th>Harga</th>
<th>Status</th>
<th class="text-center">Aksi</th>
</tr>
</thead>

<tbody>

@forelse ($harga as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ ucfirst($item->kategori) }}</td>

<td>{{ $item->nama_layanan }}</td>

<td>{{ $item->satuan }}</td>

<td>
@if ($item->kategori == 'jasa')
    {{ $item->jarak ?? '-' }} km
@else
    -
@endif
</td>

<td>Rp {{ number_format($item->harga,0,',','.') }}</td>

<td>
<span class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}">
{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
</span>
</td>

<td class="text-center align-middle">

<a href="{{ route('manajemen.harga.edit', $item->id) }}"
   class="btn btn-sm btn-outline-primary">
   <i class="mdi mdi-pencil"></i>
</a>

<form action="{{ route('manajemen.harga.destroy', $item->id) }}"
      method="POST"
      style="display:inline;"
      onsubmit="return confirm('Yakin hapus data harga ini?')">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-outline-danger">
<i class="mdi mdi-delete"></i>
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="8" class="text-center text-muted">
Belum ada data harga
</td>
</tr>

@endforelse

</tbody>
</table>

</div>
</div>
</div>

</div>
</div>

@endsection


@push('scripts')

<script>
$(document).ready(function(){

    $('#tableHarga').DataTable({
        responsive: false,
        autoWidth: false,
        scrollX: true
    });

});
</script>

@endpush

@push('styles')
<style>

    .order-tabs{
    display:flex;
    gap:25px;
    border-bottom:2px solid #e2e8f0;
    padding-bottom:8px;
    }

    .order-tabs .tab{
    text-decoration:none;
    font-weight:600;
    font-size:14px;
    color:#6c757d;
    padding-bottom:6px;
    position:relative;
    }

    .order-tabs .tab.active{
    color:#4B49AC;
    }

    .order-tabs .tab.active::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-10px;
    width:100%;
    height:3px;
    background:#4B49AC;
    border-radius:3px;
    }

    .order-tabs .tab:hover{
    color:#4B49AC;
    }

    </style>
@endpush