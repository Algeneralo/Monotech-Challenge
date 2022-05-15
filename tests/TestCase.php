<?php

namespace Tests;

use App\Models\User;
use App\Models\Backoffice;
use Database\Factories\UserFactory;
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

    public function actingAsUser(?User $user = null)
    {
        $this->actingAs($user ?? UserFactory::new()->create());

        return $this;
    }
}
