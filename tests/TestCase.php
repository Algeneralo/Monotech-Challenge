<?php

namespace Tests;

use App\Models\Backoffice;
use Database\Factories\BackofficeFactory;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdditionalAssertions;
    use DatabaseTransactions;

    public function actingAsBackoffice(?Backoffice $backoffice = null)
    {
        $this->actingAs($backoffice ?? BackofficeFactory::new()->create(), 'api-backoffice');

        return $this;
    }
}
