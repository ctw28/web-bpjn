<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AkunRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'user_id' => 'nullable',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'user_id' => 'akun penginput',
            'name' => 'nama akun',
            'email' => 'email akun',
            'password' => 'kata sandi',
        ];
    }
}
