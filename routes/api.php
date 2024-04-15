<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GrupController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\AturGrupController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\ImageEditorController;
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

Route::post('/auth-cek', [AuthController::class, 'index']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/info-web', [PengaturanWebController::class, 'index']);
Route::get('/load-menu-tree', [MenuController::class, 'getMenu']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/upload-image-editor', [ImageEditorController::class, 'upload']);
    Route::resource('jenis-konten', JenisKontenController::class);
    Route::resource('grup', GrupController::class);
    Route::resource('pengaturan-web', PengaturanWebController::class);
    Route::resource('akun', AkunController::class);
    Route::resource('atur-grup', AturGrupController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('konten', KontenController::class);
    Route::resource('file', FileController::class);
    Route::resource('publikasi', PublikasiController::class);
    Route::resource('komentar', KomentarController::class);
});
