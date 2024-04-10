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
        ];

        if ($this->isMethod('post')) {
            $rules['email'] = 'required|email|unique:users';
            $rules['password'] = 'required|min:8';
        } elseif ($this->isMethod('put')) {
            $rules['email'] = 'required|email';
            $rules['password'] = 'nullable|min:8';
        }

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

    // set nilai user_id
    public function withValidator($validator)
    {
        $data['user_id'] = 1;
        // $data['user_id'] = auth()->user()->id;
        $this->merge($data);
    }
}
