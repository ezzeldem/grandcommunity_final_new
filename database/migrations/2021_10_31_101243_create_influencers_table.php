<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->unique();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('image')->nullable()->comment('profile_image');
            $table->text('phone');
            $table->string('whats_number')->unique();
            $table->text('address');
            $table->string('password');
            $table->date('date_of_birth');
            $table->date('expirations_date')->nullable();
            $table->integer('country_id');
            $table->string('insta_uname')->unique()->nullable();
            $table->string('facebook_uname')->unique()->nullable();
            $table->string('tiktok_uname')->unique()->nullable();
            $table->string('snapchat_uname')->unique()->nullable();
            $table->string('twitter_uname')->unique()->nullable();
            $table->json('status')->comment('1=>outofCountry  2=> vip 3=> delivery_only');
            $table->tinyInteger('social_status')->default(0)->comment('0=>single  1=> married 2=>have Children');
            $table->text('interest')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('fast_code')->nullable();
            $table->integer('nationality')->nullable();
            $table->integer('engagement')->nullable();
            $table->string('location')->nullable();
            $table->tinyInteger('active')->default(0)->comment('0=>inactive  1=> active');
            $table->tinyInteger('gender')->default(0)->comment('0=>female  1=> male');
            $table->tinyInteger('terms')->default(0)->comment('0=>approve  1=> noapprove');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('influencers');
    }
}
