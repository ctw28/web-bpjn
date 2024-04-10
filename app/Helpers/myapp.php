<?php

use Illuminate\Support\Facades\File;
use Carbon\Carbon;

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
    function uploadFile($request, $fileName = null)
    {
        $uploadedFile = $request->file('file');
        $originalFileName = $uploadedFile->getClientOriginalName();
        $ukuranFile = $uploadedFile->getSize();
        $tipeFile = $uploadedFile->getMimeType();
        $storagePath = 'uploads';

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
