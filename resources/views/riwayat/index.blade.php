@php
$role = auth()->user()->role;
@endphp

@extends(
    auth()->user()->role === 'admin'
        ? 'layouts.admin'
        : 'layouts.admin'
)

@section('title','Riwayat Pemesanan')

@section('content')

<h3 class="page-title mb-4">Riwayat Order</h3>

<div class="card">
<div class="card-body">

{{-- ================= FILTER ================= --}}
<form method="GET" action="{{ route($role.'.riwayat.index') }}">

<div class="row mb-4">

<div class="col-md-4">
<select name="layanan" class="form-control">

<option value="">Jenis Layanan</option>

@foreach($layanans as $l)
<option value="{{ $l->kode_layanan }}"
    {{ request('layanan') == $l->kode_layanan ? 'selected' : '' }}>
    {{ $l->nama_layanan }}
</option>
@endforeach

</select>
</div>

<div class="col-md-4 d-flex gap-2">

    <div class="date-field">
        <label>Tanggal Mulai</label>
        <input 
            type="date" 
            name="from" 
            value="{{ request('from') }}" 
            required>
    </div>

    <div class="date-field">
        <label>Tanggal Selesai</label>
        <input 
            type="date" 
            name="to" 
            value="{{ request('to') }}" 
            required>
    </div>

</div>

<div class="col-md-4">
<button class="btn btn-primary btn-block">
<i class="mdi mdi-filter"></i> Terapkan
</button>
</div>

</div>

</form>


{{-- ================= TABLE ================= --}}
<div class="row">
<div class="col-lg-12 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<div class="table-responsive">

<table class="table table-striped" id="table-riwayat">

<thead>
<tr>
<th>No Order</th>
<th>Nama</th>
<th>Total</th>
<th>Pembayaran</th>
<th>Status</th>
<th class="text-center">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($pemesanans as $p)

@php
$history = $p->historyPemesanan->last();
$pembayaran = optional($history)->pembayaran ?? 'belum_bayar';
@endphp

<tr>

<td>{{ $p->no_order }}</td>

<td>{{ $p->customer->nama_lengkap ?? '-' }}</td>

<td>
Rp {{ number_format($p->total_harga ?? 0,0,',','.') }}
</td>

<td>

@if($pembayaran === 'lunas')

<span class="badge badge-success">
Lunas
</span>

@else

<span class="badge badge-warning">
Belum Bayar
</span>

@endif

</td>

<td>

<span class="badge badge-info">
{{ ucfirst($p->status_proses) }}
</span>

</td>

<td class="text-center">
    <div class="action-wrapper">

        @if(in_array(auth()->user()->role, ['admin','kasir']))
        <a
            href="{{ route(auth()->user()->role.'.riwayat.download',$p->id_pemesanan) }}"
            class="btn btn-sm btn-outline-primary action-btn"
            title="Unduh">
            <i class="mdi mdi-download"></i>
        </a>
        @endif

        @if(auth()->user()->role === 'admin')
        <form
            method="POST"
            action="{{ route('admin.riwayat.destroy',$p->id_pemesanan) }}"
            onsubmit="return confirm('Hapus riwayat ini?')"
            class="d-inline">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn btn-sm btn-outline-danger action-btn"
                title="Hapus">
                <i class="mdi mdi-delete"></i>
            </button>

        </form>
        @endif

    </div>
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
<div id="custom-total-box" class="total-box mt-3">
    Total: Rp {{ number_format($totalKeseluruhan,0,',','.') }}
</div>

</div>
</div>
</div>

</div>
</div>

@endsection

<style>
    .d-flex{
        display: flex;
    }

    .gap-2{
        gap: 10px;
    }

    .date-field{
        position: relative;
        flex: 1; /* biar 2 field bagi rata */
        min-width: 140px;
    }

    .date-field input{
    width: 100%;
    height: 42px;
    padding: 14px 10px 6px 10px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 13px;
    background: #fff;
    box-sizing: border-box;
    }

    .date-field label{
    position: absolute;
    top: -6px;
    left: 10px;
    background: #fff;
    padding: 0 5px;
    font-size: 10px;
    color: #64748b;
    line-height: 1;
    pointer-events: none;
}

.date-field input:focus{
    border-color: #6366f1;
    outline: none;
} 

/* total */
.total-box{
    background: #14b8a6;
    color: white;
    padding: 14px 20px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    width: 100%;
}

/* export excel */
.dataTables_length,
.dt-buttons {
    display: inline-block;
    margin-right: 10px;
    vertical-align: middle;
}

.dt-buttons .btn {
    margin-left: 10px;
}

.dt-button.btn-success {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    color: #fff !important;
}

.dt-button.btn-success:hover {
    background-color: #218838 !important;
    border-color: #1e7e34 !important;
}

</style>

@push('scripts')

<script>

$(document).ready(function(){

    if ($.fn.DataTable.isDataTable('#table-riwayat')) {
        $('#table-riwayat').DataTable().destroy();
    }

    $('#table-riwayat').DataTable({
        dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center gap-2"lB><"ml-auto"f>>rt<"bottom"ip><"clear">',

        infoCallback: function(settings, start, end, max, total, pre) {
    return "Showing " + start + " to " + end + " of " + total + " entries";
},

        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                className: 'btn btn-success btn-sm'
            }
        ]
    });

});

</script>

@endpush