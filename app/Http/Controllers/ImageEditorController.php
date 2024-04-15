<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ImageEditorController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $storagePath = 'editor/images/' . date('Y') . '/' . date('m');
        $path = uploadFile($request, $storagePath);

        return response()->json(['success' => 'Image uploaded successfully.', 'image' => $path]);
    }
}
