@extends('layouts.dashboard')

@section('title', 'Manajemen Harga')

@section('content')

    <div class="card">
        <h4 class="page-title">Daftar Harga</h4>
        {{-- TOP ACTION --}}
        <div class="top-action">
            <div></div>

            <a href="{{ route('manajemen.harga.create') }}" class="btn btn-sm">
                + Tambah Harga 
            </a>
        </div>

        {{-- FILTER KATEGORI --}}
        <div class="filter-tabs">
            <a href="{{ route('manajemen.harga.index') }}"
            class="tab {{ !request('kategori') ? 'active' : '' }}">
                Semua
            </a>

            <a href="{{ route('manajemen.harga.index', ['kategori' => 'laundry']) }}"
            class="tab {{ request('kategori') == 'laundry' ? 'active' : '' }}">
                Laundry
            </a>

            <a href="{{ route('manajemen.harga.index', ['kategori' => 'jasa']) }}"
            class="tab {{ request('kategori') == 'jasa' ? 'active' : '' }}">
                Jasa
            </a>
        </div>

        {{-- TABLE --}}
        <div style="margin-top: 20px; overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kategori</th>
                        <th>Jenis Layanan</th>
                        <th>Satuan</th>
                        <th>Jarak</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th style="text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($harga as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst($item->kategori) }}</td>
                            <td>{{ $item->nama_layanan }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>
                                @if ($item->kategori == 'jasa')
                                    {{ $item->jarak ?? '-' }} km
                                @else
                                    -
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="aksi">
                                <a href="{{ route('manajemen.harga.edit', $item->id) }}" title="Edit">✎</a>

                                <form action="{{ route('manajemen.harga.destroy', $item->id) }}"
                                      method="POST"
                                      style="display:inline"
                                      onsubmit="return confirm('Yakin hapus data harga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus">🗑</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; color:#64748b;">
                                Belum ada data harga
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- STYLE (SAMA DENGAN CUSTOMER) --}}
    <style>
        .page-title {
            font-weight: 600;
            margin-bottom: 16px;
        }

        .top-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-tabs {
            display: flex;
            gap: 30px;
            border-bottom: 2px solid #e2e8f0;
            margin: 10px 0 20px 0;
        }

        .tab {
            padding: 10px 0;
            text-decoration: none;
            font-weight: 600;
            color: #64748b;
            position: relative;
        }

        .tab:hover {
            color: #16a39a;
        }

        .tab.active {
            color: #16a39a;
        }

        .tab.active::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 3px;
            background: #16a39a;
            border-radius: 2px;
        }

        .btn {
            background: #ff8a00;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
            align-self: flex-end;
            margin-top: 15px;
            text-decoration: none;
            display: inline-flex;
            line-height: 1;
        }

        .btn-sm {
            padding: 10px 16px;
            font-size: 14px;
        }

        .btn-sm:hover {
            background: #e67800;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table thead {
            background: #16a39a;
            color: white;
        }

        .table th,
        .table td {
            padding: 10px 12px;
            text-align: left;
        }

        .table tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }

        .table tbody tr:hover {
            background: #f1f9f9;
        }

        .aksi {
            display: flex;
            justify-content: center; 
            align-items: center;   
            gap: 8px;
        }

        .aksi a,
        .aksi button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin: 0 4px;
            color: inherit;
        }

        .aksi a:hover,
        .aksi button:hover {
            opacity: 0.7;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success {
            background: rgba(22,163,154,0.15);
            color: #16a39a;
        }

        .badge-danger {
            background: rgba(230,120,0,0.15);
            color: #e67800;
        }
    </style>
@endsection
