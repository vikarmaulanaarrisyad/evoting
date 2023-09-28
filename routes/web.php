<?php

use App\Http\Controllers\{
    DashboardController,
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
        // Pemilih
        Route::get('voters/data', [VoterController::class, 'data'])->name('voters.data');
        Route::resource('voters', VoterController::class);
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
