<?php

use App\Http\Controllers\{
    DashboardController,
    PemilihanController,
    VoterController,
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
        Route::resource('pemilihan', PemilihanController::class);
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
