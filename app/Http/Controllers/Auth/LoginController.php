<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\ApiBaseController;

class LoginController extends ApiBaseController
{
    public function login(LoginRequest $request)
    {
        $user = User::findByEmail($request->email);

        $data = (array) (new UserResource($user));
        $meta = ['token' => $user->createPlainTextToken()];

        return $this->response(data: $data, meta: $meta);
    }

}
