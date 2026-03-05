@extends('layouts.admin')

@section('title','Tambah User')

@section('content')

<div class="page-header">
    <h3 class="page-title">Tambah User</h3>
</div>

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">

<div class="card-body">

<form method="POST" action="{{ route('manajemen.user.store') }}">
@csrf

<div class="row">

    {{-- NAMA --}}
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama</label>
            <input type="text"
                   name="nama"
                   class="form-control"
                   placeholder="Masukkan nama">
        </div>
    </div>

    {{-- EMAIL --}}
    <div class="col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   placeholder="Masukkan email">
        </div>
    </div>

</div>

<div class="row">

    {{-- TELEPON --}}
    <div class="col-md-6">
        <div class="form-group">
            <label>No Telepon</label>
            <input type="text"
                   name="no_telp"
                   class="form-control"
                   placeholder="Masukkan nomor telepon">
        </div>
    </div>

    {{-- ROLE --}}
    <div class="col-md-6">
        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
            </select>
        </div>
    </div>

</div>

<div class="row">

    {{-- PASSWORD --}}
    <div class="col-md-6">
        <div class="form-group">
            <label>Password</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Masukkan password">
        </div>
    </div>

</div>

<div class="mt-3 d-flex gap-2">

    <a href="{{ route('manajemen.user.index') }}"
       class="btn btn-secondary btn-sm">
        Kembali
    </a>

    <button type="submit" class="btn btn-primary btn-sm">
        Simpan
    </button>

</div>

</form>

</div>
</div>
</div>
</div>

@endsection