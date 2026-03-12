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
        <form method="GET" action="{{ route($role . '.lacak.index') }}">
            <div class="filter-row">
                <select name="outlet_id">
                    <option value="">Semua Outlet</option>
                    @foreach($outlets as $outlet)
                        <option value="{{ $outlet->id }}"
                            {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>
                            {{ $outlet->nama_outlet }}
                        </option>
                    @endforeach
                </select>
                <select name="tipe_pemesanan">
                    <option value="">Tipe Pemesanan</option>
                    <option value="pemesanan" {{ request('tipe_pemesanan') == 'pemesanan' ? 'selected' : '' }}>
                        Pemesanan
                    </option>
                    <option value="reservasi" {{ request('tipe_pemesanan') == 'reservasi' ? 'selected' : '' }}>
                        Reservasi
                    </option>
                </select>
                <select name="status">
                    <option value="">Proses</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>
                        Diterima
                    </option>
                    <option value="dicuci" {{ request('status') == 'dicuci' ? 'selected' : '' }}>
                        Dicuci
                    </option>
                    <option value="dikeringkan" {{ request('status') == 'dikeringkan' ? 'selected' : '' }}>
                        Dikeringkan
                    </option>
                    <option value="disetrika" {{ request('status') == 'disetrika' ? 'selected' : '' }}>
                        Disetrika
                    </option>
                </select>

                <div class="date-field floating">
                    <input type="date" name="from" placeholder=" ">
                    <label>Tanggal Mulai</label>
                </div>

                <div class="date-field floating">
                    <input type="date" name="to" placeholder=" ">
                    <label>Tanggal Selesai</label>
                </div>

                <div class="filter-action">
                    <button class="btn-apply">Terapkan</button>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- ================= TABLE ================= --}}
<div class="card">
    <div class="card-body">

        <div class="table-responsive">

            <table id="table-lacak" class="table table-striped">

                    <thead class="bg-dark text-white">
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
                            <td colspan="6" class="text-center">
                            Tidak ada data
                            </td>
                        </tr>

                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

<style>
    /* ===== FILTER LAYOUT ===== */
.filter-row{
display:flex;
align-items:center;
gap:10px;
flex-wrap:nowrap;
overflow-x:auto;
}

/* ===== SEMUA INPUT FILTER ===== */
.filter-row select,
.filter-row input{
height:40px;
padding:6px 10px;
border:1px solid #d1d5db;
border-radius:6px;
background:#fff;
font-size:14px;
}

.filter-row select{
text-overflow:ellipsis;
white-space:nowrap;
overflow:hidden;
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

/* ===== DATE FIELD ===== */
.date-field{
position:relative;
min-width:150px;
}

.date-field{
overflow:visible;
}

.date-field input{
padding-top:14px;
}

.date-field label{
position:absolute;
top:-8px;
left:8px;
background:#fff;
padding:0 4px;
font-size:11px;
white-space:nowrap;
color:#64748b;
}

/* ===== BUTTON ===== */
.filter-action{
display:flex;
align-items:center;
}

.btn-apply{
height:40px;
padding:0 16px;
border:none;
border-radius:6px;
background:#4f46e5;
color:white;
font-weight:500;
cursor:pointer;
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