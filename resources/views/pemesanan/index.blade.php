@extends(
    auth()->user()->role === 'admin'
        ? 'layouts.admin'
        : 'layouts.dashboard_kasir'
)

@section('title','Data Pemesanan')

@section('content')

<div class="page-header">
    <h3 class="page-title">Data Order</h3>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <a href="{{ route('pemesanan.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Tambah
        </a>
    </div>
</div>

{{-- FILTER TABS --}}
<div class="order-tabs mb-4">

    <a href="{{ route('pemesanan.index') }}"
       class="tab {{ !request('status') ? 'active' : '' }}">
        Semua Pesanan
    </a>

    <a href="{{ route('pemesanan.index',['status'=>'proses']) }}"
       class="tab {{ request('status')=='proses' ? 'active' : '' }}">
        Dalam Proses
    </a>

    <a href="{{ route('pemesanan.index',['status'=>'selesai']) }}"
       class="tab {{ request('status')=='selesai' ? 'active' : '' }}">
        Selesai
    </a>

</div>


<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">

        <div class="card">
        <div class="card-body">

        {{-- <h4 class="card-title">Daftar Order Masuk</h4> --}}

        <div class="table-responsive">

    <table class="table table-striped" id="tabelPemesanan">
        <thead>
            <tr>
            <th>No</th>
            <th>ID Order</th>
            <th>Nama</th>
            <th>No Telp</th>
            <th>Titik Lokasi</th>
            <th>Total Harga</th>
            </tr>
        </thead>

    <tbody>
        @forelse($pemesanans as $index => $p)

        <tr>

            <td>{{ $index + 1 }}</td>
            <td><strong>{{ $p->no_order }}</strong></td>
            <td>{{ $p->customer->nama_lengkap ?? '-' }}</td>
            <td>{{ $p->customer->no_telp ?? '-' }}</td>

            <td>
                @if($p->latitude && $p->longitude)

                <a href="https://www.openstreetmap.org/?mlat={{ $p->latitude }}&mlon={{ $p->longitude }}"
                    target="_blank"
                    class="text-primary font-weight-bold">
                    Lihat Lokasi
                </a>

                @else
                -
                @endif
            </td>
            <td>
            Rp {{ number_format($p->total_harga,0,',','.') }}
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


@push('styles')
<style>

    .order-tabs{
    display:flex;
    gap:25px;
    border-bottom:2px solid #e2e8f0;
    padding-bottom:8px;
    }

    .order-tabs .tab{
    text-decoration:none;
    font-weight:600;
    font-size:14px;
    color:#6c757d;
    padding-bottom:6px;
    position:relative;
    }

    .order-tabs .tab.active{
    color:#4B49AC;
    }

    .order-tabs .tab.active::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-10px;
    width:100%;
    height:3px;
    background:#4B49AC;
    border-radius:3px;
    }

    .order-tabs .tab:hover{
    color:#4B49AC;
    }

    </style>
    @endpush


    @push('scripts')
    <script>

    $(document).ready(function(){

    $('#tabelPemesanan').DataTable();

    });

</script>
@endpush