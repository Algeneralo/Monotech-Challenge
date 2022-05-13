<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function rules()
    {
        return [
            'firstname' => [
                'required',
                'string',
                'max:255',
            ],
            'lastname'  => [
                'required',
                'string',
                'max:255',
            ],
            'email'     => [
                'required',
                'unique:users,email',
            ],
            'username'  => [
                'required',
                'unique:users,username',
            ],
            'password'  => [
                'required',
                'between:6,18',
            ],
        ];
    }
}
