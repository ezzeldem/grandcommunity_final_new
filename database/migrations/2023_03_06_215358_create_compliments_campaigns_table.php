<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compliments_campaigns', function (Blueprint $table) {
            $table->id();
            $table->float('voucher_amount')->nullable();
            $table->date('voucher_expired_date')->nullable();
            $table->time('voucher_expired_time')->nullable();
            $table->string('voucher_amount_currency')->nullable();
            $table->string('gift_image')->nullable();
            $table->float('gift_amount')->nullable();
            $table->string('gift_amount_currency')->nullable();
            $table->string('gift_description')->nullable();
            $table->bigInteger('campaign_id')->unsigned()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compliments_campaigns');
    }
};
