<?php

namespace Database\Factories;

use App\Models\UserPromotion;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPromotionFactory extends Factory
{
    protected $model = UserPromotion::class;

    public function definition(): array
    {
        return [
            'user_id'           => UserFactory::new(),
            'promotion_code_id' => PromotionCodeFactory::new(),
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }
}
