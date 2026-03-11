@extends(
    auth()->user()->role === 'admin'
        ? 'layouts.admin'
        : 'layouts.dashboard_kasir'
)

@section('title','Pemesanan Laundio')

@section('content')

<div class="form-row">
<div class="col-lg-12 form-grid-margin stretch-card">

<div class="card">
<div class="card-body">

<h3 class="card-title">Input Order</h3>

@if ($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form id="form-pemesanan" method="POST" action="{{ route('pemesanan.store') }}">
@csrf

<input type="hidden" name="id_outlet" value="3">

{{-- DATA CUSTOMER --}}
<div class="card-section">

<div class="form-row">

<div class="col-md-6">
<input type="text" name="nama_lengkap"
class="form-control"
placeholder="Nama Customer" required>
</div>

<div class="col-md-6">
<input type="text" name="no_telp"
class="form-control"
placeholder="No Telepon" required>
</div>

</div>

<div class="row mt-3">

<div class="col-md-12">
<textarea id="alamat"
name="alamat"
class="form-control"
placeholder="Alamat"
rows="3"
required></textarea>
</div>

</div>

<div id="map" style="height:300px;border-radius:10px;margin-top:15px;"></div>

<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">
<input type="hidden" name="ongkir" id="ongkir_input">

</div>


{{-- DETAIL LAYANAN --}}
<div class="card-section mt-4">

<h5 class="mb-3">Detail Layanan</h5>

<div class="row font-weight-bold text-muted mb-2">
    <div class="col-md-4">Jenis</div>
    <div class="col-md-2">Harga</div>
    <div class="col-md-2">Qty</div>
    <div class="col-md-3">Total</div>
    <div class="col-md-1"></div>
</div>

<div id="layanan-container"></div>

<button type="button"
onclick="tambahRow()"
class="btn btn-primary btn-sm mt-2">
<i class="mdi mdi-plus"></i> Tambah
</button>

</div>


{{-- TOTAL --}}
<div class="total-box mt-4">
<span>Total Pembayaran</span>
<span id="grand-total">Rp 0</span>
</div>


{{-- PROMO --}}
<div class="card-section">

<h5 class="mb-3">Promo</h5>

<select id="promo_select"
name="id_promo"
class="form-control"
onchange="applyPromo()">

<option value="">-- Tanpa Promo --</option>

@foreach($promos as $promo)
<option
value="{{ $promo->id_promo }}"
data-basis="{{ $promo->basis_promo }}"
data-nilai="{{ $promo->nilai_promo }}"
data-minimal="{{ $promo->minimal_transaksi }}"
>

{{ $promo->nama_promo }}
(
{{ $promo->basis_promo == 'persentase'
? $promo->nilai_promo.'%'
: 'Rp '.number_format($promo->nilai_promo,0,',','.') }}
)

</option>
@endforeach

</select>

<div class="mt-2 font-weight-bold text-success">
Diskon: <span id="diskon_text">Rp 0</span>
</div>

</div>


<input type="hidden" name="total_harga" id="total_harga_input">
<input type="hidden" name="detail_layanan" id="detail_layanan_input">
<input type="hidden" name="diskon" id="diskon_input">


{{-- CATATAN --}}
<div class="card-section">

<h5 class="mb-3">Catatan</h5>

<textarea name="catatan_khusus"
class="form-control"
placeholder="Catatan Khusus"
rows="3"></textarea>

</div>


<div class="d-flex justify-content-between mt-4">

<a href="{{ route('pemesanan.index') }}" class="btn btn-secondary">
<i class="mdi mdi-arrow-left"></i> Kembali
</a>

<button class="btn btn-success">
<i class="mdi mdi-check"></i> Pesan
</button>

</div>


{{-- MAP LIBRARY --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</form>

<div id="successModal" class="modal-overlay" style="display:none">
    <div class="modal-box">
        <div class="check-icon">✔</div>
        <h3>Berhasil 🎉</h3>
        <p>Pemesanan berhasil dibuat</p>

        <div style="display:flex;gap:10px;justify-content:center;margin-top:20px">
            <button onclick="closeModal()" class="btn-secondary">Tutup</button>
            <a id="btnNota" class="btn-primary" target="_blank">Unduh Nota</a>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>

<!-- Nota -->
<script>
    document.getElementById('form-pemesanan')
    .addEventListener('submit', function(e) {

        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(async res => {

            if (!res.ok) {
                const text = await res.text();
                console.log("ERROR RESPONSE:", text);
                alert("Server Error. Cek console.");
                return null;
            }

            return res.json();
        })
        .then(res => {

        if (!res) return;

        if (res.success) {

            document.getElementById('successModal')
                .style.display = 'flex';

            document.getElementById('btnNota')
                .href = `/pemesanan/${res.id}/nota`;
        }
    })
    .catch(err => {
        console.log(err);
            alert('Terjadi kesalahan');
        });

    });
</script>



{{-- Jenis layanan --}}
<script>
    const hargaList = @json($hargaList);
    let rowIndex = 0;

    function generateOptgroup() {

        let grouped = {};

        hargaList.forEach(h => {
            if (!grouped[h.kategori]) {
                grouped[h.kategori] = [];
            }
            grouped[h.kategori].push(h);
        });

        let html = '';

        Object.keys(grouped).forEach(kategori => {

            html += `<optgroup label="${capitalize(kategori)}">`;

            grouped[kategori].forEach(h => {
                html += `
                    <option value="${h.kode_layanan}" data-harga="${h.harga}">
                        ${h.nama_layanan}
                    </option>
                `;
            });

            html += `</optgroup>`;
        });

        return html;
    }

    function capitalize(text) {
        return text.charAt(0).toUpperCase() + text.slice(1);
    }

    function tambahRow() {

        const container = document.getElementById('layanan-container');

        const row = document.createElement('div');
        row.className = 'row mt-2 align-items-center';

        row.innerHTML = `
            <div class="col-md-4">
                <select class="form-control"
                    onchange="updateHarga(${rowIndex})"
                    id="layanan_${rowIndex}">
                    <option value="">Pilih Layanan</option>
                    ${generateOptgroup()}
                </select>
            </div>

            <div class="col-md-2">
                <input type="text"
                    class="form-control"
                    id="harga_${rowIndex}"
                    readonly>
            </div>

            <div class="col-md-2">
                <input type="number"
                    class="form-control"
                    min="1"
                    value="1"
                    oninput="hitungRow(${rowIndex})"
                    id="qty_${rowIndex}">
            </div>

            <div class="col-md-3">
                <input type="text"
                    class="form-control"
                    id="total_${rowIndex}"
                    readonly>
            </div>

            <div class="col-md-1 text-center">
                <button type="button"
                    class="btn btn-danger btn-sm"
                    onclick="hapusRow(this)">
                    <i class="mdi mdi-close"></i>
                </button>
            </div>
        `;

        container.appendChild(row);
        rowIndex++;
    }

    function updateHarga(i) {

        const select = document.getElementById(`layanan_${i}`);
        const hargaInput = document.getElementById(`harga_${i}`);

        const harga = parseInt(select.selectedOptions[0]?.dataset.harga || 0);

        hargaInput.value = formatRupiah(harga);

        hitungRow(i);
    }

    function hitungRow(i) {

        const select = document.getElementById(`layanan_${i}`);
        const harga = parseInt(select.selectedOptions[0]?.dataset.harga || 0);
        const qty = parseInt(document.getElementById(`qty_${i}`).value || 0);

        const total = harga * qty;

        document.getElementById(`total_${i}`).value = formatRupiah(total);

        hitungGrandTotal();
    }

    function hitungGrandTotal() {

        let total = 0;

        for (let i = 0; i < rowIndex; i++) {
            const totalField = document.getElementById(`total_${i}`);
            if (!totalField) continue;

            const value = totalField.value.replace(/[^\d]/g,'');
            total += parseInt(value || 0);
        }

        document.getElementById('grand-total')
            .innerText = formatRupiah(total);

        document.getElementById('total_harga_input')
            .value = total;

        simpanDetail();
    }

    function hapusRow(btn) {
        btn.closest('.row').remove();
        hitungGrandTotal();
    }

    function formatRupiah(angka) {
        return 'Rp ' + Number(angka).toLocaleString('id-ID');
    }

    function simpanDetail() {

        let detail = [];

        for (let i = 0; i < rowIndex; i++) {

            const select = document.getElementById(`layanan_${i}`);
            const qty = document.getElementById(`qty_${i}`);

            if (!select || !qty) continue;
            if (!select.value) continue;

            detail.push({
                kode_layanan: select.value,
                qty: qty.value
            });
        }

        document.getElementById('detail_layanan_input')
            .value = JSON.stringify(detail);
    }

    document.addEventListener('DOMContentLoaded', tambahRow);
</script>

{{-- Maps dan Ongkir --}}
<script>
    let jarakGlobal = 0;
    let ongkirGlobal = 0;
    document.addEventListener("DOMContentLoaded", function () {

        const outletLat = -6.9815723;
        const outletLng = 110.3913043;

        const outlet = L.latLng(outletLat, outletLng);

        const map = L.map('map').setView([outletLat, outletLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([outletLat, outletLng])
            .addTo(map)
            .bindPopup("Lokasi Outlet");

        let customerMarker;

        function hitungOngkir(customerLat, customerLng) {

            const customer = L.latLng(customerLat, customerLng);
            const jarakMeter = outlet.distanceTo(customer);
            const jarakKm = jarakMeter / 1000;

            jarakGlobal = jarakKm;

            const ongkirPerKm = 3000;
            const ongkir = Math.round(jarakKm * ongkirPerKm);

            ongkirGlobal = ongkir;

            return ongkir;
        }

        function updateGrandTotalDenganOngkir(ongkir) {

            let totalLayanan = 0;

            for (let i = 0; i < rowIndex; i++) {
                const totalField = document.getElementById(`total_${i}`);
                if (!totalField) continue;

                const value = totalField.value.replace(/[^\d]/g,'');
                totalLayanan += parseInt(value || 0);
            }

            const grandTotal = totalLayanan + ongkir;

            document.getElementById('grand-total')
                .innerText = formatRupiah(grandTotal);

            document.getElementById('total_harga_input')
                .value = grandTotal;
            
            applyPromo();
        }

        function setCustomerMarker(lat, lng) {

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (customerMarker) {
                map.removeLayer(customerMarker);
            }

            customerMarker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);

            map.setView([lat, lng], 15);

            const ongkir = hitungOngkir(lat, lng);

            document.getElementById('ongkir_input').value = ongkir;

            updateGrandTotalDenganOngkir(ongkir);

            // AUTO ISI ALAMAT SAAT KLIK MAP
            reverseGeocode(lat, lng);

            customerMarker.on('dragend', function(e) {

                const pos = e.target.getLatLng();

                document.getElementById('latitude').value = pos.lat;
                document.getElementById('longitude').value = pos.lng;

                const ongkir = hitungOngkir(pos.lat, pos.lng);

                document.getElementById('ongkir_input').value = ongkir;

                updateGrandTotalDenganOngkir(ongkir);

                reverseGeocode(pos.lat, pos.lng);
            });
        }

        function reverseGeocode(lat, lng) {

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&accept-language=id`, {
                headers: {
                    'User-Agent': 'LaundioApp'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Gagal reverse geocode");
                }
                return response.json();
            })
            .then(data => {

                console.log("Reverse result:", data);

                if (data && data.display_name) {
                    document.getElementById('alamat').value = data.display_name;
                }

            })
            .catch(error => {
                console.log("Reverse error:", error);
            });
        }

        // Klik manual
        map.on('click', function (e) {
            setCustomerMarker(e.latlng.lat, e.latlng.lng);
        });

        // Auto geocode alamat
        const alamatInput = document.getElementById('alamat');
        let timer;

        alamatInput.addEventListener('input', function () {

            clearTimeout(timer);

            timer = setTimeout(() => {

                const alamat = alamatInput.value.trim();
                if (alamat.length < 5) return;

                fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(alamat)}`)
                .then(res => res.json())
                .then(data => {

                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        setCustomerMarker(lat, lon);
                    }

                }).catch(err => console.log(err));

            }, 1000);

        });

    });
</script>


<script>
    let diskonGlobal = 0;

    function applyPromo() {

        const select = document.getElementById('promo_select');
        const selected = select.selectedOptions[0];

        if (!selected || !selected.value) {
            diskonGlobal = 0;
            updateTotalFinal();
            return;
        }

        const basis = selected.dataset.basis;
        const nilai = parseInt(selected.dataset.nilai || 0);
        const minimal = parseInt(selected.dataset.minimal || 0);

        let total = parseInt(
            document.getElementById('total_harga_input').value || 0
        );

        // Cek minimal transaksi
        if (total < minimal) {
            diskonGlobal = 0;
            updateTotalFinal();
            return;
        }

        if (basis === "gratis_ongkir") {

            if (jarakGlobal < 1) {
                diskonGlobal = ongkirGlobal;
            } else {
                diskonGlobal = 0;
            }

        } else if (basis === "persentase") {

            diskonGlobal = Math.floor((nilai / 100) * total);

        } else { // nominal

            diskonGlobal = nilai;
        }

        updateTotalFinal();
    }

    function updateTotalFinal() {

        let total = parseInt(
            document.getElementById('total_harga_input').value || 0
        );

        let totalAkhir = total - diskonGlobal;

        if (totalAkhir < 0) totalAkhir = 0;

        document.getElementById('diskon_text')
            .innerText = formatRupiah(diskonGlobal);

        document.getElementById('grand-total')
            .innerText = formatRupiah(totalAkhir);

        document.getElementById('diskon_input')
            .value = diskonGlobal;
    }
</script>

{{-- Tutup Modal --}}
<script>
    function closeModal() {
        document.getElementById('successModal').style.display = 'none';
    }
</script>
<style>
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.4);
        display:flex;
        align-items:center;
        justify-content:center;
        z-index:9999;
    }
    .modal-box {
        background: #fff;
        padding: 32px;
        border-radius: 16px;
        width: 100%;
        max-width: 480px;   /* desktop */
        min-height: 260px;
        text-align: center;
    }
    .check-icon {
        font-size:48px;
        color:#22c55e;
    }
    .btn-primary {
        background:#22c55e;
        color:white;
        padding:10px 16px;
        border-radius:8px;
        text-decoration:none;
    }
    .btn-secondary {
        background:#e5e7eb;
        padding:10px 16px;
        border-radius:8px;
    }
    .card-section {
        background: #ffffff;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .section-title {
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 15px;
        color: #111827;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }

    .row textarea {
        grid-column: span 2;
    }

    .row-item {
        display: grid;
        grid-template-columns: 1.6fr 1fr 0.7fr 1fr auto;
        gap: 8px;
        align-items: center;
        margin-bottom: 8px;
    }

    .header-row {
        font-weight: 600;
        font-size: 13px;
        color: #6b7280;
    }

    input, select, textarea {
        padding: 9px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .btn-add {
        margin-top: 10px;
        background: #16a39a;
        color: white;
        padding: 8px 14px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
    }

    /* TOTAL LEBIH SOFT & GEN Z */
    .total-box {
        background: linear-gradient(135deg, #f0fdf4, #ecfeff);
        padding: 14px 18px;
        border-radius: 18px;
        font-size: 15px;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 20px 0;
        border: 1px solid #d1fae5;
    }

    #grand-total {
        font-size: 18px;
        font-weight: 700;
        color: #16a39a;
    }

    /* BUTTON PESAN LEBIH SLIM */
    .btn-submit {
        width: auto;
        padding: 10px 22px;
        border-radius: 999px;
        border: none;
        background: linear-gradient(135deg, #16a39a, #16a39a);
        color: white;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 6px 16px rgba(34,197,94,0.25);
    }

    /* Hover effect biar modern */
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(34,197,94,0.35);
    }

    .btn-remove {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fee2e2;
        border-radius: 10px;
        width: 32px;
        height: 32px;
        cursor: pointer;
        font-size: 14px;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-remove:hover {
        background: #dc2626;
        color: white;
        transform: scale(1.05);
    }
</style>

@endsection


