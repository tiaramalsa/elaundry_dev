<?php

namespace App\Http\Controllers;

use App\Models\Cetak;
use Illuminate\Http\Request;

class PengaturanCetakController extends Controller
{
    public function index()
    {
        $data = Cetak::latest()->get();
        return view('cetak.index', compact('data'));
    }

    public function create()
    {
        $data = null;
        return view('cetak.create', compact('data'));
    }

    public function edit($id)
    {
        $data = Cetak::findOrFail($id);

        return view('cetak.create', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $cetak = Cetak::findOrFail($id);

        $cetak->update([
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'footer' => $request->footer,
            'jam_buka' => $request->jam_mulai . ' - ' . $request->jam_tutup,
            'tipe_kertas' => $request->tipe_kertas,
            'custom_width' => $request->custom_width,
            'show_logo' => $request->has('show_logo') ? 1 : 0,
            'show_maps' => $request->has('show_maps') ? 1 : 0,
        ]);

        return redirect()->route('cetak.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function store(Request $request)
    {
        Cetak::create([
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'footer' => $request->footer,
            'jam_buka' => $request->jam_mulai . ' - ' . $request->jam_tutup,
            'tipe_kertas' => $request->tipe_kertas,
            'custom_width' => $request->custom_width,
            'show_logo' => $request->has('show_logo') ? 1 : 0,
            'show_maps' => $request->has('show_maps') ? 1 : 0,
            'status' => 1,
        ]);

        return redirect()->route('cetak.index')
            ->with('success','Berhasil disimpan');
    }

    public function toggle($id)
    {
        $cetak = Cetak::findOrFail($id);

        $cetak->update([
            'status' => !$cetak->status
        ]);

        return back();
    }

    public function show($id)
    {
        $data = Cetak::findOrFail($id);

        return view('cetak.show', compact('data'));
    }
}
