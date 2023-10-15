<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MstPangkatController;
use App\Http\Controllers\MstJabatanController;
use App\Http\Controllers\PegawaiController;

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
