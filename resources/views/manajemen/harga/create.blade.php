@extends('layouts.admin')

@section('title','Tambah Harga')

@section('content')

<div class="row">
<div class="col-md-12 grid-margin">

<div class="card">
<div class="card-body">

<h4 class="card-title">Tambah Harga</h4>

<form action="{{ route('manajemen.harga.store') }}" method="POST">
@csrf

<div class="row">

{{-- KATEGORI --}}
<div class="col-md-6">
<div class="form-group">
<label>Kategori</label>
<select name="kategori" id="kategori" class="form-control" required>
<option value="">Pilih Kategori</option>
<option value="laundry">Laundry</option>
<option value="jasa">Jasa</option>
</select>
</div>
</div>

{{-- JENIS LAYANAN --}}
<div class="col-md-6">
<div class="form-group">
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
</div>


{{-- KODE LAYANAN --}}
<div class="col-md-6">
<div class="form-group">
<label>Kode Layanan</label>
<select name="kode_layanan" id="kode_layanan" class="form-control" required>
<option value="">Pilih Kode Layanan</option>
</select>
</div>
</div>


{{-- SATUAN --}}
<div class="col-md-6">
<div class="form-group">
<label>Satuan</label>
<select name="satuan" id="satuan" class="form-control" required>
<option value="">Pilih Satuan</option>
<option value="kg">Per Kg</option>
<option value="pcs">Per Pcs</option>
<option value="km">Per KM</option>
</select>
</div>
</div>


{{-- HARGA --}}
<div class="col-md-6">
<div class="form-group">
<label>Harga</label>
<input type="number" name="harga" class="form-control" placeholder="contoh: 7000" required>
</div>
</div>


{{-- JARAK --}}
<div class="col-md-6">
<div class="form-group">
<label>Jarak (KM)</label>
<input type="number" name="jarak" id="jarak" class="form-control" placeholder="contoh: 5" disabled>
</div>
</div>

{{-- OPSIONAL --}}
<div class="col-md-3">
<div class="form-group">
<label>Layanan Opsional (Jasa)</label><br>

<label class="switch">
<input type="checkbox" name="is_optional" id="is_optional" value="1" disabled>
<span class="slider"></span>
</label>

</div>
</div>

{{-- AKTIF --}}
<div class="col-md-3">
<div class="form-group">
<label>Aktif</label><br>

<label class="switch">
<input type="checkbox" name="is_active" value="1" checked>
<span class="slider"></span>
</label>

</div>
</div>

{{-- KETERANGAN --}}
<div class="col-md-12">
<div class="form-group">
<label>Keterangan</label>
<textarea name="keterangan" class="form-control" rows="3" placeholder="Opsional..."></textarea>
</div>
</div>

</div>


<div class="d-flex justify-content-end">

<a href="{{ route('manajemen.harga.index') }}" class="btn btn-light mr-2">
Kembali
</a>

<button type="submit" class="btn btn-warning">
Simpan
</button>

</div>

</form>

</div>
</div>

</div>
</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

const kategori = document.getElementById('kategori');
const satuan = document.getElementById('satuan');
const jarak = document.getElementById('jarak');
const isOptional = document.getElementById('is_optional');

const layananSelect = document.getElementById('layanan-select');
const kodeSelect    = document.getElementById('kode_layanan');
const hiddenNama    = document.getElementById('nama_layanan_input');


/* =========================
   LOGIKA KATEGORI
========================= */
kategori.addEventListener('change', function () {
if (this.value === 'jasa') {

    satuan.value = 'km';

    satuan.querySelectorAll('option').forEach(opt => {
        opt.disabled = opt.value !== 'km' && opt.value !== '';
    });

    jarak.disabled = false;
    isOptional.disabled = false;

} else {

    satuan.value = '';

    satuan.querySelectorAll('option').forEach(opt => {
        opt.disabled = opt.value === 'km';
    });

    jarak.value = '';
    jarak.disabled = true;

    isOptional.checked = false;
    isOptional.disabled = true;

}

filterLayanan();

});

/* =========================
   FILTER JENIS LAYANAN
========================= */
function filterLayanan(){
const kategoriVal = kategori.value;
layananSelect.querySelectorAll('optgroup').forEach(group => {

if(!kategoriVal){
group.style.display = 'none';
}

else if(group.dataset.kategori === kategoriVal){
group.style.display = 'block';
}

else{
group.style.display = 'none';
}

});

layananSelect.value = '';

}

filterLayanan();


/* =========================
   GENERATE KODE LAYANAN
========================= */
function generateKode(nama){
return nama
.toLowerCase()
.replace(/[^a-z0-9\s]/g,'')
.replace(/\s+/g,'_');

}

function updateKode(namaLayanan){

kodeSelect.innerHTML = '<option value="">Pilih Kode Layanan</option>';

if(!namaLayanan){
hiddenNama.value = '';
return;
}

hiddenNama.value = namaLayanan;
const kode = generateKode(namaLayanan);
const opt = document.createElement('option');
opt.value = kode;
opt.text  = kode;
opt.selected = true;
kodeSelect.appendChild(opt);
}


/* =========================
   EVENT JENIS LAYANAN
========================= */
layananSelect.addEventListener('change',function(){
updateKode(this.value);
});
});

</script>

@endpush

<style>

/* SWITCH BADGE */

.switch {
position: relative;
display: inline-block;
width: 55px;
height: 30px;
}

.switch input {
opacity: 0;
width: 0;
height: 0;
}

.slider {
position: absolute;
cursor: pointer;
top: 0;
left: 0;
right: 0;
bottom: 0;
background-color: #ccc;
transition: .4s;
border-radius: 34px;
}

.slider:before {
position: absolute;
content: "";
height: 22px;
width: 22px;
left: 4px;
bottom: 4px;
background-color: white;
transition: .4s;
border-radius: 50%;
}

.switch input:checked + .slider {
background-color: #22c55e;
}

.switch input:checked + .slider:before {
transform: translateX(24px);
}

.switch input:disabled + .slider {
background-color: #e5e7eb;
cursor: not-allowed;
}

</style>
