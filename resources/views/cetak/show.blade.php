@extends('layouts.admin')

@section('title','Detail Custom Nota')

@section('content')

<div class="card">
    <div class="card-body">
        <h4>{{ $data->nama_toko }}</h4>
        <p>Telepon: {{ $data->telepon }}</p>
        <p>Alamat: {{ $data->alamat }}</p>
        <p>Jam: {{ $data->jam_buka }}</p>
        <p>Footer: {{ $data->footer }}</p>
        <p>Status: {{ $data->status ? 'Aktif' : 'Nonaktif' }}</p>
    </div>
</div>

@endsection