<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Reservasi;
use App\Models\Customer;
use App\Models\Harga;

class ReservasiController extends Controller
{
    public function create(): View
    {
        $hargaList = Harga::laundry()->get()->keyBy('kode_layanan');

        return view('reservasi.create', [
            'hargaList' => $hargaList
        ]);
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

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


   public function store(Request $request)
    {

        $validated = validator($request->all(), [
            'nama_lengkap'    => 'required|string|max:100',
            'no_telp'         => 'required|string|max:20',
            'alamat_jemput'   => 'required|string',
            'lokasi'          => 'nullable|url',
            'jenis_layanan'   => 'required|string',
            // 'tipe_pemesanan'  => 'required|string',
            'tanggal_jemput'  => 'required|date',
            'jam_jemput'      => 'required',
            'jumlah_item'     => 'nullable|integer|min:1',
            'berat_cucian'    => 'nullable|numeric|min:0.1',
            'catatan_khusus'  => 'nullable|string',
            'status_proses'   => 'in:diterima,dicuci,dikeringkan,disetrika,selesai',
            'status_bayar'    => 'in:belum,lunas',
            'latitude'        => 'required|numeric',
            'longitude'       => 'required|numeric',

        ])->validate();

        $customer = Customer::firstOrCreate(
            ['no_telp' => $validated['no_telp']],
            [
                'nama_lengkap' => $validated['nama_lengkap'],
                'alamat'       => $validated['alamat_jemput'],
            ]
        );

        // ==============================
        // HITUNG TOTAL HARGA (SAMA DENGAN PEMESANAN)
        // ==============================
        $layananDipilih = explode(',', $validated['jenis_layanan']);

        $berat  = (float) ($validated['berat_cucian'] ?? 0);
        $jumlah = (int) ($validated['jumlah_item'] ?? 0);

        $totalHarga = 0;

        foreach ($layananDipilih as $kode) {
            $harga = Harga::where('kode_layanan', $kode)
                ->where('is_active', true)
                ->first();

            if (!$harga) continue;

            // ❗ RESERVASI: HANYA PCS
            if ($harga->satuan === 'pcs' && $jumlah > 0) {
                $totalHarga += $harga->harga * $jumlah;
            }
        }

        // ==============================
        // HITUNG ONGKIR BERDASARKAN JARAK
        // ==============================

        $outlet = \App\Models\Outlet::find(3); // sementara outlet 3

        $jarak = $this->hitungJarak(
            $outlet->latitude,
            $outlet->longitude,
            $request->latitude,
            $request->longitude
        );

        $tarifPerKm = 3000; // misal 3000 per km
        $ongkir = ceil($jarak) * $tarifPerKm;

        // total akhir
        $totalFinal = $totalHarga + $ongkir;


        // ==============================
        // SIMPAN RESERVASI
        // ==============================
        $reservasi = Reservasi::create([
            'id_cust'        => $customer->id_cust,
            'id_outlet'      => 3,
            'jenis_layanan'  => $validated['jenis_layanan'],
            'tipe_pemesanan' => 'reservasi',
            'tanggal_jemput' => $validated['tanggal_jemput'],
            'jam_jemput'     => $validated['jam_jemput'],
            'alamat_jemput'  => $validated['alamat_jemput'],
            'latitude'       => $validated['latitude'],
            'longitude'      => $validated['longitude'],
            'jarak_km'       => $jarak ?? null,
            'jumlah_item'    => $jumlah ?: null,
            'total_harga'    => $totalFinal,
            'ongkir'         => $ongkir,
            'catatan_khusus' => $validated['catatan_khusus'] ?? null,
            'status_proses'  => 'diterima',
            'status_bayar'   => 'belum',
        ]);


        return response()->json([
            'success' => true,
            'id' => $reservasi->id_reservasi
        ], 200);

    }

    public function nota($id)
    {
        $reservasi = Reservasi::with(['customer','outlet'])->findOrFail($id);

        return view('reservasi.nota', compact('reservasi'));
    }

    // public function next(Request $request, $id)
    // {
    //     $source = $request->source;

    //     if ($source === 'pemesanan') {

    //         $data = Pemesanan::findOrFail($id);

    //     } else {

    //         $data = Reservasi::findOrFail($id);

    //     }

    //     $next = match ($data->status_proses) {
    //         'diterima'    => 'dicuci',
    //         'dicuci'      => 'dikeringkan',
    //         'dikeringkan' => 'disetrika',
    //         'disetrika'   => 'selesai',
    //         default       => null,
    //     };

    //     if (!$next) {
    //         return back();
    //     }

    //     $data->update([
    //         'status_proses' => $next,
    //     ]);

    //     return back();
    // }



}
