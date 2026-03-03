<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter;

        $customers = Customer::when($filter === 'member', function ($q) {
                $q->where('is_member', true);
            })
            ->when($filter === 'non', function ($q) {
                $q->where('is_member', false);
            })
            ->latest()
            ->get();

        return view('manajemen.customer.index', compact('customers', 'filter'));
    }

    /**
     * Form tambah customer
     */
    public function create()
    {
        return view('manajemen.customer.create');
    }

    /**
     * Simpan data customer
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat'       => 'required|string',
            'no_telp'      => 'required|string|max:20',
            'latitude'     => 'nullable|string',
            'longitude'    => 'nullable|string',
        ]);

        // SIMPAN & TANGKAP KE VARIABLE
        $customer = Customer::create([
            'nama_lengkap' => $request->nama_lengkap,
            'alamat'       => $request->alamat,
            'no_telp'      => $request->no_telp,
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
            'is_member'    => $request->has('is_member'),
        ]);

        // Jika member aktif
        if ($request->has('is_member')) {

            $customer->update([
                'member_since'  => now(),
                'member_code'   => 'MBR' . str_pad($customer->id_cust, 4, '0', STR_PAD_LEFT),
                'member_points' => 0,
            ]);
        }

        return redirect()
            ->route('manajemen.customer.index')
            ->with('success', 'Customer berhasil ditambahkan');
    }

    /**
     * Form edit customer
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('manajemen.customer.edit', compact('customer'));
    }

    /**
     * Update data customer
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat'       => 'required|string',
            'no_telp'      => 'required|string|max:20',
            'lokasi'       => 'nullable|string',
            'email'        => 'nullable|email',
        ]);

        // Update data utama
        $lokasi = $customer->lokasi; // default pakai lama

        if ($request->latitude && $request->longitude) {
            $lokasi = "https://www.google.com/maps?q={$request->latitude},{$request->longitude}";
        }
        $customer->update([
            'nama_lengkap' => $request->nama_lengkap,
            'alamat'       => $request->alamat,
            'no_telp'      => $request->no_telp,
            'lokasi'       => $lokasi,
            'email'        => $request->email,
            'is_member'    => $request->has('is_member'),
        ]);

        // 🔥 Kalau baru diaktifkan jadi member
        if ($request->has('is_member') && !$customer->member_code) {

            $customer->update([
                'member_since' => now(),
                'member_code'  => 'MBR' . str_pad($customer->id_cust, 4, '0', STR_PAD_LEFT),
                'member_points'=> 0,
            ]);
        }

        // 🔻 Kalau dimatikan dari member → non member
        if (!$request->has('is_member')) {
            $customer->update([
                'member_since' => null,
                'member_code'  => null,
                'member_points'=> 0,
            ]);
        }

        return redirect()
            ->route('manajemen.customer.index')
            ->with('success', 'Customer berhasil diperbarui');
    }

    /**
     * Hapus customer
     */
    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();

        return redirect()
            ->route('manajemen.customer.index')
            ->with('success', 'Customer berhasil dihapus');
    }
}
