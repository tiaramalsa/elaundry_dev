@extends('layouts.admin')

@section('title','Edit Karyawan')

@section('content')

<div class="row">
<div class="col-12">

<div class="card">
<div class="card-body">

<h3 class="card-title page-title">Edit Karyawan</h3>

<form method="POST" action="{{ route('karyawan.update', $karyawan->id_karyawan) }}">
    @csrf
    @method('PUT')

    @if ($errors->any())
        <div style="background:#fee2e2; padding:12px; margin-bottom:15px; border-radius:6px;">
            <ul style="margin:0; padding-left:18px; color:#991b1b;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- DATA PRIBADI --}}
    <h5 class="section-title">Data Pribadi</h5>
    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Nama Karyawan</label>
            <input type="text" name="nama_karyawan" class="form-control"
                   value="{{ $karyawan->nama_karyawan }}" placeholder="Nama Karyawan">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="L" {{ $karyawan->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $karyawan->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control"
                   value="{{ $karyawan->tempat_lahir }}" placeholder="Tempat Lahir">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Agama</label>
            <select name="agama" class="form-select">
                <option value="">Pilih Agama</option>
                <option value="Islam" {{ $karyawan->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                <option value="Kristen" {{ $karyawan->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                <option value="Katolik" {{ $karyawan->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                <option value="Hindu" {{ $karyawan->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                <option value="Buddha" {{ $karyawan->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                <option value="Konghucu" {{ $karyawan->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                <option value="Kepercayaan Lain" {{ $karyawan->agama == 'Kepercayaan Lain' ? 'selected' : '' }}>Kepercayaan Lain</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control"
                   value="{{ optional($karyawan->tanggal_lahir)->format('Y-m-d') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">NIK</label>
            <input type="text" name="nik" class="form-control" value="{{ $karyawan->nik }}" placeholder="NIK">
        </div>

    </div>

    {{-- DATA PEKERJAAN --}}
    <h5 class="section-title">Data Pekerjaan</h5>
    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Jabatan</label>
            <select name="jabatan" class="form-select">
                <option value="">Pilih Jabatan</option>
                <option value="Kasir" {{ $karyawan->jabatan == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="Admin" {{ $karyawan->jabatan == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Supervisor" {{ $karyawan->jabatan == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="Kurir" {{ $karyawan->jabatan == 'Kurir' ? 'selected' : '' }}>Kurir</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Outlet</label>
            <select name="id_outlet" class="form-select" required>
                <option value="">Pilih Outlet</option>
                @foreach($outlets as $outlet)
                    <option value="{{ $outlet->id_outlet }}"
                        {{ old('id_outlet', $karyawan->id_outlet) == $outlet->id_outlet ? 'selected' : '' }}>
                        {{ $outlet->nama_outlet }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="Aktif" {{ $karyawan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ $karyawan->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control"
                   value="{{ optional($karyawan->tanggal_masuk)->format('Y-m-d') }}">
        </div>

    </div>

    {{-- KONTAK --}}
    <h5 class="section-title">Kontak</h5>
    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">No HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ $karyawan->no_hp }}" placeholder="No HP">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $karyawan->email }}" placeholder="Email">
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" rows="3" class="form-control" placeholder="Alamat">{{ $karyawan->alamat }}</textarea>
        </div>

    </div>

    {{-- BUTTON --}}
    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('karyawan.show', $karyawan->id_karyawan) }}" class="btn btn-light">Batal</a>
        <button type="submit" class="btn btn-primary">
            <i class="mdi mdi-content-save"></i> Simpan
        </button>
    </div>

</form>

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
.form-label{
    display:block;
    margin-bottom:6px;
    font-weight:500;
}
.form-control,
.form-select{
    width:100%;
    height:45px;
    padding:10px 12px;
    border-radius:6px;
    border:1px solid #ced4da;
    font-size:14px;
}
textarea.form-control{
    height:auto;
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