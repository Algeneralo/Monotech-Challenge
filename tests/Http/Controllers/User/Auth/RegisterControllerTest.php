<?php

namespace Tests\Http\Controllers\User\Auth;

use Tests\TestCase;
use Illuminate\Auth\Middleware\Authorize;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Controllers\User\Auth\RegisterController;

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
            'username'  => 'userName',
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