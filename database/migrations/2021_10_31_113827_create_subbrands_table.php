<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubbrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subbrands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('preferred_gender');
            $table->string('image')->nullable()->comment('subbrand_image');
            $table->json('country_id');
            $table->json('phone');
            $table->string('whats_number')->unique();
            $table->string('link_insta')->unique()->nullable();
            $table->string('link_facebook')->unique()->nullable();
            $table->string('link_tiktok')->unique()->nullable();
            $table->string('link_snapchat')->unique()->nullable();
            $table->string('link_twitter')->unique()->nullable();
            $table->string('link_website')->unique()->nullable();
            $table->integer('brand_id')->default(0);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('subbrands');
    }
}
