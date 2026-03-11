@extends('layouts.auth')

@section('title','Register')

@section('content')

{{-- LEFT --}}
<div class="auth-left">

<div class="logo">
🧺 Laundio
</div>

<div class="auth-title">
Register
</div>

<div class="auth-sub">
Buat akun baru untuk menggunakan sistem manajemen laundry
</div>

@if ($errors->any())
<div class="alert alert-danger">
{{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('register') }}">
@csrf

<div class="form-grid">

{{-- NAMA --}}
<div class="form-group">
<input
type="text"
name="nama"
class="form-control"
placeholder="Nama Lengkap"
value="{{ old('nama') }}"
required
>
</div>

{{-- NO TELP --}}
<div class="form-group">
<input
type="text"
name="no_telp"
class="form-control"
placeholder="No Telepon"
value="{{ old('no_telp') }}"
required
>
</div>

{{-- EMAIL --}}
<div class="form-group form-group-full">
<input
type="email"
name="email"
class="form-control"
placeholder="Email"
value="{{ old('email') }}"
required
>
</div>

{{-- PASSWORD --}}
<div class="form-group">
<input 
type="password"
name="password"
class="form-control"
placeholder="Password"
required
>
</div>

{{-- KONFIRMASI PASSWORD --}}
<div class="form-group">
<input
type="password"
name="password_confirmation"
class="form-control"
placeholder="Konfirmasi Password"
required
>
</div>

</div>

<button type="submit" class="btn-login">
Register
</button>

</form>

<div class="auth-register">
Sudah punya akun?
<a href="{{ route('login') }}">Login</a>
</div>

</div>

{{-- RIGHT --}}
<div class="auth-right">

<div class="machine">

<div class="machine-panel"></div>

<div class="drum">
<div class="water"></div>
</div>

<div class="bubble b1"></div>
<div class="bubble b2"></div>
<div class="bubble b3"></div>
<div class="bubble b4"></div>

</div>

</div>

@endsection