@extends('layouts.admin')

@section('title','Pengaturan Cetak Nota')

@section('content')

<h3 class="mb-4">Pengaturan Cetak Nota</h3>

<div class="card">
<div class="card-body">

<form method="POST"
    action="{{ isset($data) ? route('cetak.update', $data->id) : route('cetak.store') }}">
    @csrf

    @if(isset($data))
        @method('PUT')
    @endif

<div class="modern-field">
    <input type="text" name="nama_toko"
        value="{{ $data->nama_toko ?? '' }}"
        placeholder=" ">
    <label>Nama Toko</label>
</div>

<div class="modern-field">
    <textarea name="alamat" rows="3" placeholder=" ">{{ $data->alamat ?? '' }}</textarea>
    <label>Alamat</label>
</div>

<div class="modern-field">
    <input type="text" name="telepon"
        value="{{ $data->telepon ?? '' }}"
        placeholder=" ">
    <label>Telepon</label>
</div>

<div class="form-group">
    <label class="colorful-label">Jam Operasional</label>

    <div class="jam-wrapper">
        <input type="time" name="jam_mulai"
            value="{{ isset($data->jam_buka) ? explode(' - ', $data->jam_buka)[0] : '' }}"
            class="form-control">

        <span class="jam-separator">-</span>

        <input type="time" name="jam_tutup"
            value="{{ isset($data->jam_buka) && str_contains($data->jam_buka, ' - ') ? explode(' - ', $data->jam_buka)[1] : '' }}"
            class="form-control">
    </div>
</div>

<div class="modern-field">
    <textarea name="footer" rows="3" placeholder=" ">{{ $data->footer ?? '' }}</textarea>
    <label>Footer Nota</label>
</div>

<div class="form-group">
    <label class="form-label colorful-label">Tipe Kertas</label>

    <div class="paper-options">
        <label class="paper-card">
            <input type="radio" name="tipe_kertas" value="53mm"
                {{ ($data->tipe_kertas ?? '') == '53mm' ? 'checked' : '' }}>
            <span>53 mm</span>
        </label>

        <label class="paper-card">
            <input type="radio" name="tipe_kertas" value="80mm"
                {{ ($data->tipe_kertas ?? '') == '80mm' ? 'checked' : '' }}>
            <span>80 mm</span>
        </label>
    </div>
</div>

<div class="modern-field">
    <input type="number" name="custom_width"
        value="{{ $data->custom_width ?? '' }}"
        placeholder=" ">
    <label>Custom Width</label>
<small class="text-muted">Kosongkan jika pakai default</small>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group d-flex justify-content-between align-items-center">
            <label class="form-label colorful-label mb-0">
                Tampilkan Google Maps
            </label>

            <label class="switch mb-0">
                <input type="checkbox" name="show_maps" value="1"
                    {{ ($data->show_maps ?? 0) == 1 ? 'checked' : '' }}>
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group d-flex justify-content-between align-items-center">
            <label class="form-label colorful-label mb-0">
                Tampilkan Logo
            </label>

            <label class="switch mb-0">
                <input type="checkbox" name="show_logo" value="1"
                    {{ ($data->show_logo ?? 0) == 1 ? 'checked' : '' }}>
                <span class="slider round"></span>
            </label>
        </div>
    </div>
</div>

<button class="btn btn-primary">Simpan</button>

</form>

</div>
</div>

@endsection

<style>
    .colorful-label{
    font-weight: 600;
    color: #6366f1;
    font-size: 14px;
}

/* css radio card */
    .paper-options{
    display: flex;
    gap: 15px;
}

.paper-card{
    border: 2px solid #d1d5db;
    padding: 12px 20px;
    border-radius: 12px;
    cursor: pointer;
    transition: 0.3s;
}

.paper-card:hover{
    border-color: #6366f1;
    background: #eef2ff;
}

.paper-card input{
    margin-right: 8px;
}

/* css toggle switch */
    .switch {
    position: relative;
    display: inline-block;
    width: 55px;
    height: 28px;
}

.switch input {
    display: none;
}

.slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: #d1d5db;
    transition: .4s;
    border-radius: 30px;
}

.slider:before {
    content: "";
    position: absolute;
    height: 22px;
    width: 22px;
    left: 3px;
    bottom: 3px;
    background: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background: #14b8a6;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

/* css field */
.modern-field{
    position: relative;
    margin-bottom: 20px;
}

.modern-field input,
.modern-field textarea{
    width: 100%;
    padding: 16px 12px 8px;
    border: 1.5px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    background: #fff;
    transition: 0.3s;
}

.modern-field label{
    position: absolute;
    top: 10px;
    left: 12px;
    font-size: 13px;
    color: #6366f1;
    background: white;
    padding: 0 4px;
    transition: 0.3s;
    pointer-events: none;
}

.modern-field input:focus,
.modern-field textarea:focus{
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}

.modern-field input:focus + label,
.modern-field input:not(:placeholder-shown) + label,
.modern-field textarea:focus + label,
.modern-field textarea:not(:placeholder-shown) + label{
    top: -8px;
    font-size: 11px;
    color: #14b8a6;
}

/* buat jam */
.jam-wrapper{
    display: flex;
    align-items: center;
    gap: 10px;
}

.jam-separator{
    font-size: 20px;
    font-weight: bold;
    color: #6366f1;
}
</style>