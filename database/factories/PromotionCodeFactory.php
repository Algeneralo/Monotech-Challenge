<?php

namespace Database\Factories;

use App\Models\PromotionCode;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionCodeFactory extends Factory
{
    protected $model = PromotionCode::class;

    public function definition(): array
    {
        return [
            'backoffice_id'  => BackofficeFactory::new()->create(),
            'code'           => $this->faker->unique()->word(),
            'amount'         => $this->faker->randomFloat(),
            'original_quota' => $this->faker->randomNumber(),
            'quota'          => $this->faker->randomNumber(),
            'start_date'     => Carbon::now(),
            'end_date'       => Carbon::now()->addDay(),
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ];
    }
}
