<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Http\Traits\EmailAuthenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Backoffice extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use EmailAuthenticatable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        if (!$value) {
            return;
        }
        $this->attributes['password'] = bcrypt($value);
    }
}