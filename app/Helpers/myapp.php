<?php

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

if (!function_exists('getUserIdFromToken')) {
    function getUserIdFromToken()
    {
        try {
            $user = Auth::guard('sanctum')->user();
            if ($user) {
                return $user->id;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }
}

if (!function_exists('daftarAkses')) {
    function daftarAkses($user_id)
    {
        return User::with(['aturgrup.grup'])->where('id', $user_id)->firstOrFail();
    }
}

if (!function_exists('is_admin')) {
    function is_admin($user_id)
    {
        try {
            $akses = daftarAkses($user_id);
            $isAdmin = $akses->aturgrup->contains('grup_id', 1);
            return $isAdmin;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('getUserIdFromToken')) {
    function getUserIdFromToken()
    {
        try {
            $user = Auth::guard('sanctum')->user();
            if ($user) {
                return $user->id;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }
}

if (!function_exists('anchor')) {
    function anchor($url, $text)
    {
        return '<a href="' . $url . '">' . $text . '</a>';
    }
}

if (!function_exists('dbDateTimeFormat')) {
    function dbDateTimeFormat($waktuDb, $format = 'Y-m-d H:i:s')
    {
        return Carbon::parse($waktuDb)->timezone('Asia/Makassar')->format($format);
    }
}

if (!function_exists('generateUniqueFileName')) {
    function generateUniqueFileName()
    {
        return $randomString = time() . Str::random(22);
    }
}

if (!function_exists('uploadFile')) {
    function generateSlug($judul, $waktu)
    {
        $disallowed_chars = array(
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '=', '{', '}', '[', ']', '|', '\\', ';', ':', '"', '<', '>', ',', '.', '/', '?',
            ' ', "'", ' '
        );
        $judul = str_replace(' ', '-', $judul);
        $judul = str_replace($disallowed_chars, ' ', $judul);
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $judul));

        $timestamp = strtotime($waktu);

        $tgl = date('y', $timestamp) + date('j', $timestamp) + date('n', $timestamp) + date('w', $timestamp);
        $waktu = date('H', $timestamp) + date('i', $timestamp);
        // $tanggal = date('ymd', strtotime($waktu));
        // $waktu = date('his', strtotime($waktu));
        // $tanggal = date('ymd', strtotime($waktu));
        // $waktu = date('his', strtotime($waktu));

        $generateWaktu = ($tgl + $waktu + rand(1, 999)) . '-' . date('s', $timestamp);
        // $finalSlug = date('ymd', $timestamp) . '-' . $slug . '-' . $generateWaktu;
        $finalSlug = $slug . '-' . $generateWaktu;
        return $finalSlug;
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($request, $storagePath = null, $fileName = null)
    {
        $uploadedFile = $request->file('file');
        $originalFileName = $uploadedFile->getClientOriginalName();
        $ukuranFile = $uploadedFile->getSize();
        $tipeFile = $uploadedFile->getMimeType();
        if (!$storagePath)
            $storagePath = 'uploads/' . date('Y') . '/' . date('m');

        if (!File::isDirectory(public_path($storagePath))) {
            File::makeDirectory(public_path($storagePath), 0755, true);
        }

        if (!$fileName)
            $fileName = generateUniqueFileName();

        $fileName = $fileName . "." . $uploadedFile->getClientOriginalExtension();


        $uploadedFile->move(public_path($storagePath), $fileName);
        $fileFullPath = public_path($storagePath . '/' . $fileName);
        chmod($fileFullPath, 0755);
        $path = $storagePath . '/' . $fileName;
        return $path;
    }
}

if (!function_exists('ambilKata')) {
    function ambilKata($text, $limit = 25)
    {
        $words = preg_split("/[\s,]+/", $text);
        $shortenedText = implode(' ', array_slice($words, 0, $limit));
        if (str_word_count($text) > $limit) {
            $shortenedText .= '...';
        }
        return $shortenedText;
    }
}
