<?php

namespace Tests\Http\Controllers\User\Auth;


use Tests\TestCase;
use Database\Factories\UserFactory;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Auth\Middleware\Authorize;
use App\Http\Controllers\User\Auth\LoginController;

class LoginControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(Authorize::class);
    }

    public function test_user_can_register()
    {
        $user = UserFactory::new()->create(['password' => '123456']);

        $this->postJson('/api/v1/login', [
            'email'    => $user->email,
            'password' => '123456',
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
            LoginController::class,
            'login',
            LoginRequest::class
        );
    }
}