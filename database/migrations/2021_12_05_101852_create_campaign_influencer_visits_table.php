<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignInfluencerVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_influencer_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_influencer_id')->constrained('campaign_influencers')->onDelete('cascade');
//            $table->foreignId('campaign_id')->constrained('campaigns')->onDelete('cascade');
//            $table->foreignId('influencer_id')->constrained('influencers')->onDelete('cascade');
//            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->tinyInteger('used_code_type')->comment('0->qrcode, 1->code, Null->forDelivery')->nullable();
            $table->tinyInteger('is_test_code')->default(0)->comment('0->no, 1->yes');

            $table->dateTime('actual_date');
            $table->integer('no_of_companions')->default(0);
            $table->integer('incorrect')->default(0);
            $table->integer('status')->default(0);
            $table->string('branch_id')->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('campaign_influencer_visits');
    }
}
