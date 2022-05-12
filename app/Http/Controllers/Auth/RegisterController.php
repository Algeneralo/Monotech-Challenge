<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\ApiBaseController;

class RegisterController extends ApiBaseController
{
    public function register(RegisterRequest $request)
    {
        $user = User::query()->create($request->validated());

        $data = (array) (new UserResource($user));
        $meta = ['token' => $user->createPlainTextToken()];

        return $this->response(data: $data, meta: $meta);
    }
}
