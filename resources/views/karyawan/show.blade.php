@extends('layouts.admin')

@section('title','Detail Karyawan')

@section('content')

<div class="row">
<div class="col-12">

<div class="card">
<div class="card-body">

<h3 class="card-title page-title">Detail Karyawan</h3>

{{-- DATA PRIBADI --}}
<h5 class="section-title">Data Pribadi</h5>
<div class="row">
    <div class="col-md-6 mb-3"><strong>Nama:</strong><br>{{ $karyawan->nama_karyawan }}</div>
    <div class="col-md-6 mb-3"><strong>Jenis Kelamin:</strong><br>{{ $karyawan->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
    <div class="col-md-6 mb-3"><strong>Tempat Lahir:</strong><br>{{ $karyawan->tempat_lahir }}</div>
    <div class="col-md-6 mb-3"><strong>Agama:</strong><br>{{ $karyawan->agama }}</div>
    <div class="col-md-6 mb-3"><strong>Tanggal Lahir:</strong><br>{{ \Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d M Y') }}</div>
    <div class="col-md-6 mb-3"><strong>NIK:</strong><br>{{ $karyawan->nik }}</div>
</div>

{{-- DATA PEKERJAAN --}}
<h5 class="section-title">Data Pekerjaan</h5>
<div class="row">
    <div class="col-md-6 mb-3"><strong>Jabatan:</strong><br>{{ $karyawan->jabatan }}</div>
    <div class="col-md-6 mb-3"><strong>Outlet:</strong><br>{{ $karyawan->outlet->nama_outlet ?? '-' }}</div>
    <div class="col-md-6 mb-3"><strong>Status:</strong><br>
        @php $status = strtolower(trim($karyawan->status)); @endphp
        @if ($status == 'aktif')
            <span class="badge badge-aktif">Aktif</span>
        @elseif ($status == 'tidak_aktif')
            <span class="badge badge-nonaktif">Tidak Aktif</span>
        @else
            <span class="badge badge-nonaktif">Tidak Diketahui</span>
        @endif
    </div>
    <div class="col-md-6 mb-3"><strong>Tanggal Masuk:</strong><br>{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->format('d M Y') }}</div>
</div>

{{-- KONTAK --}}
<h5 class="section-title">Kontak</h5>
<div class="row">
    <div class="col-md-6 mb-3"><strong>No HP:</strong><br>{{ $karyawan->no_hp }}</div>
    <div class="col-md-6 mb-3"><strong>Email:</strong><br>{{ $karyawan->email }}</div>
    <div class="col-md-12 mb-3"><strong>Alamat:</strong><br>{{ $karyawan->alamat }}</div>
</div>

{{-- AKSI --}}
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('karyawan.index') }}" class="btn btn-light">Kembali</a>
    <a href="{{ route('karyawan.edit', $karyawan->id_karyawan) }}" class="btn btn-primary">Edit</a>
</div>

</div>
</div>

</div>
</div>

@endsection

@push('styles')
<style>
.page-title{
    font-size:26px;
    font-weight:600;
    margin-bottom:30px;
}
.section-title{
    font-size:16px;
    font-weight:600;
    padding-bottom:6px;
    margin-bottom:20px;
    margin-top:35px;
    border-bottom:1px solid #e5e7eb;
}
.section-title:first-of-type{
    margin-top:30px;
}

/* Badge Status */
.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}
.badge-aktif {
    background: rgba(22,163,154,0.15);
    color: #16a39a;
}
.badge-nonaktif {
    background: rgba(230,120,0,0.15);
    color: #e67800;
}
.row{
    row-gap:10px;
}
.card-body{
    max-width:900px;
    margin:auto;
}
</style>
@endpush