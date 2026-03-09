@extends('layouts.admin')

@section('title', 'Manajemen Harga')

@section('content')

<div class="page-header">
    <h3 class="page-title">Manajemen Harga</h3>
</div>

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">

<div class="card-body">

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="card-title mb-0">Daftar Harga</h4>

    <a href="{{ route('manajemen.harga.create') }}" class="btn btn-primary btn-sm">
        <i class="mdi mdi-plus"></i> Tambah Harga
    </a>
</div>

{{-- FILTER --}}
<div class="mb-3">

    <a href="{{ route('manajemen.harga.index') }}"
       class="btn btn-sm {{ !request('kategori') ? 'btn-info' : 'btn-outline-secondary' }}">
        Semua
    </a>

    <a href="{{ route('manajemen.harga.index', ['kategori' => 'laundry']) }}"
       class="btn btn-sm {{ request('kategori') == 'laundry' ? 'btn-info' : 'btn-outline-secondary' }}">
        Laundry
    </a>

    <a href="{{ route('manajemen.harga.index', ['kategori' => 'jasa']) }}"
       class="btn btn-sm {{ request('kategori') == 'jasa' ? 'btn-info' : 'btn-outline-secondary' }}">
        Jasa
    </a>

</div>

{{-- TABLE --}}
<div class="table-responsive">

<table class="table table-bordered table-striped" id="tableHarga">
<thead>
<tr>
    <th>No</th>
    <th>Kategori</th>
    <th>Jenis Layanan</th>
    <th>Satuan</th>
    <th>Jarak</th>
    <th>Harga</th>
    <th>Status</th>
    <th class="text-center" style="width:120px">Aksi</th>
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
<div class="aksi-btn justify-content-center">

<a href="{{ route('manajemen.harga.edit', $item->id) }}"
   class="btn btn-warning btn-sm">
   <i class="mdi mdi-pencil"></i>
</a>

<form action="{{ route('manajemen.harga.destroy', $item->id) }}"
      method="POST"
      class="d-inline-flex"
      onsubmit="return confirm('Yakin hapus data harga ini?')">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
<i class="mdi mdi-delete"></i>
</button>

</form>
</div>
</td>

</tr>

@empty
<tr>
<td colspan="8" class="text-center text-muted">Belum ada data harga</td>
<td style="display:none"></td>
<td style="display:none"></td>
<td style="display:none"></td>
<td style="display:none"></td>
<td style="display:none"></td>
<td style="display:none"></td>
<td style="display:none"></td>
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

<style>
#tableHarga td:last-child{
width:120px;
text-align:center;
}

.aksi-btn{
display:flex;
justify-content:center;
align-items:center;
gap:8px;
}

.aksi-btn form{
margin:0;
display:flex;
}
</style>