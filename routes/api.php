<?php

use App\Models\JenisKonten;
use Illuminate\Http\Request;
use App\Models\PengaturanWeb;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\GrupController;
use App\Http\Controllers\AturGrupController;
use App\Http\Controllers\JenisKontenController;
use App\Http\Controllers\PengaturanWebController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'index']);

// Route::middleware('auth:sanctum')->group(function () {
Route::resource('jenis-konten', JenisKontenController::class);
Route::resource('grup', GrupController::class);
Route::resource('pengaturan-web', PengaturanWebController::class);
Route::resource('akun', AkunController::class);
Route::resource('atur-grup', AturGrupController::class);
// });
