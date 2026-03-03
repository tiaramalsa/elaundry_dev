@php
    $role = auth()->user()->role;
@endphp

@extends(
    auth()->user()->role === 'admin'
        ? 'layouts.dashboard'
        : 'layouts.dashboard_kasir'
)

@section('title', 'Riwayat Pemesanan')

@section('content')
    <h3 class="page-title">Riwayat Pemesanan Laundry</h3>

    <div class="card">
        {{-- FILTER --}}
        @php
            $role = auth()->user()->role;
        @endphp
        <form method="GET" action="{{ route($role . '.riwayat.index') }}">
            <div class="row filter-row">

                <div class="filter-item">
                    <select name="layanan">
                    <option value="">Jenis Layanan</option>
                    <option value="cuci" {{ request('layanan')=='cuci'?'selected':'' }}>Cuci</option>
                    <option value="setrika" {{ request('layanan')=='setrika'?'selected':'' }}>Setrika</option>
                    <option value="cuci_setrika" {{ request('layanan')=='cuci_setrika'?'selected':'' }}>Cuci Setrika</option>
                    <option value="sprei" {{ request('layanan')=='sprei'?'selected':'' }}>Sprei</option>
                </select></div>

                <div class="filter-item">
                    <input type="date" name="from" value="{{ request('from') }}">
                </div>

                    <div class="filter-item">
                        <button class="btn" type="submit">Terapkan</button>
                    </div>
            </div>
        </form>


        {{-- TABLE --}}
        <div style="margin-top: 20px; overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Nama</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th >Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pemesanans as $p)
                <tr>
                    @php
                        $history = $p->historyPemesanan->last();
                        $pembayaran = $history->pembayaran ?? 'belum_bayar';
                    @endphp
                    <td>{{ $p->no_order }}</td>

                    <td>{{ $p->customer->nama_lengkap ?? '-' }}</td>

                    <td>
                        Rp {{ number_format($p->total_harga ?? 0,0,',','.') }}
                    </td>

                    <td>
                        @if($pembayaran === 'lunas')
                            <span class="badge bayar-lunas">Lunas</span>
                        @else
                            <span class="badge bayar-belum">Belum Bayar</span>
                        @endif
                    </td>

                    <td>
                        <span class="badge selesai">
                            {{ ucfirst($p->status_proses) }}
                        </span>
                    </td>

                    <td class="aksi">
                    {{-- UNDUH --}}
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.riwayat.download', $p->id_pemesanan) }}"
                    title="Unduh"
                    class="icon-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                        </svg>
                    </a>
                    @endif

                    {{-- HAPUS --}}
                    @if(auth()->user()->role === 'admin')
                    <form method="POST"
                        action="{{ route('admin.riwayat.destroy', $p->id_pemesanan) }}"
                        class="inline"
                        onsubmit="return confirm('Hapus riwayat ini?')">
                        @csrf
                        @method('DELETE')
                        <button title="Hapus" class="icon-btn danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m3-3h4a1 1 0 011 1v1H9V5a1 1 0 011-1z"/>
                            </svg>
                        </button>
                    </form>
                    @endif
                </td>


                </tr>
                @empty
                <tr>
                    <td colspan="6">Tidak ada riwayat pemesanan</td>
                </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- STYLE KHUSUS TABLE --}}
    <style>
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

        .aksi button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-right: 6px;
        }

        .aksi button:hover {
            opacity: 0.7;
        }

        .badge.selesai {
            background: rgba(22,163,154,0.15);
            color: #16a39a;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
        }

        .badge.bayar-lunas {
            background: rgba(22,163,154,0.15);
            color: #16a39a;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
        }

        .badge.bayar-belum {
            background: rgba(230,120,0,0.15);
            color: #e67800;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
        }

        .aksi {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-btn {
            background: none;
            border: none;
            padding: 4px;
            color: #475569; /* slate-600 */
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        .icon-btn:hover {
            color: #16a39a;
        }

        .icon-btn.danger:hover {
            color: #dc2626; /* red-600 */
        }

        .inline {
            display: inline;
        }

        /* ================= FILTER LAYOUT ================= */

        .filter-row {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        /* Select & Date memanjang */
        .filter-item:nth-child(1),
        .filter-item:nth-child(2) {
            flex: 1;
        }

        /* Tombol kecil di kanan */
        .filter-item:nth-child(3) {
            flex: 0;
        }

        /* Input full di dalam kotaknya */
        .filter-item select,
        .filter-item input {
            width: 100%;
            padding: 8px 10px;
        }

        /* Tombol tidak melebar */
        .filter-item button {
            white-space: nowrap;
            padding: 8px 18px;
        }

        /* ================= MOBILE ================= */

        @media (max-width: 768px) {

            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-item {
                width: 100%;
            }

            .filter-item button {
                width: 100%;
            }
        }
    </style>
@endsection
