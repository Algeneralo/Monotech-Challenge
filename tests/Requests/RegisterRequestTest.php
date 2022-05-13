<?php

namespace Tests\Requests;


use Tests\TestCase;
use App\Http\Requests\User\RegisterRequest;

class RegisterRequestTest extends TestCase
{
    public function testRules()
    {
        $this->assertEquals([
            'firstname' => [
                'required',
                'string',
                'max:255',
            ],
            'lastname'  => [
                'required',
                'string',
                'max:255',
            ],
            'email'     => [
                'required',
                'unique:users,email',
            ],
            'username'  => [
                'required',
                'unique:users,username',
            ],
            'password'  => [
                'required',
                'between:6,18',
            ],
        ],
            (new RegisterRequest())->rules()
        );
    }
}