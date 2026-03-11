@extends('layouts.auth')

@section('title','Login')

@section('content')

{{-- LEFT SIDE --}}
<div class="auth-left">

<div class="logo">
🧺 Laundio
</div>

<div class="auth-title">
Login
</div>

<div class="auth-sub">
Masuk ke sistem manajemen laundry
</div>

@if ($errors->any())
<div class="alert alert-danger">
{{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('login') }}">
@csrf

<div class="form-group">
<input 
type="email"
name="email"
class="form-control"
placeholder="Email"
required
>
</div>

<div class="form-group">
<input 
type="password"
name="password"
class="form-control"
placeholder="Password"
required
>
</div>

<button type="submit" class="btn-login">
Login
</button>

</form>

{{-- REGISTER CTA --}}
<div class="auth-register">
Belum punya akun?
<a href="{{ route('register') }}">Daftar sekarang</a>
</div>

</div>


{{-- RIGHT SIDE --}}
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