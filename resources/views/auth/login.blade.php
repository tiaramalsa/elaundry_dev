@extends('layouts.auth')

@section('title','Login')

@section('content')

{{-- LEFT SIDE --}}
<div class="auth-left">

<div class="logo">
    <img src="{{ asset('admin/assets/images/Logo C24-text.png') }}" alt="Logo" class="logo-img">
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

<div class="auth-register">
Belum punya akun?
<a href="{{ route('register') }}">Register sekarang</a>
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

<style>
.logo {
    position: relative;
    height: 80px; /* container tetap */
    display: flex;
    justify-content: center;
    align-items: center;
}

.logo-img {
    position: absolute;
    height: 250px; /* lebih besar dari container */
}
</style>

@endsection