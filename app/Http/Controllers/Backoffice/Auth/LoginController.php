<?php

namespace App\Http\Controllers\Backoffice\Auth;


use App\Models\Backoffice;
use App\Http\Resources\BackofficeResource;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Backoffice\LoginRequest;

class LoginController extends ApiBaseController
{
    public function login(LoginRequest $request)
    {
        $user = Backoffice::findByEmail($request->email);

        $data = (array) (new BackofficeResource($user));
        $meta = ['token' => $user->createPlainTextToken()];

        return $this->response(data: $data, meta: $meta);
    }

}
