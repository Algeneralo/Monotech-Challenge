<?php

namespace Tests\Http\Controllers\Backoffice;


use Tests\TestCase;
use Database\Factories\BackofficeFactory;
use Database\Factories\PromotionCodeFactory;

class PromotionCodesControllerTest extends TestCase
{
    public function test_backoffice_can_list_promotion()
    {
        $backoffice = BackofficeFactory::new()->create();

        PromotionCodeFactory::new()
            ->count(4)
            ->create(['backoffice_id' => $backoffice->id]);

        $this->actingAsBackoffice($backoffice)
            ->getJson('api/backoffice/promotion-codes')
            ->assertSuccessful()
            ->assertJsonCount(4, 'data.*')
            ->assertJsonStructure([
                'success',
                'data' => [
                    [
                        'id', 'code', 'start_date', 'end_date', 'amount', 'quota'
                    ]
                ]
            ]);
    }

    public function test_backoffice_can_list_his_promotion_only()
    {
        $backoffice = BackofficeFactory::new()->create();
        $otherBackoffice = BackofficeFactory::new()->create();

        PromotionCodeFactory::new()
            ->count(4)
            ->sequence(
                ['backoffice_id' => $backoffice->id],
                ['backoffice_id' => $otherBackoffice->id],
            )
            ->create();

        $this->actingAsBackoffice($backoffice)
            ->getJson('api/backoffice/promotion-codes')
            ->assertSuccessful()
            ->assertJsonCount(2, 'data.*')
            ->assertJson([
                'data' => [
                    [
                        'id' => 1,
                    ],
                    [
                        'id' => 3,
                    ]
                ]
            ]);
    }

    public function test_backoffice_can_show_promotion()
    {
        $backoffice = BackofficeFactory::new()->create();

        $promotion = PromotionCodeFactory::new()->create(['backoffice_id' => $backoffice->id]);

        $this->actingAsBackoffice($backoffice)
            ->getJson('api/backoffice/promotion-codes/1')
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'id'    => $promotion->id,
                    'code'  => $promotion->code,
                    'quota' => $promotion->quota
                ]
            ]);
    }
}
