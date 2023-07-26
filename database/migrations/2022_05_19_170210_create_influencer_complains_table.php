<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencerComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_complains', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('influencer_id')->unsigned();
            $table->foreign('influencer_id')->references('id')->on('influencers');
            $table->unsignedBigInteger('campaign_id')->unsigned();
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->tinyInteger('status')->default(0)->comment('0 => unsolved, 1 => solved');
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
        Schema::dropIfExists('influencer_complains');
    }
}
