<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionCode extends Model
{
    protected $fillable = [
        'code',
        'start_date',
        'end_date',
        'amount',
        'quota',
        'original_quota'
    ];
    public $casts = [
        'start_date' => 'timestamp',
        'end_date'   => 'timestamp',
        'amount'     => 'int'
    ];
}