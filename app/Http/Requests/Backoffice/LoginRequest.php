<?php

namespace App\Http\Requests\Backoffice;

use App\Models\Backoffice;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        $user = Backoffice::findByEmail($this->email);

        abort_if(!$user, 422, 'email_not_found');

        abort_unless(Hash::check($this->password, $user->password), 403, 'failed_login');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => [
                'required',
                'email',
            ],
            'password' => [
                'required',
            ]
        ];
    }

}
