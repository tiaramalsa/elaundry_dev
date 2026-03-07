@extends(
    auth()->user()->role === 'admin'
        ? 'layouts.admin'
        : 'layouts.dashboard_kasir'
)

@section('title','Data Customer')

@section('content')

<div class="page-header">
    <h3 class="page-title">Data Customer</h3>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <a href="{{ route('manajemen.customer.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Tambah Customer
        </a>
    </div>
</div>

{{-- FILTER TABS --}}
<div class="order-tabs mb-4">

    <a href="{{ route('manajemen.customer.index') }}"
       class="tab {{ !$filter ? 'active' : '' }}">
        Semua
    </a>

    <a href="{{ route('manajemen.customer.index',['filter'=>'member']) }}"
       class="tab {{ $filter=='member' ? 'active' : '' }}">
        Member
    </a>

    <a href="{{ route('manajemen.customer.index',['filter'=>'non']) }}"
       class="tab {{ $filter=='non' ? 'active' : '' }}">
        Non Member
    </a>

</div>


<div class="row">
<div class="col-lg-12 grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h4 class="card-title">Daftar Customer</h4>

<div class="table-responsive">

<table class="table table-striped" id="tabelCustomer">

<thead>
<tr>
<th>No</th>
<th>Nama</th>
<th>Alamat</th>
<th>No WhatsApp</th>
<th>Titik Lokasi</th>
<th>Status Member</th>
<th class="text-center">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($customers as $index => $customer)

<tr>

<td>{{ $index + 1 }}</td>
<td>{{ $customer->nama_lengkap }}</td>
<td>{{ Str::limit($customer->alamat, 60) }}</td>
<td>{{ $customer->no_telp }}</td>

<td>
@if ($customer->latitude && $customer->longitude)

<a href="https://www.google.com/maps?q={{ $customer->latitude }},{{ $customer->longitude }}"
   target="_blank"
   class="text-primary font-weight-bold">
   Lihat Lokasi
</a>

@else
-
@endif
</td>

<td>
@if($customer->is_member)
<span class="badge badge-success">Member</span>
@else
<span class="badge badge-warning">Non Member</span>
@endif
</td>

<td class="text-center">

<a href="{{ route('manajemen.customer.edit',$customer->id_cust) }}"
   class="btn btn-sm btn-outline-primary">
   <i class="mdi mdi-pencil"></i>
</a>

<form action="{{ route('manajemen.customer.destroy',$customer->id_cust) }}"
      method="POST"
      style="display:inline;"
      onsubmit="return confirm('Yakin ingin menghapus customer ini?')">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-outline-danger">
<i class="mdi mdi-delete"></i>
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="7" class="text-center py-4">
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

    #tabelCustomer td:nth-child(3),
    #tabelCustomer th:nth-child(3){
        max-width: 300px;
        white-space: normal;
        word-wrap: break-word;
    }

</style>
@endpush


@push('scripts')
<script>

$(document).ready(function(){

$('#tabelCustomer').DataTable();

});

</script>
@endpush