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
            $table->string('voucher_amount_currency')->nullable()->after('voucher_amount');
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
            //
        });
    }
};