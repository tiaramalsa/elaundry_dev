@extends('layouts.dashboard')

@section('title', 'Data Customer')

@section('content')
{{-- <h3 class="page-title">Data Customer</h3> --}}
    <div class="card">
    <h3 class="page-title">Daftar Customer</h3>

        {{-- TOP ACTION --}}
        <div class="top-action">
            <div></div>

            <a href="{{ route('manajemen.customer.create') }}" class="btn btn-sm">
                + Tambah Customer 
            </a>
        </div>

        <!-- 🔥 FILTER MEMBER -->
        <div class="filter-tabs">
            <a href="{{ route('manajemen.customer.index') }}"
            class="tab {{ !$filter ? 'active' : '' }}">
                Semua
            </a>

            <a href="{{ route('manajemen.customer.index', ['filter'=>'member']) }}"
            class="tab {{ $filter=='member' ? 'active' : '' }}">
                Member
            </a>

            <a href="{{ route('manajemen.customer.index', ['filter'=>'non']) }}"
            class="tab {{ $filter=='non' ? 'active' : '' }}">
                Non Member
            </a>
        </div>

        {{-- TABLE --}}
        <div style="margin-top: 20px; overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. WhatsApp</th>
                        <th>Titik Lokasi</th>
                        <th>Status Member</th>
                        <th style="text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $customer->nama_lengkap }}</td>
                            <td>{{ $customer->alamat }}</td>
                            <td>{{ $customer->no_telp }}</td>
                            <td class="text-center">
                                @if ($customer->latitude && $customer->longitude)
                                    <a href="https://www.google.com/maps?q={{ $customer->latitude }},{{ $customer->longitude }}"
                                    target="_blank"
                                    class="btn-lokasi">
                                        📍 Lihat
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($customer->is_member)
                                    <span class="badge badge-member">Member</span>
                                @else
                                    <span class="badge badge-non">Non Member</span>
                                @endif
                            </td>
                            <td class="aksi">
                                {{-- EDIT --}}
                                <a href="{{ route('manajemen.customer.edit', $customer->id_cust) }}" title="Edit">✎</a>

                                {{-- HAPUS --}}
                                <form action="{{ route('manajemen.customer.destroy', $customer->id_cust) }}"
                                      method="POST"
                                      style="display:inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus customer ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus">🗑</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color:#64748b;">
                                Belum ada data customer
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- STYLE (SAMA PERSIS DENGAN KARYAWAN) --}}
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

        /* BUTTON TAMBAH CUSTOMER - ORANGE */
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

        .text-center {
            text-align: center;
        }

        .btn-lokasi {
            background: rgba(22,163,154,0.15);
            color: #16a39a;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: 0.2s ease;
        }

        .btn-lokasi:hover {
            background: #16a39a;
            color: white;
        }

        .aksi {
            text-align: center;
        }

        /* ✏️ EDIT POLLOSAN */
        .aksi {
            display: flex;
            justify-content: center;
            align-items: center;     
            gap: 8px;
        }

        .aksi form {
            margin: 0;
        }

        .aksi a {
            text-decoration: none;
            color: inherit; /* ikut warna teks default */
            font-size: 16px;
            margin: 0 4px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .aksi button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin: 0 4px;
        }

        .aksi a:hover,
        .aksi button:hover {
            opacity: 0.7;
        }

                /* 🔗 LINK TITIK LOKASI */
        .link-lokasi {
            color: #f97316; /* biru default */
            text-decoration: underline;
        }

        .link-lokasi:hover {
            color: #f97316;
        }

        /* ============================= */
        /* 🔥 FILTER TAB MODEL ORDER HISTORY */
        /* ============================= */

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

        /* ============================= */
        /* 🎨 BADGE STATUS MEMBER */
        /* ============================= */

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-member {
            background: rgba(22,163,154,0.15);
            color: #16a39a;
        }

        .badge-non {
            background: rgba(230,120,0,0.15);
            color: #e67800;
        }
    </style>
@endsection
