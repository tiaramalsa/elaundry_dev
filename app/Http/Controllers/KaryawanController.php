<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KaryawanController extends Controller
{
    /**
     * Tampilkan data karyawan
     */
    public function index()
    {
        $karyawans = Karyawan::with('outlet')->latest()->get();
        return view('karyawan.index', compact('karyawans'));
    }

    /**
     * Form tambah karyawan
     */
    public function create()
    {
        $outlets = Outlet::all(); // ambil semua outlet
        return view('karyawan.create', compact('outlets'));
    }

    /**
     * Simpan data karyawan
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'nik'           => 'required|unique:karyawan,nik',
            'jabatan'       => 'required|string|max:100',
            'status'        => 'required|in:Aktif,Tidak Aktif',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'no_hp'         => 'required',
            'email'         => 'required|email',
            'alamat' => 'nullable|string',
            'tempat_lahir'  => 'required|string|max:255',  // baru
            'agama'         => 'required|string|max:50',   // baru
            'id_outlet' => 'required|exists:outlet,id_outlet',
        ]);

        Karyawan::create([
            // AMBIL USER LOGIN
            'id_user'       => Auth::id(),

            // SEMENTARA (NANTI BISA DIGANTI DINAMIS)
            'id_outlet' => $request->id_outlet,

            'nama_karyawan'  => $request->nama_karyawan,
            'nik'            => $request->nik,
            'status'         => $request->status,
            'alamat'         => $request->alamat ?? '-',
            'jabatan'        => $request->jabatan,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'agama'          => $request->agama,
            'no_hp'          => $request->no_hp,
            'email'          => $request->email,
        ]);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan');
    }

    /**
     * Detail karyawan
     */
    public function show($id)
    {
        $karyawan = Karyawan::with('user', 'outlet')->findOrFail($id);
        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Form edit karyawan
     */
    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $outlets = Outlet::all();

        return view('karyawan.edit', compact('karyawan','outlets'));
    }

    /**
     * Update data karyawan
     */
    public function update(Request $request, $id)
{
    $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'nik'           => 'required|unique:karyawan,nik,' . $id . ',id_karyawan',
            'jabatan'       => 'required|string|max:100',
            'status'        => 'required|in:Aktif,Tidak Aktif',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'no_hp'         => 'required',
            'email'         => 'required|email',
            'id_outlet'     => 'required|exists:outlet,id_outlet',
            'tempat_lahir' => 'required|string|max:255',
            'agama' => 'required|string|max:50',
        ]);

        $karyawan->update([
            'nama_karyawan' => $request->nama_karyawan,
            'nik'           => $request->nik,
            'status' => $request->status,
            'alamat'        => $request->alamat ?? '-',
            'jabatan'       => $request->jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama'         => $request->agama,         // baru
            'tempat_lahir'  => $request->tempat_lahir,  // baru
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_masuk' => $request->tanggal_masuk,
            'no_hp'         => $request->no_hp,
            'email'         => $request->email,
            'id_outlet' => $request->id_outlet,
        ]);

    return redirect()
        ->route('karyawan.index')
        ->with('success', 'Data karyawan berhasil diperbarui');
}

    /**
     * Hapus karyawan
     */
    public function destroy($id)
    {
        Karyawan::findOrFail($id)->delete();

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus');
    }

    /**
     * Export data karyawan ke PDF
     */
    public function exportPdf()
    {
        $karyawans = Karyawan::with('outlet')->latest()->get();

        $pdf = Pdf::loadView('karyawan.export-pdf', compact('karyawans'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('data-karyawan.pdf');
    }

    /**
     * Export data karyawan ke CSV
     */
    public function exportCsv()
    {
        $fileName = 'data-karyawan.csv';

        $karyawans = Karyawan::with('outlet')->get();

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($karyawans) {
            $file = fopen('php://output', 'w');

            // HEADER CSV
            fputcsv($file, [
                'ID',
                'Nama',
                'NIK',
                'Jenis Kelamin',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Agama',
                'Jabatan',
                'Status',
                'No HP',
                'Email'
            ]);

            // DATA CSV
            foreach ($karyawans as $karyawan) {
                fputcsv($file, [
                    $karyawan->id_karyawan,
                    $karyawan->nama_karyawan,
                    $karyawan->nik,
                    $karyawan->jenis_kelamin,
                    $karyawan->tempat_lahir,
                    $karyawan->tanggal_lahir,
                    $karyawan->agama,
                    $karyawan->jabatan,
                    $karyawan->status,
                    $karyawan->no_hp,
                    $karyawan->email,
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

}
