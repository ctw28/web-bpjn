<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAppController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WebAppController::class, 'login']); // sementara menunggu halaman depan selesai

Route::get('/login', [WebAppController::class, 'login'])->name('login');
Route::post('/set-session', [WebAppController::class, 'setSession'])->name('setSession')->middleware('guest');
Route::get('/session', [WebAppController::class, 'session'])->name('session');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/web-logout', [WebAppController::class, 'logout']);
    Route::get('/dashboard', [WebAppController::class, 'dashboard'])->name('dashboard');
    Route::get('/jenis-konten', [WebAppController::class, 'jenisKonten'])->name('jenis-konten');
    Route::get('/grup', [WebAppController::class, 'grup'])->name('grup');
    Route::get('/pengaturan-web', [WebAppController::class, 'pengaturanWeb'])->name('pengaturan-web');
    Route::get('/akun', [WebAppController::class, 'akun'])->name('akun');
    Route::get('/menu', [WebAppController::class, 'menu'])->name('menu');
    Route::get('/konten-web', [WebAppController::class, 'kontenWeb'])->name('konten-web');
    Route::get('/file-web', [WebAppController::class, 'fileWeb'])->name('file-web');
    Route::get('/verifikasi-konten', [WebAppController::class, 'verifikasiKonten'])->name('verifikasi-konten');
    Route::get('/verifikasi-file', [WebAppController::class, 'verifikasiFile'])->name('verifikasi-file');
    Route::get('/verifikasi-komentar', [WebAppController::class, 'verifikasiKomentar'])->name('verifikasi-komentar');
});
