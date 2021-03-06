<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'username'  => $this->username,
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'email'     => $this->email,
            'wallet'    => new WalletResource($this->wallet),
        ];
    }

    public function withToken($token)
    {
        $additional = $this->additional;

        return $this->additional($additional + [
                'meta' => [
                    'token' => $token,
                ]
            ]);
    }

    public function success(bool $success)
    {
        $additional = $this->additional;

        return $this->additional($additional + [
                'success' => $success
            ]);
    }
}
