@extends(
    auth()->user()->role === 'admin'
        ? 'layouts.admin'
        : 'layouts.admin'
)

@section('title','Lacak Pemesanan')

@section('content')

<h3 class="page-title mb-4">Proses Order</h3>

{{-- ================= DASHBOARD STATUS ================= --}}
<div class="row mb-4">

    <div class="col">
        <div class="card text-center">
            <div class="card-body">
                <i class="mdi mdi-timer-sand mdi-36px text-warning"></i>
                <p class="mt-2 mb-0">Diterima</p>
                <h4>{{ $trackingCount['diterima'] }}</h4>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card text-center">
            <div class="card-body">
                <i class="mdi mdi-washing-machine mdi-36px text-danger"></i>
                <p class="mt-2 mb-0">Dicuci</p>
                <h4>{{ $trackingCount['dicuci'] }}</h4>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card text-center">
            <div class="card-body">
                <i class="mdi mdi-weather-windy mdi-36px text-info"></i>
                <p class="mt-2 mb-0">Dikeringkan</p>
                <h4>{{ $trackingCount['dikeringkan'] }}</h4>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card text-center">
            <div class="card-body">
                <i class="mdi mdi-tshirt-crew mdi-36px text-success"></i>
                <p class="mt-2 mb-0">Disetrika</p>
                <h4>{{ $trackingCount['disetrika'] }}</h4>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card text-center">
            <div class="card-body">
                <i class="mdi mdi-package-variant mdi-36px text-primary"></i>
                <p class="mt-2 mb-0">Selesai</p>
                <h4>{{ $trackingCount['selesai'] }}</h4>
            </div>
        </div>
    </div>

</div>


{{-- ================= FILTER ================= --}}
<div class="card mb-4">
    <div class="card-body">

    @php
    $role = auth()->user()->role;
    @endphp

        <form method="GET" action="{{ route($role.'.lacak.index') }}">

            <div class="filter-row">

            <select name="outlet_id" required>
            <option value="" disabled selected>Outlet</option>
            @foreach($outlets as $outlet)
            <option value="{{ $outlet->id }}"
            {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>
            {{ $outlet->nama_outlet }}
            </option>
            @endforeach
            </select>

            <select name="tipe_pemesanan" required>
            <option value="" disabled {{ request('tipe_pemesanan') ? '' : 'selected' }}>Tipe Pemesanan</option>
            <option value="pemesanan" {{ request('tipe_pemesanan') == 'pemesanan' ? 'selected' : '' }}>Pemesanan</option>
            <option value="reservasi" {{ request('tipe_pemesanan') == 'reservasi' ? 'selected' : '' }}>Reservasi</option>
            </select>

            <select name="status" required>
            <option value="" disabled {{ request('status') ? '' : 'selected' }}>Proses</option>
            <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
            <option value="dicuci" {{ request('status') == 'dicuci' ? 'selected' : '' }}>Dicuci</option>
            <option value="dikeringkan" {{ request('status') == 'dikeringkan' ? 'selected' : '' }}>Dikeringkan</option>
            <option value="disetrika" {{ request('status') == 'disetrika' ? 'selected' : '' }}>Disetrika</option>
            </select>

            <div class="date-field">
            <label>Tanggal Mulai</label>
            <input type="date" name="from" value="{{ request('from') }}" required>
            </div>

            <div class="date-field">
            <label>Tanggal Selesai</label>
            <input type="date" name="to" value="{{ request('to') }}" required>
            </div>

            <button class="btn-apply">Terapkan</button>

            </div>  

        </form>
    </div>
</div>


{{-- ================= TABLE ================= --}}
<div class="row">
<div class="col-lg-12 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<div class="table-responsive">

<table class="table table-striped" id="table-lacak">

<thead>
<tr>
<th>No Order</th>
<th>Nama</th>
<th>Payment</th>
<th>Tipe</th>
<th class="layanan-col">Jenis Layanan</th>
<th class="text-center aksi-col">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($pemesanans as $p)

<tr>

<td>{{ $p->no_order }}</td>
<td>{{ $p->customer->nama_lengkap ?? '-' }}</td>

@php
$history = $p->historyPemesanan?->last();
$pembayaran = $history->pembayaran ?? 'belum_bayar';
@endphp

<td>{{ $p->source === 'pemesanan' ? $pembayaran : 'belum_bayar' }}</td>

<td>{{ $p->tipe }}</td>

<td class="layanan-col">
@foreach(explode(',', $p->jenis_layanan ?? '') as $layanan)
@if(trim($layanan) != '')
<div class="layanan-item">{{ trim($layanan) }}</div>
@endif
@endforeach
</td>

<td class="text-left aksi-col">

@php
$role = auth()->user()->role;

$id = $p->source === 'pemesanan'
? $p->id_pemesanan
: $p->id_reservasi;
@endphp

<form method="POST" action="{{ route($role.'.lacak.next',$id) }}">
@csrf
<input type="hidden" name="source" value="{{ $p->source ?? '' }}">

<button
type="submit"
class="btn {{ $p->status_proses === 'disetrika' ? 'btn-success' : 'btn-warning' }} btn-sm">

{{ $p->status_proses === 'disetrika' ? 'Selesai' : 'Next' }}

</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center py-4">
Tidak ada data
</td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>
</div>

</div>
</div>

@endsection

<style>
    /* ===== FILTER LAYOUT ===== */
.filter-row{
display:flex;
align-items:flex-end;
gap:14px;
flex-wrap:wrap;
overflow-x:auto;
}

/* ===== SEMUA INPUT FILTER ===== */
.filter-row select,
.filter-row input{
height:36px;
padding:0px 10px;
border:1px solid #d1d5db;
border-radius:6px;
background:#fff;
font-size:13px;
box-sizing:border-box;
flex:1;
min-width:140px;
}

.filter-row select{
text-overflow:ellipsis;
white-space:nowrap;
overflow:hidden;
color:#9ca3af;
}

.filter-row select:valid{
color:#111827;
}

/* placeholder input biasa */
.filter-row input::placeholder{
color:#9ca3af;
}

/* saat user mengetik */
.filter-row input:focus::placeholder{
color:#cbd5f5;
}

/* ukuran masing-masing filter */
/* OUTLET */
.filter-row select[name="outlet_id"]{
width:160px;
}

/* TIPE */
.filter-row select[name="tipe_pemesanan"]{
width:140px;
}

/* PROSES */
.filter-row select[name="status"]{
width:120px;
}

/* DATE */
.filter-row input[type="date"]{
width:150px;
}

/* BUTTON */
.btn-apply{
height:40px;
padding:0 18px;
white-space:nowrap;
}

/* ===== BUTTON ===== */
.filter-action{
display:flex;
align-items:center;
}

/* DATE FIELD */
.date-field{
position:relative;
flex:1;
width:160px;
padding-top:6px; /* ruang untuk label */
}

.date-field input{
width:100%;
height:36px;
padding:10px 8px 4px 8px;
border:1px solid #d1d5db;
border-radius:6px;
font-size:13px;
background:#fff;
box-sizing:border-box;
}

.date-field label{
position:absolute;
top:0;
left:10px;
background:#fff;
padding:0 4px;
font-size:10px;
color:#64748b;
line-height:1;
pointer-events:none;
}

.filter-row{
display:flex;
align-items:flex-end;
gap:10px;
flex-wrap:nowrap;
}

.btn-apply{
height:px36;
padding:0 18px;
border:none;
border-radius:6px;
background:#4f46e5;
color:white;
font-weight:500;
cursor:pointer;
flex:0;
}

.btn-apply:hover{
background:#4338ca;
}

</style>

@push('scripts')
<script>

$(document).ready(function(){

if ($.fn.DataTable.isDataTable('#table-lacak')) {
$('#table-lacak').DataTable().destroy();
}

$('#table-lacak').DataTable({
autoWidth:false,
columnDefs:[
{ width:"220px", targets:0 },
{ width:"120px", targets:1 },
{ width:"120px", targets:2 },
{ width:"120px", targets:3 },
{ width:"260px", targets:4 },
{ width:"90px", targets:5 }
]
});

});

</script>
@endpush