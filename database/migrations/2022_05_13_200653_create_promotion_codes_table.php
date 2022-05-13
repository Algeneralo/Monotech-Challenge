<?php

use App\Models\Backoffice;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionCodesTable extends Migration
{
    public function up()
    {
        Schema::create('promotion_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Backoffice::class)->constrained();
            $table->string('code')->unique()->index();
            $table->float('amount');
            $table->integer('original_quota');
            $table->integer('quota');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotion_codes');
    }
}