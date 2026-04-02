<!DOCTYPE html>
<html>
<head>
    <title>Nota Laundry</title>

    <style>
        body{
            font-family: monospace;
            font-size:12px;
            margin:0;
        }

        #nota{
            padding:6px;
        }

        .center{ text-align:center; }

        .line{
            border-top:1px dashed #000;
            margin:6px 0;
        }

        .row{
            display:flex;
            justify-content:space-between;
            margin:2px 0;
        }

        .small{ font-size:11px; }
        .bold{ font-weight:bold; }

        @media print {
            body { margin:0; }
            #nota { width:80mm; }
        }
    </style>
</head>

<body>

@php
$width = isset($setting) && $setting->custom_width
    ? $setting->custom_width . 'mm'
    : ((isset($setting) && $setting->tipe_kertas == '53mm') ? '53mm' : '80mm');
@endphp

<div id="nota" style="width: {{ $width }};">

    <!-- HEADER -->
    <div class="center">

    @if(isset($setting) && $setting->show_logo)
        <img src="{{ asset('admin/assets/images/logo-nota.png') }}"
     style="width:120px; display:block; margin:0 auto 2px; filter: grayscale(100%); contrast(200%);">
    @endif

        <div class="bold">{{ $setting->nama_toko ?? 'LAUNDIO' }}</div>
        {{ $setting->alamat ?? '' }}<br>
        {{ $pemesanan->outlet->kota_kab ?? '' }}<br>
        Telp: {{ $setting->telepon ?? '-' }}
    </div>

    <div class="line"></div>

    <!-- INFO ORDER -->
    <div class="small">
        <div>Order   : {{ $pemesanan->no_order }}</div>
        <div>Tanggal : {{ $pemesanan->tanggal_masuk }}</div>
        <div>Pelanggan : {{ $pemesanan->customer->nama_lengkap }}</div>
        <div>No HP   : {{ $pemesanan->customer->no_telp ?? '-' }}</div>
    </div>

    @if(isset($setting) && $setting->show_maps && $pemesanan->latitude && $pemesanan->longitude)
        <div class="small">
            Lokasi :
            <a href="https://www.google.com/maps?q={{ $pemesanan->latitude }},{{ $pemesanan->longitude }}"
            target="_blank">
                Buka Maps
            </a>
        </div>
        @endif

    <div class="line"></div>

    <!-- DETAIL LAYANAN -->
    <div class="center bold small">DETAIL LAYANAN</div>
    <div class="line"></div>

    @php
        $detail = json_decode($pemesanan->detail_layanan ?? '[]', true);
        $detail = is_array($detail) ? $detail : [];
        $totalLayanan = 0;
    @endphp

    @if(count($detail) > 0)

        @foreach($detail as $item)

            @php
                $layanan = \App\Models\Harga::where('kode_layanan',$item['kode_layanan'])->first();
                $harga = $layanan->harga ?? 0;
                $qty = $item['qty'];
                $subtotal = $harga * $qty;
                $totalLayanan += $subtotal;
            @endphp

            <div>{{ $layanan->nama_layanan ?? '-' }}</div>

            <div class="row small">
                <span>{{ $qty }} x {{ number_format($harga,0,',','.') }}</span>
                <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
            </div>

        @endforeach

    @else

        <div class="row">
            <span>Layanan</span>
            <span>Rp {{ number_format($pemesanan->total_harga - $pemesanan->ongkir,0,',','.') }}</span>
        </div>

    @endif

    <div class="line"></div>

    <!-- JARAK & ONGKIR -->
    <div class="row">
        <span>Jarak</span>
        <span>{{ number_format($pemesanan->jarak_km,2) }} km</span>
    </div>

    <div class="row">
        <span>Ongkir</span>
        <span>Rp {{ number_format($pemesanan->ongkir,0,',','.') }}</span>
    </div>

     @php
        $promo = \App\Models\Promo::where('id_promo', $pemesanan->id_promo)->first();
    @endphp

    <div class="line"></div>

    {{-- RINCIAN DISKON --}}
    @php
        $subtotal = $totalLayanan + $pemesanan->ongkir;
        $diskon = $pemesanan->diskon ?? 0;
        $totalAkhir = $subtotal - $diskon;
    @endphp

    <div class="row">
        <span>Subtotal</span>
        <span>Rp {{ number_format($subtotal,0,',','.') }}</span>
    </div>

    @if($pemesanan->promo && $pemesanan->diskon > 0)

        <div class="row small">
            <span>Promo</span>
            <span>{{ $pemesanan->promo->nama_promo }}</span>
        </div>

        <div class="row small">
            <span>Diskon</span>
            <span>-Rp {{ number_format($pemesanan->diskon,0,',','.') }}</span>
        </div>

    @endif

    <div class="row bold">
        <span>TOTAL BAYAR</span>
        <span>Rp {{ number_format($totalAkhir,0,',','.') }}</span>
    </div>

    <div class="line"></div>

    <!-- STATUS -->
    <div class="small">
        <div>Status Proses : {{ ucfirst($pemesanan->status_proses ?? 'diterima') }}</div>
        <div>Status Bayar  : {{ ucfirst($pemesanan->status_bayar ?? 'belum') }}</div>
    </div>

    <div class="line"></div>

    <!-- FOOTER -->
    <div class="center small">
        {{ $setting->footer ?? 'Terima kasih 🙏' }} <br>
        Bersih Tak Kenal Waktu<br><br>
        Jam: {{ $setting->jam_buka ?? '-' }}<br>
        WA: {{ $pemesanan->outlet->no_telp ?? '-' }}
    </div>

</div>

<script>
window.print();
</script>

</body>
</html>