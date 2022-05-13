<?php

namespace Tests\Http\Controllers\Backoffice\Auth;


use Tests\TestCase;
use Database\Factories\BackofficeFactory;
use App\Http\Requests\Backoffice\LoginRequest;
use App\Http\Controllers\Backoffice\Auth\LoginController;

class LoginControllerTest extends TestCase
{

    public function test_user_can_login()
    {
        $backoffice = BackofficeFactory::new()->create(['password' => '123456']);

        $this->postJson('/api/backoffice/login', [
            'email'    => $backoffice->email,
            'password' => '123456',
        ])->assertSuccessful()
            ->assertJsonStructure([
                'success',
                'data',
                'meta' => ['token']
            ]);
    }

    public function test_login_validates_using_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            LoginController::class,
            'login',
            LoginRequest::class
        );
    }
}
