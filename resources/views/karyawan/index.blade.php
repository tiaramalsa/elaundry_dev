@extends('layouts.admin')

@section('title','Data Karyawan')

@section('content')

<div class="row">
<div class="col-12">

<div class="card">
<div class="card-body">

<h4 class="card-title mb-4">Data Karyawan</h4>

{{-- TOP ACTION --}}
<div class="d-flex justify-content-between mb-3 flex-wrap gap-2">

<div>
<a href="{{ route('karyawan.export.pdf') }}" class="btn btn-danger btn-sm">
<i class="mdi mdi-file-pdf"></i> Unduh PDF
</a>

<a href="{{ route('karyawan.export.csv') }}" class="btn btn-success btn-sm">
<i class="mdi mdi-file-excel"></i> Unduh CSV
</a>
</div>

<a href="{{ route('karyawan.create') }}" class="btn btn-primary btn-sm">
<i class="mdi mdi-plus"></i> Tambah Karyawan
</a>

</div>

{{-- TABLE --}}
<div class="table-responsive">

<table id="table-karyawan" class="table table-striped table-bordered">

<thead class="table-dark">
<tr>
<th class="text-center">No</th>
<th>Nama Karyawan</th>
<th>ID Karyawan</th>
<th>JK</th>
<th>Outlet</th>
<th class="text-center">Status</th>
<th class="text-center">Aksi</th>
</tr>
</thead>

<tbody>

@forelse ($karyawans as $karyawan)

<tr>
<td class="text-center">{{ $loop->iteration }}</td>

<td>{{ $karyawan->nama_karyawan }}</td>

<td>{{ $karyawan->id_karyawan }}</td>

<td>{{ $karyawan->jenis_kelamin }}</td>

<td>{{ $karyawan->outlet->nama_outlet ?? '-' }}</td>

<td class="text-center">

@php
$status = strtolower(trim($karyawan->status));
@endphp

@if ($status == 'aktif')
<span class="badge bg-success">Aktif</span>

@elseif ($status == 'tidak_aktif')
<span class="badge bg-secondary">Tidak Aktif</span>

@else
<span class="badge bg-dark">Tidak Diketahui</span>
@endif

</td>

<td class="text-center">

{{-- DETAIL --}}
<a href="{{ route('karyawan.show', $karyawan->id_karyawan) }}"
class="btn btn-info btn-sm">
<i class="mdi mdi-eye"></i>
</a>

{{-- HAPUS --}}
<form action="{{ route('karyawan.destroy', $karyawan->id_karyawan) }}"
method="POST"
style="display:inline;"
onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">

@csrf
@method('DELETE')

<button type="submit" class="btn btn-danger btn-sm">
<i class="mdi mdi-delete"></i>
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="7" class="text-center text-muted">
Belum ada data karyawan
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

$('#table-karyawan').DataTable();

});

</script>
@endpush