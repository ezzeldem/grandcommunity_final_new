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
        Schema::table('branche_campaigns', function (Blueprint $table) {
            $table->dropColumn([
                'voucher',
                'gift',
                'voucher_time',
                'voucher_expired_date',
                'gift_image',
                'gift_amount',
                'gift_amount_currency',
                'gift_description',
                'voucher_amount_currency',
                'voucher_amount'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branche_campaigns', function (Blueprint $table) {
            $table->time('voucher_time')->nullable();
            $table->date('voucher_expired_date')->nullable();
            $table->tinyInteger('gift')->default(0);
            $table->string('gift_image')->nullable();
            $table->string('gift_amount')->nullable();
            $table->string('voucher_amount')->nullable();
            $table->string('gift_amount_currency')->nullable();
            $table->string('gift_description')->nullable();
            $table->string('voucher_amount_currency')->nullable();
        });
    }
};
