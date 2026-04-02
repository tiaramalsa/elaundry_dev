<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Harga;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with([
                'customer',
                'historyPemesanan' // 🔥 tambahkan ini
            ])
            ->where('status_proses', 'selesai');

        if ($request->filled('layanan')) {
            $query->where('jenis_layanan', $request->layanan);
        }

        if ($request->filled('from')) {
            $query->whereDate('tanggal_masuk', '>=', $request->from);
        }

        $pemesanans = $query
            ->orderByDesc('tanggal_masuk')
            ->get();

        // ✅ TAMBAHAN TOTAL
        $totalKeseluruhan = $pemesanans->sum('total_harga');

        $layanans = Harga::where('is_active', 1)
                ->orderBy('nama_layanan')
                ->get();

        return view('riwayat.index', compact('pemesanans','totalKeseluruhan','layanans'));
            }

    public function download($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // sementara dummy (nanti bisa PDF)
        return response()->json($pemesanan);
    }

    public function destroy($id)
    {
        Pemesanan::where('id_pemesanan', $id)->delete();

        return back()->with('success', 'Riwayat berhasil dihapus');
    }

}
