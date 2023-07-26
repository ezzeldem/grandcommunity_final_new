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
        Schema::create('campaign_coverage_channels', function (Blueprint $table) {
            $table->id();
            $table->integer('campaign_id')->default(0);
            $table->integer('channel_id')->default(0);
            $table->string('posts')->nullable();
            $table->string('reels')->nullable();
            $table->string('stories')->nullable();
            $table->boolean('video')->default(0);
            $table->boolean('main_channel')->default(0);
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
        Schema::dropIfExists('campaign_coverage_channels');
    }
};