<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\Pemesanan;
use App\Models\Reservasi;
use App\Models\Harga;
use App\Models\Outlet;



class LacakController extends Controller
{
    public function index(Request $request)
    {
        // Query Pemesanan
        $query = Pemesanan::with('customer')
            ->where('status_proses', '!=', 'selesai');

        if ($request->outlet_id) {
            $query->where('outlet_id', $request->outlet_id);
        }

        if ($request->status) {
            $query->where('status_proses', $request->status);
        }

        if ($request->from && $request->to) {
            $query->whereBetween('tanggal_masuk', [
                $request->from,
                $request->to
            ]);
        }

        $pemesanans = $query
        ->orderByDesc('tanggal_masuk')
        ->get()
        ->map(function ($p) {

            $p->source = 'pemesanan';

            if ($p->detail_layanan) {

                $detail = json_decode($p->detail_layanan, true);

                if (is_array($detail)) {

                    $namaLayanan = collect($detail)->map(function ($item) {
                        $layanan = Harga::where('kode_layanan', $item['kode_layanan'])->first();
                        return $layanan->nama_layanan ?? null;
                    })->filter()->implode(', ');

                    $p->jenis_layanan = $namaLayanan ?: '-';
                }
            }

            return $p;
        });

        // Query Reservasi
        $reservasis = Reservasi::with('customer')
            ->where('status_proses', '!=', 'selesai')
            ->when($request->outlet_id, fn($q) =>
                $q->where('outlet_id', $request->outlet_id)
            )
            ->when($request->status, fn($q) =>
                $q->where('status_proses', $request->status)
            )
            ->get()
            ->map(function ($r) {
                $r->tanggal_masuk = $r->tanggal_jemput;
                $r->no_order = 'RES-' . $r->id_reservasi;
                $r->tipe = 'Reservasi';
                $r->source = 'reservasi';
                return $r;
            });


        /*
        |--------------------------------------------------------------------------
        | 3️⃣ GABUNGKAN
        |--------------------------------------------------------------------------
        */
        $pemesanans = $pemesanans
            ->merge($reservasis)
            ->sortByDesc('tanggal_masuk')
            ->values();


        $tipe = $request->tipe_pemesanan;

        if ($tipe) {
            $pemesanans = $pemesanans->filter(function ($item) use ($tipe) {
                return $item->source === $tipe;
            });
        }

        /*
        |--------------------------------------------------------------------------
        | 4️⃣ DASHBOARD COUNT (GABUNG)
        |--------------------------------------------------------------------------
        */
        // Ambil semua untuk dashboard
        $allPemesanan = Pemesanan::when($request->outlet_id, fn($q) =>
                $q->where('outlet_id', $request->outlet_id)
            )
            ->get()
            ->map(function ($p) {
                $p->source = 'pemesanan';
                return $p;
            });

        $allReservasi = Reservasi::when($request->outlet_id, fn($q) =>
                $q->where('outlet_id', $request->outlet_id)
            )
            ->get()
            ->map(function ($r) {
                $r->tanggal_masuk = $r->tanggal_jemput;
                $r->no_order = 'RES-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
                $r->source = 'reservasi';
                return $r;
            });

        $allData = $allPemesanan->merge($allReservasi);

        $trackingCount = [
            'diterima'     => $allData->where('status_proses', 'diterima')->count(),
            'dicuci'       => $allData->where('status_proses', 'dicuci')->count(),
            'dikeringkan'  => $allData->where('status_proses', 'dikeringkan')->count(),
            'disetrika'    => $allData->where('status_proses', 'disetrika')->count(),
            'selesai'      => $allData->where('status_proses', 'selesai')->count(),
        ];

        $total = $trackingCount
            ? array_sum($trackingCount)
            : 0;

        $persen = [
            'diterima'     => $total ? round($trackingCount['diterima'] / $total * 100) : 0,
            'dicuci'       => $total ? round($trackingCount['dicuci'] / $total * 100) : 0,
            'dikeringkan'  => $total ? round($trackingCount['dikeringkan'] / $total * 100) : 0,
            'disetrika'    => $total ? round($trackingCount['disetrika'] / $total * 100) : 0,
            'selesai'      => $total ? round($trackingCount['selesai'] / $total * 100) : 0,
        ];

        if (auth()->user()->role === 'admin') {
            $outlets = Outlet::all();
        } else {
            $outlets = Outlet::where('id_outlet', auth()->user()->outlet_id)->get();
        }

        return view('lacak.index', compact('pemesanans', 'trackingCount', 'persen', 'outlets'));
    }


    public function next(Request $request, $id)
    {
        if ($request->source === 'pemesanan') {
            $data = Pemesanan::find($id);
        } else {
            $data = Reservasi::find($id);
        }

        if (!$data) {
            abort(404);
        }

        // ✅ KHUSUS FLOW KURIR (INI YANG DITAMBAH)
        if (
            $data->jenis_pengambilan === 'pickup_kurir' &&
            $data->status_proses === 'menunggu_pickup'
        ) {
            $data->update([
                'status_proses' => 'sudah_diambil'
            ]);

            return back()->with('success', 'Kurir berhasil ditugaskan');
        }

        // 🔥 FLOW NORMAL
        $next = match ($data->status_proses) {

            'sudah_diambil'   => 'diterima',

            'diterima'        => 'dicuci',
            'dicuci'          => 'dikeringkan',
            'dikeringkan'     => 'disetrika',
            'disetrika'       => 'siap_antar',
            'siap_antar'      => 'selesai',

            default => null,
        };

        if (!$next) {
            return back()->with('error', 'Status tidak bisa lanjut');
        }

        $data->update([
            'status_proses' => $next
        ]);

        return back()->with('success', 'Status berhasil diupdate');
    }
}
