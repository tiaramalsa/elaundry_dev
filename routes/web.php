<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\LacakController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KasirDashboardController;

//AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// DASHBOARD
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/reservasi/{id}/next', [ReservasiController::class, 'next'])->name('reservasi.next');

        // Lacak
        Route::get('/lacak', [LacakController::class, 'index'])->name('lacak.index');
        Route::post('/lacak/{id}/next', [LacakController::class, 'next'])->name('lacak.next');

        // Riwayat
        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/{id}/download', [RiwayatController::class, 'download'])->name('riwayat.download');
        Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
    });

Route::middleware(['auth', 'role:kasir'])
    ->prefix('kasir')
    ->name('kasir.')
    ->group(function () {

        Route::get('/dashboard', [KasirDashboardController::class, 'index'])
            ->name('dashboard');

        // ✅ TAMBAHKAN DI SINI
        Route::get('/pemesanan/{id}', [KasirDashboardController::class, 'showPemesanan'])
            ->name('pemesanan.show');

        Route::get('/reservasi/{id}', [KasirDashboardController::class, 'showReservasi'])
            ->name('reservasi.show');

        Route::get('/riwayat', [RiwayatController::class, 'index'])
            ->name('riwayat.index');

        Route::get('/riwayat/{id}/download',[RiwayatController::class, 'download'])
            ->name('riwayat.download');

        Route::get('/lacak', [LacakController::class, 'index'])
            ->name('lacak.index');

        Route::post('/lacak/{id}/next', [LacakController::class, 'next'])
            ->name('lacak.next');
    });

// Route::get('/admin/dashboard', [DashboardController::class, 'index'])
//     ->name('admin.dashboard');

// Route::get('/kasir/dashboard', function () {
//     return view('kasir.dashboard'); // atau controller sendiri
// })->name('kasir.dashboard');

//RESERVASI
Route::prefix('reservasi')->name('reservasi.')->group(function () {
    Route::get('/', [ReservasiController::class, 'create'])->name('create');
    Route::post('/', [ReservasiController::class, 'store'])->name('store');
    Route::get('/{id}/nota', [ReservasiController::class, 'nota'])->name('nota');
    Route::post('/{id}/next', [ReservasiController::class, 'next'])->name('next');

});

//PEMESANAN
Route::prefix('pemesanan')->name('pemesanan.')->group(function () {
    Route::get('/', [PemesananController::class, 'index'])->name('index');
    Route::get('/create', [PemesananController::class, 'create'])->name('create');
    Route::post('/', [PemesananController::class, 'store'])->name('store');
    Route::get('/{id}', [PemesananController::class, 'show'])->name('show');
    Route::patch('/{id}/status', [PemesananController::class, 'updateStatus'])->name('updateStatus');
    Route::post('/estimasi', [PemesananController::class, 'estimasi'])->name('estimasi');

    Route::post('/pemesanan/estimasi', [PemesananController::class, 'estimasi']);
    Route::get('/{id}/nota', [PemesananController::class, 'nota'])->name('nota');

});

//LACAK PEMESANAN 
// Route::get('/lacak', [LacakController::class, 'index'])->name('lacak.index');
// Route::post('/lacak/{id}/next', [LacakController::class, 'next'])->name('lacak.next');
// Route::post('/lacak/{id}/update', [LacakController::class, 'updateStatus'])->name('lacak.update');

//RIWAYAT PEMESANAN
// Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

//MANAJEMEN PROMO
Route::prefix('manajemen')->name('manajemen.')->group(function () {
    Route::get('/', [PromoController::class, 'index'])->name('indexpromo');
    Route::get('/promo/create', [PromoController::class, 'create'])->name('createpromo');
    Route::post('/promo', [PromoController::class, 'store'])->name('storepromo');
    Route::get('/promo/{id}', [PromoController::class, 'show'])->name('showpromo');
    Route::post('/promo/{id}/nonaktifkan', [PromoController::class, 'nonaktifkan'])->name('promo.nonaktifkan');

});

// MANAJEMEN CUSTOMER
Route::prefix('manajemen/customer')->name('manajemen.customer.')->group(function () {

    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/', [CustomerController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('update');

    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
});

Route::prefix('manajemen/harga')->name('manajemen.harga.')->group(function () {
    Route::get('/', [HargaController::class, 'index'])->name('index');
    Route::get('/create', [HargaController::class, 'create'])->name('create');
    Route::post('/', [HargaController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [HargaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [HargaController::class, 'update'])->name('update');
    Route::delete('/{id}', [HargaController::class, 'destroy'])->name('destroy');
});

//MANAJEMEN USER 
Route::middleware(['auth', 'role:admin'])
    ->prefix('manajemen/user')
    ->name('manajemen.user.')
    ->group(function () {

        Route::get('/', [ManajemenUserController::class, 'index'])->name('index');
        Route::get('/create', [ManajemenUserController::class, 'create'])->name('create');
        Route::post('/', [ManajemenUserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [ManajemenUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [ManajemenUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [ManajemenUserController::class, 'destroy'])->name('destroy');
    });

//PENGATURAN OUTLET
Route::prefix('outlet')->group(function () {
    Route::get('/', [OutletController::class, 'index'])->name('outlet.index');

    Route::get('/create', [OutletController::class, 'create'])->name('outlet.create');
    Route::post('/', [OutletController::class, 'store'])->name('outlet.store');

    Route::get('/{id}/edit', [OutletController::class, 'edit'])->name('outlet.edit');
    Route::put('/{id}', [OutletController::class, 'update'])->name('outlet.update');
    Route::get('/{id}', [OutletController::class, 'show'])->name('outlet.show');
    Route::delete('/{id}', [OutletController::class, 'destroy'])->name('outlet.destroy');

});

// PENGATURAN KARYAWAN
Route::prefix('pengaturan/karyawan')->name('karyawan.')->group(function () {

    Route::get('/', [KaryawanController::class, 'index'])->name('index');
    Route::get('/create', [KaryawanController::class, 'create'])->name('create');
    Route::post('/', [KaryawanController::class, 'store'])->name('store');

    // 🔥 EXPORT (WAJIB DI ATAS /{id})
    Route::get('/export/pdf', [KaryawanController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/export/csv', [KaryawanController::class, 'exportCsv'])->name('export.csv');

    Route::get('/{id}', [KaryawanController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [KaryawanController::class, 'edit'])->name('edit');

    Route::put('/{id}', [KaryawanController::class, 'update'])->name('update');
    Route::delete('/{id}', [KaryawanController::class, 'destroy'])->name('destroy');
});



