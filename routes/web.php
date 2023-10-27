<?php

use App\Http\Controllers\{
    DashboardController,
    KelasController,
    PemilihanController,
    SiswaController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group([
    'middleware' => ['auth', 'role:admin,panitia,pemilih'],
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group([
        'middleware' => 'role:admin',
    ], function () {
        // Jadwal Pemilihan
        Route::get('pemilihan/data', [PemilihanController::class, 'data'])->name('pemilihan.data');
        Route::resource('pemilihan', PemilihanController::class)->except('edit', 'create');
        Route::put('pemilihan/{pemilihan}/update_status', [PemilihanController::class, 'updateStatus'])->name('pemilihan.update_status');

        // Kelas
        Route::get('kelas/data', [KelasController::class, 'data'])->name('kelas.data');
        Route::resource('kelas', KelasController::class)->except('edit', 'create');

        // Siswa
        Route::get('/siswa/data', [SiswaController::class, 'data'])->name('siswa.data');
        Route::resource('/siswa', SiswaController::class);
        Route::get('/siswa/export/excel', [SiswaController::class, 'exportExcel'])->name('siswa.export_excel');
        Route::post('/siswa/import-excel', [SiswaController::class, 'importExcel'])->name('siswa.import_excel');

        // Kandidat
    });

    Route::group([
        'middleware' => 'role:panitia',
    ], function () {
        //
    });

    Route::group([
        'middleware' => 'role:pemilih',
    ], function () {
        //
    });
});
