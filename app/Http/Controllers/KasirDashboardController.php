<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Reservasi;
use App\Models\HistoryPemesanan;
use Carbon\Carbon;

class KasirDashboardController extends Controller
{
    public function index(Request $request)
    {
        $hariIni = Carbon::today();

        // 🔥 Ambil outlet sesuai user login
        $outletId = 3;

        // ================= TOTAL PESANAN HARI INI =================
        $totalPemesanan = Pemesanan::where('id_outlet', $outletId)
            ->whereDate('tanggal_masuk', $hariIni)
            ->count();

        $totalReservasi = Reservasi::where('id_outlet', $outletId)
            ->whereDate('tanggal_jemput', $hariIni)
            ->count();

        $totalPesanan = $totalPemesanan + $totalReservasi;

        $totalTransaksiPemesanan = Pemesanan::where('id_outlet', $outletId)
            ->whereDate('tanggal_masuk', $hariIni)
            ->where('status_bayar', 'lunas')
            ->sum('total_harga');

        $totalTransaksiReservasi = Reservasi::where('id_outlet', $outletId)
            ->whereDate('tanggal_jemput', $hariIni)
            ->where('status_bayar', 'lunas')
            ->sum('total_harga');

        $totalTransaksi = $totalTransaksiPemesanan + $totalTransaksiReservasi;

        $belumDibayar =
            Pemesanan::where('id_outlet', $outletId)
                ->whereDate('tanggal_masuk', $hariIni)
                ->where('status_bayar', 'belum')
                ->count()
            +
            Reservasi::where('id_outlet', $outletId)
                ->whereDate('tanggal_jemput', $hariIni)
                ->where('status_bayar', 'belum')
                ->count();

        // ================= PESANAN SELESAI =================
        $pesananSelesai =
            HistoryPemesanan::whereDate('created_at', $hariIni)
                ->count();

        // ================= FILTER STATUS =================
        $status = $request->status;

        $statusDefault = [
            'diterima',
            'dicuci',
            'dikeringkan',
            'disetrika'
        ];
        if ($status == 'selesai') {

        // 🔥 Ambil dari HISTORY
        $antrianPesanan = HistoryPemesanan::with('pemesanan.customer')
            ->whereDate('created_at', $hariIni)
            ->get();

        } else {

        // ================= ANTRIAN PEMESANAN =================
        $queryPemesanan = Pemesanan::with('customer')
            ->where('id_outlet', $outletId);

        if ($status) {
            $queryPemesanan->where('status_proses', $status);
        } else {
            $queryPemesanan->whereIn('status_proses', $statusDefault);
        }

        $antrianPemesanan = $queryPemesanan
            ->orderBy('created_at', 'asc')
            ->get();

        // ================= ANTRIAN RESERVASI =================
        $queryReservasi = Reservasi::with('customer')
            ->where('id_outlet', $outletId);

        if ($status) {
            $queryReservasi->where('status_proses', $status);
        } else {
            $queryReservasi->whereIn('status_proses', $statusDefault);
        }

        $antrianReservasi = $queryReservasi
            ->orderBy('created_at', 'asc')
            ->get();

        $antrianPesanan = $antrianPemesanan
            ->merge($antrianReservasi)
            ->sortBy('created_at');
        }

        // Label tipe
        if ($status == 'selesai') {

            $antrianPesanan = HistoryPemesanan::with('pemesanan.customer')
                ->whereDate('created_at', $hariIni)
                ->get();

        } else {

            // ================= PEMESANAN =================
            $antrianPemesanan->map(function ($item) {
                $item->tipe = 'Pemesanan';
                return $item;
            });

            // ================= RESERVASI =================
            $antrianReservasi->map(function ($item) {
                $item->tipe = 'Reservasi';
                return $item;
            });

            $antrianPesanan = $antrianPemesanan
                ->merge($antrianReservasi)
                ->sortBy('created_at');
        }

        // ================= STATUS COUNTS =================
        $statusCounts = [];
        $allStatuses = ['diterima','dicuci','dikeringkan','disetrika','selesai'];

        foreach ($allStatuses as $s) {

            if ($s == 'selesai') {
                $statusCounts[$s] =
                    HistoryPemesanan::whereDate('created_at', $hariIni)
                        ->count();
            } else {
                $statusCounts[$s] =
                    Pemesanan::where('id_outlet', $outletId)
                        ->where('status_proses', $s)->count()
                    +
                    Reservasi::where('id_outlet', $outletId)
                        ->where('status_proses', $s)->count();
            }
        }

        return view('kasir.dashboard', compact(
            'totalPesanan',
            'totalTransaksi',
            'belumDibayar',
            'pesananSelesai',
            'antrianPesanan',
            'statusCounts'
        ));
    }

    public function showPemesanan($id)
    {
        $data = Pemesanan::with(['customer','outlet'])
            ->findOrFail($id);

        return view('kasir.detail_pemesanan', compact('data'));
    }

    public function showReservasi($id)
    {
        $data = Reservasi::with(['customer'])
            ->findOrFail($id);

        return view('kasir.detail_reservasi', compact('data'));
    }

}
