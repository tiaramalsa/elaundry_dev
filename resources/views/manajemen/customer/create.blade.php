@extends('layouts.dashboard')

@section('title', 'Tambah Customer')

@section('content')
<div class="page-title">Form Tambah Customer</div>

<div class="card" style="max-width: 100%;">

    <form method="POST" action="{{ route('manajemen.customer.store') }}">
    @csrf

    <h4>DATA CUSTOMER</h4>

    {{-- ROW 1 : NAMA & NO HP --}}
    <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:15px;">
        <div style="flex:1; min-width:250px;">
            <input
                type="text"
                name="nama_lengkap"
                placeholder="Nama Lengkap"
                value="{{ old('nama_lengkap') }}"
            >
        </div>

        <div style="flex:1; min-width:250px;">
            <input
                type="text"
                name="no_telp"
                placeholder="No WhatsApp"
                value="{{ old('no_telp') }}"
            >
        </div>
    </div>

    {{-- ALAMAT --}}
    <div style="margin-bottom:10px;">
        <textarea
            name="alamat"
            rows="3"
            placeholder="Alamat"
        >{{ old('alamat') }}</textarea>
    </div>

    {{-- AMBIL LOKASI --}}
    <div style="margin-bottom:20px;">
        <span onclick="ambilLokasi()"
            style="cursor:pointer; color:#1e3a8a; font-size:14px;">
            📍 Ambil Titik Lokasi
        </span>

        <small id="lokasiStatus"
            style="display:block; margin-top:5px; color:#64748b;">
        </small>
    </div>

    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">

    <hr style="margin:20px 0; border:0; border-top:1px solid #e5e7eb;">

    {{-- MEMBER --}}
    <div style="display:flex; justify-content:space-between; align-items:center; max-width:350px;">

        <div>
            <div style="font-weight:500;">Member</div>
            <small style="color:#6b7280;">
                Aktifkan jika customer adalah member
            </small>
        </div>

        <label class="switch">
            <input type="hidden" name="is_member" value="0">
            <input type="checkbox"
                name="is_member"
                value="1"
                {{ old('is_member') ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>

    </div>

    {{-- ACTION --}}
    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:25px;">
        <a href="{{ route('manajemen.customer.index') }}"
        class="btn"
        style="background:#94a3b8;">
            Batal
        </a>

        <button class="btn" style="background:#fb923c; color:white;">
            + Tambah
        </button>
    </div>

    </form>
</div>

<script>
    async function ambilLokasi() {

        if (!navigator.geolocation) {
            alert("Browser tidak mendukung GPS.");
            return;
        }

        navigator.geolocation.getCurrentPosition(async function(position) {

            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;

            document.getElementById('lokasiStatus').innerHTML =
                "Mengambil alamat...";

            try {
                // Reverse Geocoding via OpenStreetMap
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`
                );

                const data = await response.json();

                if (data.display_name) {
                    document.querySelector('textarea[name="alamat"]').value =
                        data.display_name;

                    document.getElementById('lokasiStatus').innerHTML =
                        "Lokasi & alamat berhasil diambil ✔";
                } else {
                    document.getElementById('lokasiStatus').innerHTML =
                        "Lokasi berhasil diambil, alamat tidak ditemukan";
                }

            } catch (error) {
                document.getElementById('lokasiStatus').innerHTML =
                    "Lokasi berhasil diambil, tapi gagal ambil alamat";
            }

        }, function() {
            alert("Gagal mengambil lokasi. Pastikan GPS aktif.");
        });
    }
</script>

{{-- STYLE (KONSISTEN DENGAN HALAMAN KARYAWAN) --}}
<style>
    .page-title {
        font-weight: 600;
        margin-bottom: 16px;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
    }

    input::placeholder,
    textarea::placeholder {
        color: #9ca3af;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
    }

    .btn:hover {
        opacity: 0.9;
    }

    /* TOGGLE */

    .toggle-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 15px;
        max-width: 300px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #e2e8f0;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        content: "";
        position: absolute;
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .switch input:checked + .slider {
        background-color: #16a39a;
    }

    .switch input:checked + .slider:before {
        transform: translateX(24px);
    }
    
</style>
@endsection
