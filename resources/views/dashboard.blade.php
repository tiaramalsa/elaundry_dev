@extends('layouts.admin')

@section('title','Dashboard')

@section('content')

<div class="page-header flex-wrap">
    <h3 class="mb-0">Dashboard Admin</h3>
</div>

<div class="row">

    {{-- CUSTOMER --}}
    <div class="col-xl-4 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-primary text-white mr-3 p-3 rounded">
                    <i class="mdi mdi-account-multiple mdi-24px"></i>
                </div>
                <div>
                    <p class="text-muted mb-1">Jumlah Customer</p>
                    <h4 class="mb-0">{{ $jumlahCustomer }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- KARYAWAN --}}
    <div class="col-xl-4 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-info text-white mr-3 p-3 rounded">
                    <i class="mdi mdi-account-tie mdi-24px"></i>
                </div>
                <div>
                    <p class="text-muted mb-1">Jumlah Karyawan</p>
                    <h4 class="mb-0">{{ $jumlahKaryawan }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- PEMESANAN --}}
    <div class="col-xl-4 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-warning text-white mr-3 p-3 rounded">
                    <i class="mdi mdi-package-variant mdi-24px"></i>
                </div>
                <div>
                    <p class="text-muted mb-1">Total Pemesanan</p>
                    <h4 class="mb-0">{{ $totalPemesanan }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- PEMASUKAN --}}
    <div class="col-xl-4 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-success text-white mr-3 p-3 rounded">
                    <i class="mdi mdi-cash mdi-24px"></i>
                </div>
                <div>
                    <p class="text-muted mb-1">Pemasukan Bulan Ini</p>
                    <h4 class="mb-0">Rp {{ number_format($totalPemasukan,0,',','.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- PENGELUARAN --}}
    <div class="col-xl-4 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-danger text-white mr-3 p-3 rounded">
                    <i class="mdi mdi-currency-usd mdi-24px"></i>
                </div>
                <div>
                    <p class="text-muted mb-1">Pengeluaran Bulan Ini</p>
                    <h4 class="mb-0">Rp {{ number_format($totalPengeluaran,0,',','.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- LABA --}}
    <div class="col-xl-4 col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <div class="icon bg-dark text-white mr-3 p-3 rounded">
                    <i class="mdi mdi-chart-line mdi-24px"></i>
                </div>
                <div>
                    <p class="text-muted mb-1">Laba Bersih</p>
                    <h4 class="mb-0">Rp {{ number_format($labaBersih,0,',','.') }}</h4>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- CHART --}}
<div class="row">

    <div class="col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Grafik Pemasukan & Pengeluaran</h4>
                <canvas id="chartKeuangan"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Grafik Customer Laundry per Bulan</h4>
                <canvas id="chartCustomer"></canvas>
            </div>
        </div>
    </div>

</div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const bulan = @json($bulan);

new Chart(document.getElementById('chartKeuangan'), {
    type: 'line',
    data: {
        labels: bulan,
        datasets: [
            {
                label: 'Pemasukan',
                data: @json($dataPemasukan),
                borderWidth: 2,
                tension: 0.3
            },
            {
                label: 'Pengeluaran',
                data: @json($dataPengeluaran),
                borderWidth: 2,
                tension: 0.3
            }
        ]
    }
});

new Chart(document.getElementById('chartCustomer'), {
    type: 'bar',
    data: {
        labels: bulan,
        datasets: [{
            label: 'Jumlah Customer',
            data: @json($dataCustomer),
            borderWidth: 1
        }]
    }
});

</script>

@endpush