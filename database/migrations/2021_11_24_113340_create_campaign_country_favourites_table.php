<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignCountryFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_country_favourites', function (Blueprint $table) {
            $table->id();
            $table->integer('campaign_id')->default(0);
            $table->integer('country_id')->default(0); //->constrained('countries')->onDelete('cascade');
            $table->integer('state_id')->default(0); //->constrained('states')->onDelete('cascade');
            $table->json('city_id')->default(0); //->constrained('cities')->onDelete('cascade');
            $table->integer('list_id')->default(0); //->constrained('group_lists')->onDelete('cascade');
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
        Schema::dropIfExists('campaign_country_favourites');
    }
}
