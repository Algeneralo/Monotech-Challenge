<?php

namespace Tests\Http\Controllers\User;


use Tests\TestCase;
use Database\Factories\UserFactory;
use Database\Factories\PromotionCodeFactory;

class UserPromotionControllerTest extends TestCase
{
    public function test_user_can_use_code()
    {
        $promotionCode = PromotionCodeFactory::new()->create();

        $this->actingAsUser()
            ->postJson('/api/assign-promotion', [
                'code' => $promotionCode->code,
            ])
            ->assertSuccessful();
    }

    public function test_it_change_user_wallet_balance()
    {
        $promotionCode = PromotionCodeFactory::new()->create();

        $user = UserFactory::new()->create();

        $this->assertEquals(0, $user->wallet->balance);

        $this->actingAsUser($user)
            ->postJson('/api/assign-promotion', [
                'code' => $promotionCode->code,
            ])->assertSuccessful();

        $this->assertEquals($promotionCode->amount, $user->wallet->fresh()->balance);
    }
}
