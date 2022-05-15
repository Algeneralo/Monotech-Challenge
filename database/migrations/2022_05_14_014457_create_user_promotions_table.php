<?php

use App\Models\User;
use App\Models\PromotionCode;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPromotionsTable extends Migration
{
    public function up()
    {
        Schema::create('user_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(PromotionCode::class);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_promotions');
    }
}