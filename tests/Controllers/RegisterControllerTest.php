<?php

namespace Tests\Controllers;

use Tests\TestCase;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Middleware\Authorize;
use App\Http\Controllers\Auth\RegisterController;

class RegisterControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(Authorize::class);
    }

    public function test_user_can_register()
    {
        $this->postJson('/api/v1/register', [
            'email'     => 'fake@example.com',
            'password'  => '123456',
            'firstname' => 'FakeFirst',
            'lastname'  => 'FakeLast'
        ])->assertSuccessful()
            ->assertJsonStructure([
                'success',
                'data',
                'meta' => ['token']
            ]);
    }

    public function register_validates_using_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            RegisterController::class,
            'register',
            RegisterRequest::class
        );
    }
}