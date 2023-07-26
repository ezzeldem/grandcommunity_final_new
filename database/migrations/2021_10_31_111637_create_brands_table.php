<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->unique();
            $table->string('name');
            $table->string('email')->unique();

            $table->json('phone');
            $table->string('password');
            $table->text('address');
            $table->text('whatsapp');
            $table->text('image')->nullable();

            $table->tinyInteger('status')->default(0)->comment('0=>inactive  1=> active');
            $table->json('country_id');
            $table->string('insta_uname')->unique()->nullable();
            $table->string('facebook_uname')->unique()->nullable();
            $table->string('tiktok_uname')->unique()->nullable();
            $table->string('snapchat_uname')->unique()->nullable();
            $table->string('twitter_uname')->unique()->nullable();
            $table->string('website_uname')->unique()->nullable();
            $table->date('expirations_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('brands');
    }
}
