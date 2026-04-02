@extends('layouts.admin')

@section('title','Daftar Pengaturan Cetak')

@section('content')

<div class="page-header">
    <h3 class="page-title">Daftar Custom Nota</h3>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <a href="{{ route('cetak.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Tambah
        </a>
    </div>
</div>

<div class="custom-tabs mb-4">
    <a href="{{ route('cetak.index') }}" class="tab active">
        Semua Nota
    </a>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped" id="tabelCetak">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Toko</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $item->nama_toko }}</strong></td>
                                <td>{{ $item->telepon }}</td>

                                <td>
                                    <label class="switch">
                                        <input type="checkbox"
                                            {{ $item->status ? 'checked' : '' }}
                                            onchange="window.location='{{ route('cetak.toggle', $item->id) }}'">
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center">

                                        <a href="{{ route('cetak.show', $item->id) }}"
                                        class="btn btn-sm btn-outline-info mr-2"
                                        title="Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>

                                        <a href="{{ route('cetak.edit', $item->id) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    Belum ada data
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
.custom-tabs{
    display:flex;
    gap:25px;
    border-bottom:2px solid #e2e8f0;
    padding-bottom:8px;
}

.custom-tabs .tab{
    text-decoration:none;
    font-weight:600;
    font-size:14px;
    color:#6c757d;
    padding-bottom:6px;
    position:relative;
}

.custom-tabs .tab.active{
    color:#4B49AC;
}

.custom-tabs .tab.active::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-10px;
    width:100%;
    height:3px;
    background:#4B49AC;
    border-radius:3px;
}

.custom-tabs .tab:hover{
    color:#4B49AC;
}

/* toggle switch */
.switch {
    position: relative;
    display: inline-block;
    width: 55px;
    height: 28px;
}

.switch input {
    display: none;
}

.slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: #d1d5db;
    transition: .4s;
    border-radius: 30px;
}

.slider:before {
    content: "";
    position: absolute;
    height: 22px;
    width: 22px;
    left: 3px;
    bottom: 3px;
    background: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background: #14b8a6;
}

input:checked + .slider:before {
    transform: translateX(26px);
}
</style>
@endpush


@push('scripts')
<script>
$(document).ready(function(){
    $('#tabelCetak').DataTable();
});
</script>
@endpush