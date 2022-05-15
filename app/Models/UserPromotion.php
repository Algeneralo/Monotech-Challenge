<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPromotion extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotionCode()
    {
        return $this->belongsTo(PromotionCode::class);
    }
}