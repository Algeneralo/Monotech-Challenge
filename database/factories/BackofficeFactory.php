<?php

namespace Database\Factories;

use App\Models\Backoffice;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BackofficeFactory extends Factory
{
    protected $model = Backoffice::class;

    public function definition(): array
    {
        return [
            'name'           => $this->faker->name(),
            'email'          => $this->faker->unique()->safeEmail(),
            'password'       => $this->faker->password,
            'remember_token' => Str::random(10),
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ];
    }
}
