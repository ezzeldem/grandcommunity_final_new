<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('brand_id')->default(0); //nullable()->references('id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('sub_brand_id')->default(0); //nullable()->references('id')->on('subbrands')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('influencer_count');
            $table->float('influencers_price');
            $table->integer('total_price');
            $table->integer('influencer_per_day');
            $table->integer('status')->index()->comment('0->Active, 1->pending, 2->finished, 3->canceled');
            $table->integer('campaign_type')->index()->comment('0->visit, 1->delivery, 2->mix');
            $table->string('gender')->comment('male,female,both');
            $table->boolean('has_guest')->default(0);
            $table->json('branch_ids');
            $table->text('influencers_script')->nullable();
            $table->text('company_msg')->nullable();
            $table->date('visit_start_date')->nullable();
            $table->date('visit_end_date')->nullable();
            $table->date('deliver_start_date')->nullable();
            $table->date('deliver_end_date')->nullable();
            $table->string('visit_coverage')->nullable();
            $table->string('delivery_coverage')->nullable();
            $table->string('confirmation_link')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
}
