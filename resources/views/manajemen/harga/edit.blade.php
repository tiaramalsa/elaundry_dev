@extends('layouts.admin')

@section('title','Edit Harga')

@section('content')

<div class="row">
<div class="col-lg-12 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h4 class="card-title mb-4">Edit Harga</h4>

<form action="{{ route('manajemen.harga.update',$harga->id) }}" method="POST">
@csrf
@method('PUT')

<div class="row">

{{-- KATEGORI --}}
<div class="col-md-6 mb-3">
<label>Kategori</label>
<select name="kategori" id="kategori" class="form-control" required>
<option value="">Pilih Kategori</option>
<option value="laundry" {{ $harga->kategori=='laundry'?'selected':'' }}>Laundry</option>
<option value="jasa" {{ $harga->kategori=='jasa'?'selected':'' }}>Jasa</option>
</select>
</div>

{{-- JENIS LAYANAN --}}
<div class="col-md-6 mb-3">
<label>Jenis Layanan</label>

<select id="layanan-select" name="jenis_layanan" class="form-control" required>
<option value="">Pilih Jenis Layanan</option>

<optgroup label="Cuci Setrika" data-kategori="laundry">
<option value="Cuci Setrika Reguler">Cuci Setrika Reguler</option>
<option value="Cuci Setrika Express">Cuci Setrika Express</option>
<option value="Cuci Kering Lipat Reguler">Cuci Kering Lipat Reguler</option>
<option value="Cuci Kering Lipat Express">Cuci Kering Lipat Express</option>
<option value="Cuci Satuan Reguler">Cuci Satuan Reguler</option>
<option value="Cuci Satuan Express">Cuci Satuan Express</option>
</optgroup>

<optgroup label="Setrika" data-kategori="laundry">
<option value="Setrika Reguler">Setrika Reguler</option>
<option value="Setrika Express">Setrika Express</option>
</optgroup>

<optgroup label="Lainnya" data-kategori="laundry">
<option value="Sprei Selimut Reguler">Sprei Selimut Reguler</option>
<option value="Sprei Selimut Express">Sprei Selimut Express</option>
<option value="Bedcover Reguler">Bedcover Reguler</option>
<option value="Bedcover Express">Bedcover Express</option>
<option value="Ransel/Sepatu/Helm">Ransel/Sepatu/Helm</option>
<option value="Boneka/Bantal/Korden">Boneka/Bantal/Korden</option>
<option value="Karpet">Karpet</option>
<option value="Spotting Noda">Spotting Noda</option>
<option value="Packing Hanger">Packing Hanger</option>
</optgroup>

<optgroup label="Jasa" data-kategori="jasa">
<option value="Antar">Antar</option>
<option value="Jemput">Jemput</option>
<option value="Antar Jemput">Antar Jemput</option>
</optgroup>

</select>

<input type="hidden" name="nama_layanan" id="nama_layanan_input">

</div>

{{-- KODE LAYANAN --}}
<div class="col-md-6 mb-3">
<label>Kode Layanan</label>
<select name="kode_layanan" id="kode_layanan" class="form-control" required>
<option value="">Pilih Kode Layanan</option>
</select>
</div>

{{-- SATUAN --}}
<div class="col-md-6 mb-3">
<label>Satuan</label>
<select name="satuan" id="satuan" class="form-control" required>
<option value="">Pilih Satuan</option>
<option value="kg" {{ $harga->satuan=='kg'?'selected':'' }}>Per Kg</option>
<option value="pcs" {{ $harga->satuan=='pcs'?'selected':'' }}>Per Pcs</option>
<option value="km" {{ $harga->satuan=='km'?'selected':'' }}>Per KM</option>
</select>
</div>

{{-- HARGA --}}
<div class="col-md-6 mb-3">
<label>Harga</label>
<input type="number" name="harga" class="form-control"
value="{{ $harga->harga }}" required>
</div>

{{-- JARAK --}}
<div class="col-md-6 mb-3">
<label>Jarak (KM)</label>
<input type="number"
name="jarak"
id="jarak"
class="form-control"
value="{{ $harga->jarak }}"
{{ $harga->kategori!='jasa'?'disabled':'' }}>
</div>

{{-- OPSIONAL --}}
<div class="col-md-6 mb-3">
<label>Layanan Opsional</label>
<div class="form-check">
<input type="checkbox"
class="form-check-input"
name="is_optional"
id="is_optional"
value="1"
{{ $harga->is_optional?'checked':'' }}
{{ $harga->kategori!='jasa'?'disabled':'' }}>
<label class="form-check-label">Opsional</label>
</div>
</div>

{{-- AKTIF --}}
<div class="col-md-6 mb-3">
<label>Status</label>
<div class="form-check">
<input type="checkbox"
class="form-check-input"
name="is_active"
value="1"
{{ $harga->is_active?'checked':'' }}>
<label class="form-check-label">Aktif</label>
</div>
</div>

{{-- KETERANGAN --}}
<div class="col-md-12 mb-3">
<label>Keterangan</label>
<textarea name="keterangan" class="form-control" rows="3">{{ $harga->keterangan }}</textarea>
</div>

</div>

<div class="text-right">
<a href="{{ route('manajemen.harga.index') }}" class="btn btn-light">Kembali</a>
<button type="submit" class="btn btn-warning">Update</button>
</div>

</form>

</div>
</div>

</div>
</div>

@endsection