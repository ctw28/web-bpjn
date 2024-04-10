<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JenisKontenRequest extends FormRequest
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
            'deskripsi' => 'nullable',
            'kategori' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'pengguna',
            'nama' => 'nama jenis konten',
            'deskripsi' => 'deskripsi ',
            'kategori' => 'kategori KONTEN atau FILE',
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
