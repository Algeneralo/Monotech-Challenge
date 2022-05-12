<?php

namespace Tests\Requests;


use Tests\TestCase;
use App\Http\Requests\RegisterRequest;

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
            'password'  => [
                'required',
                'between:6,18',
            ],
        ],
            (new RegisterRequest())->rules()
        );
    }
}