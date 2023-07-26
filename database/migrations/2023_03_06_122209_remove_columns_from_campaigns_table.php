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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['social_channels','insta', 'whats_number', 'phone', 'gift_image']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('social_channels')->nullable();
            $table->string('insta')->nullable();
            $table->string('whats_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('gift_image')->nullable();
        });
    }
};
