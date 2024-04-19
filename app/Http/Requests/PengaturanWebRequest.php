<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengaturanWebRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'keywords' => 'required|string',
            'longitude' => 'required|integer',
            'latitude' => 'required|integer',
            'alamat' => 'nullable',
            'helpdesk' => 'nullable',
            // 'icon' => 'nullable',
            // 'logo' => 'nullable',
            'fb' => 'nullable',
            'youtube' => 'nullable',
            'ig' => 'nullable',
            'email' => 'nullable',
            'twitter' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'nama' => 'nama website',
            'deskripsi' => 'deskripsi singkat',
            'keywords' => 'keyowrd website',
            'longitude' => 'longitude',
            'latitude' => 'latitude',
            // 'icon' => 'icon web',
            // 'logo' => 'logo web',
            'alamat' => 'alamat instansi',
            'helpdesk' => 'daftar nomor helpdesk',
            'fb' => 'akun facebook',
            'youtube' => 'channel youtube',
            'ig' => 'akun instagram',
            'email' => 'email resmi',
            'twitter' => 'akun twitter',
        ];
    }
}
