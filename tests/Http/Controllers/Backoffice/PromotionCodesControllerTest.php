<?php

namespace Tests\Http\Controllers\Backoffice;


use Tests\TestCase;
use Database\Factories\BackofficeFactory;
use Database\Factories\PromotionCodeFactory;
use App\Http\Requests\Backoffice\StorePromotionRequest;
use App\Http\Controllers\Backoffice\PromotionCodesController;

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

    public function test_can_create_promotion()
    {
        $backoffice = BackofficeFactory::new()->create();

        $data = [
            'start_date' => now()->addDays(2)->toDateTimeString(),
            'end_date'   => now()->addDays(4)->toDateTimeString(),
            'amount'     => 500,
            'quota'      => 50
        ];

        $this->actingAsBackoffice($backoffice)
            ->postJson('api/backoffice/promotion-codes', $data)
            ->assertSuccessful()
            ->assertJson([
                'data' => $data
            ]);
    }

    public function test_store_validates_using_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            PromotionCodesController::class,
            'store',
            StorePromotionRequest::class
        );
    }
}
