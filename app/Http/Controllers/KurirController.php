<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Kurir;
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

    public function profile()
    {
        $user = Auth::user();
        $kurir = $user->kurir;

        // Statistik (opsional, sesuaikan fieldmu)
        $totalDiantar = Pemesanan::where('kurir_id', $user->id)
                        ->where('status_proses','selesai')
                        ->count();

        $totalDiambil = Pemesanan::where('kurir_id', $user->id)
                        ->where('status_proses','diambil')
                        ->count();

        $orderHariIni = Pemesanan::where('kurir_id', $user->id)
                        ->whereDate('created_at', now())
                        ->count();

        return view('kurir.profile.index', compact(
            'user',
            'kurir',
            'totalDiantar',
            'totalDiambil',
            'orderHariIni'
        ));
    }

        public function editProfile()
        {
            $user = auth()->user();
            $kurir = $user->kurir;

            if (!$kurir) {
                $kurir = \App\Models\Kurir::create([
                    'user_id' => $user->id,
                    'id_kurir' => 'KURIR-' . rand(1000,9999)
                ]);
            }

            return view('kurir.profile.edit', compact('user','kurir'));
        }
            

        public function updateProfile(Request $request)
{
    $user = auth()->user();
    $kurir = $user->kurir;

    // VALIDASI
    $request->validate([
        'name' => 'required|string|max:255',
        'no_hp' => 'nullable|string|max:20',
        'alamat' => 'nullable|string',

        'id_kurir' => 'required|string|max:50',
        'status' => 'required|in:aktif,tidak_aktif',
        'bergabung_sejak' => 'nullable|date',
        'plat_nomor' => 'nullable|string|max:20',
        'jenis_kendaraan' => 'nullable|string|max:50',

        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // =========================
    // UPDATE USER
    // =========================
    $user->update([
        'name' => $request->name,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
    ]);

    // =========================
    // HANDLE FOTO
    // =========================
    if ($request->hasFile('foto')) {

        // hapus foto lama (biar ga numpuk)
        if ($kurir && $kurir->foto) {
            Storage::disk('public')->delete($kurir->foto);
        }

        $path = $request->file('foto')->store('kurir', 'public');

        $kurir->foto = $path;
    }

    // =========================
    // UPDATE DATA KURIR
    // =========================
    $kurir->update([
        'id_kurir' => $request->id_kurir,
        'status' => $request->status,
        'bergabung_sejak' => $request->bergabung_sejak,
        'plat_nomor' => $request->plat_nomor,
        'jenis_kendaraan' => $request->jenis_kendaraan,
        'foto' => $kurir->foto, // penting!
    ]);

    return redirect()->route('profile')
        ->with('success', 'Profile berhasil diupdate!');
}
}

