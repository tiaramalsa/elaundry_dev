@extends('layouts.dashboard')

@section('title', 'Input Promo')

@section('content')
<div class="page-title">Input Promo</div>

<div class="card" style="max-width: 100%;">
    <h4>Input Promo</h4>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form method="POST" action="{{ route('manajemen.storepromo') }}">
        @csrf

        {{-- NAMA & SKEMA --}}
        <div class="row">
            <input type="text" name="nama_promo" placeholder="Nama Promo" required>
            <input type="text" name="skema" placeholder="Skema Promo" required>
        </div>

        {{-- BASIS & NILAI --}}
        <div class="row">
            <select name="basis_promo" required>
                <option value="">Basis Promo</option>
                <option value="nominal">Promo Nominal (Rp)</option>
                <option value="persentase">Promo Persentase (%)</option>
            </select>

            <input type="number" name="nilai_promo"
                placeholder="Nilai Promo (Rp / %)"
                min="0"
                required>
        </div>

        {{-- STATUS & TANGGAL --}}
        <div class="row">
            <select name="status" class="col-equal" required>
                <option value="">Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Non Aktif</option>
            </select>

            <div class="date-group col-equal">
                <input type="date" name="tanggal_mulai" required placeholder=" ">
                <label>Tanggal Mulai</label>
            </div>

            <div class="date-group col-equal">
                <input type="date" name="tanggal_selesai" required placeholder=" ">
                <label>Tanggal Selesai</label>
            </div>
        </div>

        {{-- MIN TRANSAKSI | MAX PROMO | KUOTA --}}
        <div class="row">
            <input type="number" name="minimal_transaksi"
                class="col-equal"
                placeholder="Rp Min. Transaksi"
                min="0">

            <input type="number" name="maksimal_diskon"
                class="col-equal"
                placeholder="Rp Max. Promo"
                min="0">

            <input type="number" name="kuota"
                class="col-equal"
                placeholder="Kuota Promo"
                min="1">
        </div>

        {{-- ROLE | TARGET | KHUSUS MEMBER --}}
        <div class="row">
            <select name="role_akses" class="col-equal" required>
                <option value="">Role Akses</option>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
                <option value="semua">Semua</option>
            </select>

            <select name="target_diskon" class="col-equal" required>
                <option value="">Target Promo</option>
                <option value="produk">Harga Produk</option>
                <option value="ongkir">Ongkir</option>
                <option value="pelayanan">Biaya Pelayanan</option>
            </select>

            <select name="khusus_member" class="col-equal" required>
                <option value="">Khusus Member?</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        {{-- DESKRIPSI --}}
        <div class="row">
            <textarea name="deskripsi_promo"
                    placeholder="Deskripsi Promo"
                    required></textarea>
        </div>

        <div class="btn-row">
            <a href="{{ route('manajemen.indexpromo') }}"
            class="btn btn-secondary btn-sm">Batal</a>

            <button class="btn">Tambah Promo</button>
        </div>
</form>

</div>

<style>

/* ===== CEGAH GESER KANAN KIRI ===== */
html, body {
    overflow-x: hidden;
}

/* ===== ROW FORM ===== */
.row {
    display: flex;
    flex-wrap: wrap;      /* 🔥 ini kunci */
    gap: 12px;
    margin-bottom: 12px;
}

/* ===== SAMAKAN TINGGI SEMUA FIELD (WAJIB) ===== */
.row input,
.row select {
    height: 45px;
    padding: 12px;
    font-size: 14px;
    box-sizing: border-box;
}

/* ===== 3 KOLOM SEIMBANG (STATUS & TANGGAL) ===== */
.col-equal {
    flex: 1 1 calc(33.333% - 12px);
    min-width: 220px;
}

/* input default desktop */
.row input:not(.col-equal),
.row select:not(.col-equal),
.row textarea {
    flex: 1;
    min-width: 220px;
    max-width: 100%;
}

/* textarea full width */
.row textarea {
    width: 100%;
    min-height: 90px;
}

/* tombol */
.btn-row {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {

    /* semua field turun ke bawah */
    .row input,
    .row select,
    .row textarea {
        flex: 1 1 100%;
        min-width: 0;
    }

    /* tombol full */
    .btn-row {
        flex-direction: column;
    }

    /* 👇 TAMBAH DI SINI */
    .col-equal {
        flex: 1 1 100%;
    }

    .btn-row .btn,
    .btn-row a {
        width: 100%;
        text-align: center;
    }
}

.date-group {
    position: relative;
}

.date-group input {
    height: 45px;
    padding: 12px;
    font-size: 14px;
    box-sizing: border-box;
}

.date-group label {
    position: absolute;
    left: 12px;
    top: 12px;
    font-size: 14px;
    color: #888;
    pointer-events: none;
    transition: 0.2s ease;
    background: white;
}

/* sembunyikan format bawaan
input[type="date"]::-webkit-datetime-edit {
    color: transparent;
} */

/* tampilkan tanggal kalau sudah isi / focus */
input[type="date"]:focus::-webkit-datetime-edit,
input[type="date"]:valid::-webkit-datetime-edit {
    color: black;
}

/* label naik */
.date-group input:focus + label,
.date-group input:not(:placeholder-shown) + label {
    top: -8px;
    left: 8px;
    font-size: 11px;
    padding: 0 4px;
    color: #00b894;
}

.date-group input[type="date"] {
    width: 100%;
    height: 45px;        /* samakan dengan input lain */
    box-sizing: border-box;
    padding: 12px;
    font-size: 14px;
}

</style>
@endsection
