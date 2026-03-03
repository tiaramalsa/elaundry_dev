<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Pemesanan;
use App\Models\HistoryPemesanan;
use App\Models\TrackPemesanan;
use App\Models\Harga;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        $query = Pemesanan::with('customer');

        if ($status === 'selesai') {
            $query->where('status_proses', 'selesai');
        }

        if ($status === 'proses') {
            $query->where('status_proses', '!=', 'selesai');
        }

        $pemesanans = $query->latest()->get();

        return view('pemesanan.index', compact('pemesanans', 'status'));
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'nama_lengkap'   => 'required|string|max:255',
                'no_telp'        => 'required|string|max:20',
                'alamat'         => 'required|string',
                'id_outlet'      => 'required|exists:outlet,id_outlet',
                'detail_layanan' => 'required',
                'latitude'       => 'required',
                'longitude'      => 'required',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $customer = Customer::firstOrCreate(
                ['no_telp' => $request->no_telp],
                [
                    'nama_lengkap' => $request->nama_lengkap,
                    'alamat'       => $request->alamat,
                ]
            );

            $customer->update([
                'alamat' => $request->alamat
            ]);

            $detail = json_decode($request->detail_layanan, true);

            if (!$detail || count($detail) == 0) {
                throw new \Exception("Detail layanan kosong");
            }

            $totalHarga = 0;

            foreach ($detail as $item) {

                $harga = Harga::where('kode_layanan', $item['kode_layanan'])
                    ->where('is_active', true)
                    ->first();

                if (!$harga) continue;

                $totalHarga += $harga->harga * $item['qty'];
            }

            $totalFinal = $totalHarga;

            $jarak = 0;
            $ongkir = 0;

            if ($request->latitude && $request->longitude) {

                $outlet = \App\Models\Outlet::find($request->id_outlet);

                if ($outlet && $outlet->latitude && $outlet->longitude) {

                    $jarak = $this->hitungJarak(
                        $outlet->latitude,
                        $outlet->longitude,
                        $request->latitude,
                        $request->longitude
                    );

                    $tarifPerKm = 2000; // ganti sesuai aturan kamu
                    $ongkir = round($jarak) * $tarifPerKm;

                    $totalFinal += $ongkir;
                }
            }

            $biayaPelayanan = 0;
            $diskon = 0;
            $idPromo = null;

            if ($request->id_promo) {

                $promo = Promo::find($request->id_promo);

                if (!$promo) {
                    throw new \Exception("Promo tidak ditemukan");
                }

                // cek minimal transaksi
                if ($promo->minimal_transaksi && $totalHarga < $promo->minimal_transaksi) {
                    throw new \Exception("Minimal transaksi belum terpenuhi");
                }

                // hitung diskon
                if ($promo->basis_promo === 'persentase') {
                    $diskon = ($promo->nilai_promo / 100) * $totalHarga;
                } else {
                    $diskon = $promo->nilai_promo;
                }

                $diskon = min($diskon, $totalHarga);

                $totalHarga -= $diskon;

                $idPromo = $promo->id_promo;
            }

            $totalAkhir = max(0, $totalHarga + $ongkir + $biayaPelayanan);

            $pemesanan = Pemesanan::create([
                'no_order'       => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
                'id_cust'        => $customer->id_cust,
                'id_outlet'      => $request->id_outlet,
                'jenis_layanan'  => 'multiple',
                'tanggal_masuk'  => now(),
                'total_harga'    => $totalFinal,
                'diskon'         => $diskon,
                'total_akhir'    => $totalAkhir,
                'id_promo'       => $idPromo,
                'jarak_km'       => $jarak,
                'ongkir'         => $ongkir,
                'latitude'       => $request->latitude,
                'longitude'      => $request->longitude,
                'catatan_khusus' => $request->catatan_khusus,
                'status_proses'  => 'diterima',
                'status_bayar'   => 'belum',
                'detail_layanan' => json_encode($detail),
            ]);

            $linkMaps = "https://www.google.com/maps?q={$request->latitude},{$request->longitude}";

            $customer->update([
                'alamat' => $request->alamat,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'id' => $pemesanan->id_pemesanan
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $hargaList = Harga::laundry()->get();

        $roleUser = auth()->user()->role;

        $promos = Promo::where('status', 'aktif')
            ->whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_selesai', '>=', now())
            ->where(function ($query) use ($roleUser) {
                $query->where('role_akses', $roleUser)
                    ->orWhere('role_akses', 'semua');
            })
            ->get();

        return view('pemesanan.create', compact('hargaList', 'promos'));
    }

    public function show($id)
    {
            $pemesanan = Pemesanan::with([
            'customer',
            'outlet',
            'pembayaran',
            'historyPemesanan',
            'trackPemesanan'
        ])->findOrFail($id);

        return view('pemesanan.show', compact('pemesanan'));
    }

    public function nota($id)
    {
        $pemesanan = Pemesanan::with(['customer','outlet','promo'])
            ->findOrFail($id);

        return view('pemesanan.nota', compact('pemesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        HistoryPemesanan::create([
            'id_pemesanan' => $id,
            'status' => $request->status,
            'jenis_layanan' => $pemesanan->jenis_layanan,
            'tipe_pemesanan' => $pemesanan->tipe_pemesanan,
        ]);

        $pemesanan->trackPemesanan()->update([
            'proses' => $request->status,
        ]);

        return response()->json(['message' => 'Status updated']);
    }

    public function estimasi(Request $request)
    {
        $layananDipilih = explode(',', $request->jenis_layanan);

        $berat  = (float) $request->berat_cucian;
        $jumlah = (int) $request->jumlah_item;

        $hargaKg  = 0;
        $hargaPcs = 0;

        foreach ($layananDipilih as $kode) {
            $harga = Harga::where('kode_layanan', $kode)
                ->where('is_active', true)
                ->first();

            if (!$harga) continue;

            if ($harga->satuan === 'kg') {
                $hargaKg += $harga->harga;
            }

            if ($harga->satuan === 'pcs') {
                $hargaPcs += $harga->harga;
            }
        }

        $total = 0;

        if ($berat > 0) {
            $total += $hargaKg * $berat;
        }

        if ($jumlah > 0) {
            $total += $hargaPcs * $jumlah;
        }

        return response()->json([
            'total' => $total,
            'formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
        ]);
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon/2) *
            sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }
}
