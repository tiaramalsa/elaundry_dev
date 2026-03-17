<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;

class KurirController extends Controller
{
    public function index()
    {
        return view('kurir.dashboard');
    }

    public function tugas()
    {
        // 📥 Pickup (ambil laundry)
        $pickup = \App\Models\Pemesanan::where('jenis_pengambilan', 'pickup_kurir')
            ->where('status_proses', 'menunggu_pickup')
            ->get();

        // 📦 Delivery (antar laundry)
        $delivery = \App\Models\Pemesanan::where('jenis_pengambilan', 'pickup_kurir')
            ->where('status_proses', 'siap_antar')
            ->get();

        return view('kurir.tugas.index', compact('pickup', 'delivery'));
    }

    public function ambil($id)
    {
        $data = Pemesanan::findOrFail($id);

        $data->update([
            'status_proses' => 'sudah_diambil'
        ]);

        return back()->with('success', 'Laundry berhasil diambil');
    }

    public function antar($id)
    {
        $data = Pemesanan::findOrFail($id);

        $data->update([
            'status_proses' => 'selesai'
        ]);

        return back();
    }
}
