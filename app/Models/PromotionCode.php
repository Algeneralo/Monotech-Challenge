<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class PromotionCode extends Model
{
    protected $fillable = [
        'code',
        'start_date',
        'end_date',
        'amount',
        'quota',
        'original_quota',
        'backoffice_id',
    ];
    public $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'amount'     => 'int'
    ];

    public static function generateUniqueCode()
    {
        $code = Str::random(12);

        if (self::where('code', $code)->exists()) {
            self::generateUniqueCode();
        }

        return Str::upper($code);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_promotions');
    }

    public function userPromotionCodes()
    {
        return $this->belongsToMany(User::class, 'user_promotions');
    }
}