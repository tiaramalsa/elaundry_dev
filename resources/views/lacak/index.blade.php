@extends(
    auth()->user()->role === 'admin'
        ? 'layouts.dashboard'
        : 'layouts.dashboard_kasir'
)

@section('title', 'Lacak Pemesanan')

@section('content')
    <h3 class="page-title">Update Status Pemesanan Laundry</h3>

    <div class="tracking-dashboard">

    <div class="track-card diterima">
        <div class="track-icon">⏳</div>
        <div>
            <p>Diterima</p>
            <h3>{{ $trackingCount['diterima'] }}</h3>
        </div>
    </div>

    <div class="track-card dicuci">
        <div class="track-icon">🧼</div>
        <div>
            <p>Dicuci</p>
            <h3>{{ $trackingCount['dicuci'] }}</h3>
        </div>
    </div>

    <div class="track-card dikeringkan">
        <div class="track-icon">🌬️</div>
        <div>
            <p>Dikeringkan</p>
            <h3>{{ $trackingCount['dikeringkan'] }}</h3>
        </div>
    </div>

    <div class="track-card disetrika">
        <div class="track-icon">👕</div>
        <div>
            <p>Disetrika</p>
            <h3>{{ $trackingCount['disetrika'] }}</h3>
        </div>
    </div>

    <div class="track-card selesai">
        <div class="track-icon">📦</div>
        <div>
            <p>Selesai</p>
            <h3>{{ $trackingCount['selesai'] }}</h3>
        </div>
    </div>

</div>

    <div class="card">
        {{-- FILTER --}}
        @php
            $role = auth()->user()->role;
        @endphp
        <form method="GET" action="{{ route($role . '.lacak.index') }}">
            <div class="row filter-row">
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

        {{-- TABLE --}}
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Nama</th>
                        <th>Payment</th>
                        <th>Tipe</th>
                        <th>Jenis Layanan</th>
                        <th style="text-align:center;">Aksi</th>
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
                    <td>{{ $p->jenis_layanan }}</td>
                    <td class="aksi">
                        @php
                            $role = auth()->user()->role;
                            $id = $p->source === 'pemesanan'
                                ? $p->id_pemesanan
                                : $p->id_reservasi;
                        @endphp

                        <form method="POST" action="{{ route($role . '.lacak.next', $id) }}">
                            @csrf
                            <input type="hidden" name="source" value="{{ $p->source ?? '' }}">
                            <button 
                                type="submit"
                                class="{{ $p->status_proses === 'disetrika' ? 'selesai' : '' }}">
                                {{ $p->status_proses === 'disetrika' ? 'Selesai' : 'Next' }}
                            </button>
                        </form>
                    </td>


                </tr>
                @empty
                <tr>
                    <td colspan="6">Tidak ada data</td>
                </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- STYLE KHUSUS TABLE --}}
<style>
html, body {
    overflow-x: hidden;
}

/* ===============================
   CARD WRAPPER
=============================== */
.card {
    max-width: 100%;
    overflow: hidden;
}

/* ===============================
   TRACKING DASHBOARD
=============================== */
.tracking-dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.track-card {
    background: #fff;
    border-radius: 10px;
    padding: 12px 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all .25s ease;
}

.track-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.12);
    cursor: pointer;
}

.track-card p {
    margin: 0;
    font-size: 13px;
    color: #64748b;
}

.track-card h3 {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
}

.track-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #f1f9f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

/* warna */
.track-card.diterima { border-left: 5px solid #FFEE91; }
.track-card.dicuci { border-left: 5px solid #EA7B7B; }
.track-card.dikeringkan { border-left: 5px solid #9CCFFF; }
.track-card.disetrika { border-left: 5px solid #A3D78A; }
.track-card.selesai { border-left: 5px solid #E6CFA9; }

/* ===============================
   FILTER SECTION
=============================== */
.filter-row {
    display: grid;
    grid-template-columns: 
        minmax(150px,1fr)
        minmax(150px,1fr)
        minmax(120px,1fr)
        minmax(180px,1fr)
        minmax(180px,1fr)
        auto;
    gap: 14px;
    align-items: end;
}

.filter-row select,
.filter-row input {
    height: 45px;
    padding: 0 10px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
}

/* floating date */
.date-field {
    position: relative;
}

.date-field input {
    height: 48px;
    padding: 14px 10px 8px 10px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    width: 100%;
    background: #fff;
}

.date-field label {
    position: absolute;
    top: -8px;
    left: 12px;
    background: #fff;
    padding: 0 6px;
    font-size: 12px;
    color: #0f766e;
    font-weight: 500;
}

.btn-apply {
    background: #ff8c1a;
    color: #fff;
    border: none;
    height: 45px;
    padding: 0 22px;
    border-radius: 20px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}

.btn-apply:hover {
    background: #e67e0f;
}

/* ===============================
   TABLE
=============================== */
.table-wrapper {
    margin-top: 20px;
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

/* tombol aksi */
.aksi button {
    background: #ff8a00;
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.aksi button:hover {
    background: #e67800;
    transform: translateY(-2px);
}

.aksi button.selesai {
    background: #16a39a;
}

.aksi button:active {
    transform: scale(0.96);
}

/* ===============================
   RESPONSIVE
=============================== */
@media (max-width: 992px) {

    .filter-row {
        grid-template-columns: 1fr 1fr;
    }

    .filter-action {
        grid-column: span 2;
    }

    .table-wrapper {
        overflow-x: auto;
    }
}

@media (max-width: 768px) {

    .filter-row {
        grid-template-columns: 1fr;
    }

    .btn-apply {
        width: 100%;
    }
}
</style>
@endsection
