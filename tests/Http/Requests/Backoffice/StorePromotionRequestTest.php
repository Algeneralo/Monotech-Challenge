<?php

namespace Tests\Http\Requests\Backoffice;


use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Database\Factories\UserFactory;
use Database\Factories\BackofficeFactory;
use App\Http\Requests\Backoffice\StorePromotionRequest;

class StorePromotionRequestTest extends TestCase
{

    public function testRules()
    {
        $this->assertEquals([
            'start_date' => [
                'required',
                'date',
                'before:end_date'
            ]
            , 'end_date' => [
                'required',
                'date',
                'after:start_date'
            ],
            'amount'     => [
                'required',
                'numeric',
                'gt:0'
            ],
            'quota'      => [
                'required',
                'numeric',
                'gt:0'
            ],
        ],
            (new StorePromotionRequest())->rules()
        );
    }

    public function testAuthorize_for_non_registered()
    {
        $this->assertFalse((new StorePromotionRequest())->authorize());
    }

    public function testAuthorize_for_non_backoffice()
    {
        Sanctum::actingAs(UserFactory::new()->create());

        $this->assertFalse((new StorePromotionRequest())->authorize());
    }

    public function testAuthorize()
    {
        Sanctum::actingAs(BackofficeFactory::new()->create());

        $this->assertTrue((new StorePromotionRequest())->authorize());
    }
}
