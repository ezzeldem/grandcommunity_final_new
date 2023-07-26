<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencerChangeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_change_details', function (Blueprint $table) {
            $table->id();
            $table->integer('influencer_id');
            $table->string('insta_uname');
            $table->integer('code');
            $table->string('phone');
            $table->string('address');
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('current')->nullable();
            $table->string('country_id');
            $table->string('state_id');
            $table->string('city_id');
            $table->date('return_date');
            $table->text('note');
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
        Schema::dropIfExists('influencer_change_details');
    }
}
