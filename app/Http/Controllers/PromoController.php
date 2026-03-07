<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();

        // Nonaktifkan promo yang sudah lewat tanggal selesai
        Promo::where('status', 'aktif')
            ->whereDate('tanggal_selesai', '<', $today)
            ->update([
                'status' => 'nonaktif'
            ]);

        $promos = Promo::orderByDesc('tanggal_mulai')->get();

        return view('manajemen.indexpromo', compact('promos'));
    }

    public function create(): View
    {
        return view('manajemen.createpromo');
    }

    public function store(Request $request)
    {
        // VALIDASI INPUT
        $validated = $request->validate([
            'nama_promo'            => 'required|string|max:255',
            'skema'                 => 'required|string|max:255',

            // BASIS PROMO
            'basis_promo'           => 'required|in:nominal,persentase',
            'nilai_promo'           => 'required|numeric|min:0',

            // STATUS & WAKTU
            'status'                => 'required|in:aktif,nonaktif',
            'tanggal_mulai'         => 'required|date',
            'tanggal_selesai'       => 'required|date|after_or_equal:tanggal_mulai',

            // OPSIONAL
            'minimal_transaksi'     => 'nullable|numeric|min:0',
            'maksimal_diskon'   => 'nullable|numeric|min:0',
            'kuota'             => 'nullable|numeric|min:1',

            'role_akses'        => 'required|in:admin,kasir,semua',
            'khusus_member'     => 'required|boolean',

            'deskripsi_promo'   => 'required|string',
            'target_diskon'     => 'required|in:produk,ongkir,pelayanan',
        ]);

        // SIMPAN DATA
        Promo::create([
            'nama_promo'        => $validated['nama_promo'],
            'skema'             => $validated['skema'],
            'basis_promo'       => $validated['basis_promo'],
            'nilai_promo'       => $validated['nilai_promo'],
            'minimal_transaksi' => $validated['minimal_transaksi'] ?? 0,
            'maksimal_diskon'   => $validated['maksimal_diskon'] ?? null,
            'kuota'             => $validated['kuota'] ?? null,
            'dipakai'           => 0,
            'role_akses'        => $validated['role_akses'],
            'khusus_member'     => $validated['khusus_member'],
            'status'            => $validated['status'],
            'tanggal_mulai'     => $validated['tanggal_mulai'],
            'tanggal_selesai'   => $validated['tanggal_selesai'],
            'deskripsi_promo'   => $validated['deskripsi_promo'],
            'target_diskon'    => $validated['target_diskon'],
        ]);

        return redirect()
            ->route('manajemen.indexpromo')
            ->with('success', 'Promo berhasil ditambahkan 🎉');
    }

    public function show($id): View
    {
        $promo = Promo::findOrFail($id);

        // 🔥 CEK STATUS PROMO
        if ($promo->status !== 'aktif') {
            return redirect()
                ->route('manajemen.indexpromo')
                ->with('error', 'Promo sudah tidak aktif');
        }

        return view('manajemen.showpromo', compact('promo'));
    }

    public function nonaktifkan($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->status = 'nonaktif';
        $promo->save();

        return redirect()
            ->route('manajemen.indexpromo')
            ->with('success', 'Promo berhasil dinonaktifkan');
    }

}
