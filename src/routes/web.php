<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MstPangkatController;
use App\Http\Controllers\MstJabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RiwayatPangkatController;
use App\Http\Controllers\GajiController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::resource('mst-pangkat', MstPangkatController::class);
Route::resource('mst-jabatan', MstJabatanController::class);
Route::resource('pegawai', PegawaiController::class);

# Riwayat Pangkat
Route::get('/riwayat-pangkat',[RiwayatPangkatController::class, 'index']);
Route::get('/riwayat-pangkat/proses/{id}',[RiwayatPangkatController::class, 'proses'])
    ->name('riwayat-pangkat.index1');
Route::get('/riwayat-pangkat/cetak/{id}',[RiwayatPangkatController::class, 'cetak'])
    ->name('riwayat-pangkat.cetak');
Route::get('/riwayat-pangkat/create/{id}',[RiwayatPangkatController::class, 'create']);
Route::post('/riwayat-pangkat/store',[RiwayatPangkatController::class, 'store'])
    ->name('riwayat-pangkat.store');
Route::get('/riwayat-pangkat/{id}/edit',[RiwayatPangkatController::class, 'edit'])
    ->name('riwayat-pangkat.edit');
Route::patch('/riwayat-pangkat/update/{id}',[RiwayatPangkatController::class, 'update'])
    ->name('riwayat-pangkat.update');
Route::get('/riwayat-pangkat/show/{id}',[RiwayatPangkatController::class, 'show'])
    ->name('riwayat-pangkat.show');
Route::delete('/riwayat-pangkat/destroy/{id}',[RiwayatPangkatController::class, 'destroy'])
    ->name('riwayat-pangkat.destroy');

# Gaji
Route::get('/gaji',[GajiController::class, 'index']);
Route::get('/gaji/create',[GajiController::class, 'create']);
Route::post('/gaji/store',[GajiController::class, 'store'])
    ->name('gaji.store');
Route::get('/gaji/show/{id}',[GajiController::class, 'show'])
    ->name('gaji.show');
