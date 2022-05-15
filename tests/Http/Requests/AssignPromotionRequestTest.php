<?php

namespace Tests\Http\Requests;


use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\UserPromotion;
use Database\Factories\UserFactory;
use Database\Factories\PromotionCodeFactory;
use App\Http\Requests\AssignPromotionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AssignPromotionRequestTest extends TestCase
{
    public function testAuthorize_for_wrong_quota()
    {
        $this->expectException(ModelNotFoundException::class);
        (new AssignPromotionRequest(['code' => 'non exists code']))->authorize();
    }

    public function testAuthorize_for_exceeded_usage_quota()
    {
        $promotionCode = PromotionCodeFactory::new()->create(['quota' => 0]);

        $this->expectExceptionMessage('code_usage_exceeded');

        (new AssignPromotionRequest(['code' => $promotionCode->code]))->authorize();
    }


    public function testAuthorize_for_not_started_code()
    {
        $promotionCode = PromotionCodeFactory::new()->create(['start_date' => now()->addDays(3)]);

        $this->expectExceptionMessage('code_not_started');

        (new AssignPromotionRequest(['code' => $promotionCode->code]))->authorize();
    }

    public function testAuthorize_for_expired_code()
    {
        $promotionCode = PromotionCodeFactory::new()->create(['end_date' => now()->subDays(3)]);

        $this->expectExceptionMessage('code_expired');

        (new AssignPromotionRequest(['code' => $promotionCode->code]))->authorize();
    }

    public function testAuthorize_for_used_code()
    {
        $user = UserFactory::new()->create();
        Sanctum::actingAs($user);

        $promotionCode = PromotionCodeFactory::new()->create();
        UserPromotion::create(['user_id' => $user->id, 'promotion_code_id' => $promotionCode->id]);

        $this->expectExceptionMessage('code_already_used');

        (new AssignPromotionRequest(['code' => $promotionCode->code]))->authorize();
    }

    public function testAuthorize()
    {
        $user = UserFactory::new()->create();
        Sanctum::actingAs($user);

        $promotionCode = PromotionCodeFactory::new()->create();

        $this->assertTrue((new AssignPromotionRequest(['code' => $promotionCode->code]))->authorize());
    }

    public function testRules()
    {
        $this->assertEquals([
            'code' => [
                'required',
                'exists:promotion_codes,code'
            ]
        ], (new AssignPromotionRequest())->rules());
    }
}
