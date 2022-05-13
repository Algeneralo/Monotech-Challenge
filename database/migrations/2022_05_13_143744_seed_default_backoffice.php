<?php

use App\Models\Backoffice;
use Illuminate\Database\Migrations\Migration;

class SeedDefaultBackoffice extends Migration
{
    public function up()
    {
        Backoffice::query()
            ->create([
                'name'     => 'Monotech',
                'email'    => 'backoffice@monotech.com',
                'password' => 'backoffice@123456@A',
            ]);
    }

}