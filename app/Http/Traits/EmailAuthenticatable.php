<?php

namespace App\Http\Traits;

use App\Models\User;
use App\Models\Backoffice;

trait EmailAuthenticatable
{
    /**
     * @param string $email
     * @return User|Backoffice
     */
    public static function findByEmail(string $email)
    {
        return self::query()->where('email', $email)->first();
    }

    public function createPlainTextToken()
    {
        return $this->createToken($this->id . $this->firstname)->plainTextToken;
    }
}