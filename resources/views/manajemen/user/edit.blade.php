@extends('layouts.admin')

@section('title','Edit User')

@section('content')

<div class="page-header">
    <h3 class="page-title">Edit User</h3>
</div>

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">

<div class="card-body">

<form method="POST" action="{{ route('manajemen.user.update', $user) }}">
@csrf
@method('PUT')

<div class="row">

    {{-- NAMA --}}
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama</label>
            <input type="text"
                   name="nama"
                   class="form-control"
                   value="{{ $user->nama }}">
        </div>
    </div>

    {{-- EMAIL --}}
    <div class="col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ $user->email }}">
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
                   value="{{ $user->no_telp }}">
        </div>
    </div>

    {{-- ROLE --}}
    <div class="col-md-6">
        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control">

                <option value="admin"
                    @selected($user->role=='admin')>
                    Admin
                </option>

                <option value="kasir"
                    @selected($user->role=='kasir')>
                    Kasir
                </option>

            </select>
        </div>
    </div>

</div>

<div class="mt-3 d-flex gap-2">

    <a href="{{ route('manajemen.user.index') }}"
       class="btn btn-secondary btn-sm">
        Kembali
    </a>

    <button class="btn btn-primary btn-sm">
        Update
    </button>

</div>

</form>

</div>
</div>
</div>
</div>

@endsection