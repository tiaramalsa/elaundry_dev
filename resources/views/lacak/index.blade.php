@extends(
    auth()->user()->role === 'admin'
        ? 'layouts.admin'
        : 'layouts.dashboard_kasir'
)

@section('title','Lacak Pemesanan')

@section('content')

<h3 class="page-title mb-4">Update Status Pemesanan Laundry</h3>

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

            <div class="row">

                <div class="col-md-2">
                    <select name="outlet_id" class="form-control">
                        <option value="">Semua Outlet</option>

                        @foreach($outlets as $outlet)
                            <option value="{{ $outlet->id }}"
                            {{ request('outlet_id') == $outlet->id ? 'selected' : '' }}>
                            {{ $outlet->nama_outlet }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-2">
                    <select name="tipe_pemesanan" class="form-control">

                        <option value="">Tipe Pemesanan</option>

                        <option value="pemesanan"
                        {{ request('tipe_pemesanan')=='pemesanan'?'selected':'' }}>
                        Pemesanan
                        </option>

                        <option value="reservasi"
                        {{ request('tipe_pemesanan')=='reservasi'?'selected':'' }}>
                        Reservasi
                        </option>

                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-control">

                        <option value="">Proses</option>

                        <option value="diterima" {{ request('status')=='diterima'?'selected':'' }}>
                        Diterima
                        </option>

                        <option value="dicuci" {{ request('status')=='dicuci'?'selected':'' }}>
                        Dicuci
                        </option>

                        <option value="dikeringkan" {{ request('status')=='dikeringkan'?'selected':'' }}>
                        Dikeringkan
                        </option>

                        <option value="disetrika" {{ request('status')=='disetrika'?'selected':'' }}>
                        Disetrika
                        </option>

                    </select>
                </div>

                <div class="col-md-2">
                    <input type="date" name="from" class="form-control">
                </div>

                <div class="col-md-2">
                    <input type="date" name="to" class="form-control">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary btn-block">
                    <i class="mdi mdi-filter"></i> Terapkan
                    </button>
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
                        <td>
                            @if($p->source === 'pemesanan')
                            {{ optional(optional($p->historyPemesanan)->last())->pembayaran ?? 'belum_bayar' }}
                            @else
                            belum_bayar
                            @endif
                        </td>
                        <td>{{ $p->tipe }}</td>
                        <td class="layanan-col">
                            @foreach(explode(',', $p->jenis_layanan) as $layanan)
                            <div class="layanan-item">{{ trim($layanan) }}</div>
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
    #table-lacak{
        width:100% !important;
    }
    .aksi-col{
        width:100px;
        text-align:left;
    }

    .layanan-col{
        max-width:260px;
        white-space:normal !important;
        word-break:break-word;
        line-height:1.7;
    }

    .layanan-item{
        margin-bottom:6px;   
        line-height:1.4;
    }

    .aksi-col{
        width:90px;
    }
</style>

@push('scripts')
<script>

$(document).ready(function(){

    $('#table-lacak').DataTable({
        autoWidth:false,
        columnDefs:[
            { width:"220px", targets:0 }, // No Order
            { width:"120px", targets:1 }, // Nama
            { width:"120px", targets:2 }, // Payment
            { width:"120px", targets:3 }, // Tipe
            { width:"260px", targets:4 }, // Jenis layanan
            { width:"90px",  targets:5 }  // Aksi
        ]
    });
});

</script>
@endpush