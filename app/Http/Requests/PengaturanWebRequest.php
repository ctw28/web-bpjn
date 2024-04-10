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
            'user_id' => 'nullable',
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
            'user_id' => 'pengguna',
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

    // set nilai user_id
    public function withValidator($validator)
    {
        $data['user_id'] = 1;
        // $data['user_id'] = auth()->user()->id;
        $this->merge($data);
    }
}
