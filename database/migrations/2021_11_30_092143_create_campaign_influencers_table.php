<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_influencers', function (Blueprint $table) {
            $table->id();
            $table->integer('influencer_id')->default(0);
            $table->integer('list_id')->default(0); //->constrained('group_lists')->onDelete('cascade');
            $table->integer('brand_id')->default(0); //->constrained('brands')->onDelete('cascade');
            $table->integer('campaign_id')->default(0); //->constrained('campaigns')->onDelete('cascade');
            $table->string('qr_code')->nullable();
            $table->string('influ_code')->unique()->nullable();
            $table->string('qrcode_valid_times')->default(1)->nullable();
            $table->dateTime('visit_or_delivery_date')->nullable();
            $table->integer('status');
            $table->integer('campaign_type')->comment('0=>visit, 1=>delivery')->default(0);
            $table->text('coverage')->nullable();
            $table->integer('coverage_by')->nullable();
            $table->dateTime('coverage_date')->nullable();
            $table->integer('country_id')->default(0); //->constrained('countries')->onDelete('cascade');
            $table->tinyInteger('take_campaign')->default(1);
            $table->string('notes')->nullable();
            $table->string('test_qr_code')->nullable();
            $table->string('test_influ_code')->unique()->nullable();
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
        Schema::dropIfExists('campaign_influencers');
    }
}
