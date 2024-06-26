<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAppController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\frontend\WebController;

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

Route::get('/', [WebController::class, 'beranda'])->name('beranda'); // sementara menunggu halaman depan selesai
Route::get('/konten/{kategori}/{slug}', [WebController::class, 'konten'])->name('konten'); // sementara menunggu halaman depan selesai
Route::get('/web/{kategori}', [WebController::class, 'kontenList'])->name('web'); // sementara menunggu halaman depan selesai
Route::get('/file/{kategori}', [WebController::class, 'kontenListFile'])->name('web.file'); // sementara menunggu halaman depan selesai

Route::get('/awal', [WebAppController::class, 'web'])->name('web.awal'); // sementara menunggu halaman depan selesai

Route::get('/login', [WebAppController::class, 'login'])->name('login')->middleware('guest');
Route::post('/set-session', [WebAppController::class, 'setSession'])->name('setSession')->middleware('guest');
Route::get('/session', [WebAppController::class, 'session'])->name('session');
Route::get('/kotak-saran-web', [WebAppController::class, 'kotakSaranWeb'])->name('kotak-saran-web');
Route::get('/konten-web/{kategori}', [WebAppController::class, 'kontenWeb'])->name('konten-web');
Route::get('/galeri-web', [WebAppController::class, 'galeriWeb'])->name('galeri-web');
Route::get('/file-web/{kategori}', [WebAppController::class, 'fileWeb'])->name('file-web');
Route::get('/konten-read/{slug}', [WebAppController::class, 'kontenRead'])->name('konten-read');
Route::get('/file-read/{slug}', [WebAppController::class, 'fileRead'])->name('file-read');
Route::get('/go/{slug}', [ShortLinkController::class, 'redirect']); //untuk short link

//route untuk akun yang sudah login, tanpa session
// Route::group(['middleware' => 'auth'], function () {
Route::get('/set-akses/{id}', [WebAppController::class, 'setAkses'])->name('setAkses');
Route::post('/web-logout', [WebAppController::class, 'logout']);
Route::get('/kotak-saran', [WebAppController::class, 'kotakSaran'])->name('kotak-saran');
Route::get('/short-link', [WebAppController::class, 'shortLink'])->name('short-link');
Route::get('/dashboard', [WebAppController::class, 'dashboard'])->name('dashboard');
Route::get('/jenis-konten', [WebAppController::class, 'jenisKonten'])->name('jenis-konten');
Route::get('/grup', [WebAppController::class, 'grup'])->name('grup');
Route::get('/pengaturan-web', [WebAppController::class, 'pengaturanWeb'])->name('pengaturan-web');
Route::get('/akun', [WebAppController::class, 'akun'])->name('akun');
Route::get('/menu', [WebAppController::class, 'menu'])->name('menu');
Route::get('/html-code', [WebAppController::class, 'htmlCode'])->name('html-code');
Route::get('/slide-show', [WebAppController::class, 'slideShow'])->name('slide-show');
Route::get('/konten-dashboard', [WebAppController::class, 'kontenDashboard'])->name('konten-dashboard');
Route::get('/galeri-dashboard', [WebAppController::class, 'galeriDashboard'])->name('galeri-dashboard');
Route::get('/file-dashboard', [WebAppController::class, 'fileDashboard'])->name('file-dashboard');
Route::get('/verifikasi-konten', [WebAppController::class, 'verifikasiKonten'])->name('verifikasi-konten');
Route::get('/verifikasi-file', [WebAppController::class, 'verifikasiFile'])->name('verifikasi-file');
Route::get('/verifikasi-galeri', [WebAppController::class, 'verifikasiGaleri'])->name('verifikasi-galeri');
Route::get('/verifikasi-komentar', [WebAppController::class, 'verifikasiKomentar'])->name('verifikasi-komentar');
// });