<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->text('image');
            $table->integer('influencers_count');
            $table->integer('campaign_count');
            $table->integer('country_count');
            $table->text('homepage_pic');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('instagram');
            $table->string('snapchat');
            $table->string('linkedin');
            $table->integer('account_verification_limit');
            $table->text('google_play');
            $table->text('app_store');
            $table->text('phone');
            $table->string('email');
            $table->text('location');
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
        Schema::dropIfExists('settings');
    }
}
