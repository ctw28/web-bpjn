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
            'alamat' => 'nullable',
            'helpdesk' => 'nullable',
            'icon' => 'nullable',
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
            'icon' => 'icon web',
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
