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

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', [WebAppController::class, 'dashboard'])->name('dashboard');
Route::get('/jenis-konten', [WebAppController::class, 'jenisKonten'])->name('jenis-konten');
Route::get('/grup', [WebAppController::class, 'grup'])->name('grup');
Route::get('/pengaturan-web', [WebAppController::class, 'pengaturanWeb'])->name('pengaturan-web');
Route::get('/akun', [WebAppController::class, 'akun'])->name('akun');
Route::get('/menu', [WebAppController::class, 'menu'])->name('menu');
