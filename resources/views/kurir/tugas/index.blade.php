<h3>📥 Pickup (Ambil Laundry)</h3>

@forelse($pickup as $item)
<div class="card" style="margin-bottom:15px;padding:15px;border:1px solid #ddd;border-radius:10px;">

    <p><strong>Nama:</strong> {{ $item->customer->nama_lengkap }}</p>
    <p><strong>Alamat:</strong> {{ $item->customer->alamat }}</p>
    <p><strong>Status:</strong> {{ $item->status_proses }}</p>

    <!-- Tombol Google Maps -->
    <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}"
       target="_blank">
        <button style="margin-bottom:8px;">📍 Lihat Lokasi</button>
    </a>

    <!-- 🔥 Tombol Ambil -->
    <form method="POST" action="{{ route('kurir.ambil', $item->id_pemesanan) }}">
        @csrf
        <button type="submit" style="background:green;color:white;">
            ✅ Ambil Laundry
        </button>
    </form>

</div>
@empty
<p>Tidak ada tugas pickup</p>
@endforelse


<hr>


<h3>📦 Delivery (Antar Laundry)</h3>

@forelse($delivery as $item)
<div class="card" style="margin-bottom:15px;padding:15px;border:1px solid #ddd;border-radius:10px;">

    <p><strong>Nama:</strong> {{ $item->customer->nama_lengkap }}</p>
    <p><strong>Alamat:</strong> {{ $item->customer->alamat }}</p>
    <p><strong>Status:</strong> {{ $item->status_proses }}</p>

    <!-- Tombol Google Maps -->
    <a href="https://www.google.com/maps?q={{ $item->latitude }},{{ $item->longitude }}"
       target="_blank">
        <button style="margin-bottom:8px;">📍 Lihat Lokasi</button>
    </a>

    <!-- 🔥 Tombol Antar -->
    <form method="POST" action="{{ route('kurir.antar', $item->id_pemesanan) }}">
        @csrf
        <button type="submit" style="background:blue;color:white;">
            🚚 Antar Laundry
        </button>
    </form>

</div>
@empty
<p>Tidak ada tugas delivery</p>
@endforelse