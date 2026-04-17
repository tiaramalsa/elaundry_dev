<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::all();
        return view('outlet.index', compact('outlets'));
    }

    public function create()
    {
        return view('outlet.create');
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
            'nama_outlet' => 'required',
            'jalan' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kota_kab' => 'required',
            'provinsi' => 'required',
            'no_telp' => 'required',
            'kode_pos' => 'required',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'latitude' => 'required',
            'longitude' => 'required',
            ]);

            try {
            Outlet::create($validated);

            return redirect()
                ->route('outlet.index')
                ->with('success', 'Outlet berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Outlet gagal ditambahkan');
        }
    }

    public function show($id)
    {
        $outlet = Outlet::findOrFail($id);
        return view('outlet.show', compact('outlet'));
    }

    public function edit($id)
    {
        $outlet = Outlet::findOrFail($id);
        return view('outlet.edit', compact('outlet'));
    }

    public function update(Request $request, $id)
    {
        $outlet = Outlet::findOrFail($id);

        $outlet->update($request->only([
            'nama_outlet','jalan','kelurahan','kecamatan','kota_kab',
            'provinsi','kode_pos','email','no_telp','website',
            'latitude','longitude'
        ]));

        return redirect()->route('outlet.show', $id)->with('success', 'Outlet berhasil diupdate');
    }

    public function destroy($id)
    {
        try {
            $outlet = Outlet::findOrFail($id);
            $outlet->delete();

            return redirect()
                ->route('outlet.index')
                ->with('success', 'Outlet berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('outlet.index')
                ->with('error', 'Outlet gagal dihapus');
        }
    }
}
