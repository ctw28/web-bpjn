<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function beranda()
    {
        return view('frontend.beranda');
    }
    public function konten($kategori, $slug)
    {
        return view('frontend.konten-read', compact('kategori', 'slug'));
    }
    public function kontenList($kategori)
    {
        return view('frontend.konten-web', compact('kategori'));
    }
    public function kontenListFile($kategori)
    {
        return view('frontend.konten-file', compact('kategori'));
    }
}
