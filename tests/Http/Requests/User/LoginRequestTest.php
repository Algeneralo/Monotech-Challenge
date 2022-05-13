<?php

namespace Tests\Http\Requests\User;


use Tests\TestCase;
use Database\Factories\UserFactory;
use App\Http\Requests\User\LoginRequest;

class LoginRequestTest extends TestCase
{
    public function testRules()
    {
        $this->assertEquals([
            'email'    => [
                'required',
                'email',
            ],
            'password' => [
                'required',
            ]
        ],
            (new LoginRequest())->rules()
        );
    }

    public function testAuthorize_for_not_exists_email()
    {
        $this->expectExceptionMessage('email_not_found');

        $this->assertFalse((new LoginRequest(['email' => 'not_exists_email']))->authorize());
    }

    public function testAuthorize_for_invalid_password()
    {
        $user = UserFactory::new()->create();
        $this->expectExceptionMessage('failed_login');

        $this->assertFalse((new LoginRequest(['email' => $user->email, 'password' => 'invalid_password']))->authorize());
    }

    public function testAuthorize()
    {
        $user = UserFactory::new()->create();

        $this->assertTrue((new LoginRequest(['email' => $user->email, 'password' => 'password']))->authorize());
    }
}