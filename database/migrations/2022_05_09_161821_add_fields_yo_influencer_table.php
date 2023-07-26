<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsYoInfluencerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->json('match_campaign')->nullable();
            $table->tinyInteger('ethink_category')->default(1)->comment('1 => open mind, 2 => bedounis')->nullable();
            $table->tinyInteger('face')->default(1)->comment('1 => no, 2 => yes')->nullable();
            $table->tinyInteger('speak')->default(1)->comment('1 => no, 2 => yes')->nullable();
            $table->tinyInteger('social_class')->nullable();
            $table->tinyInteger('min_voucher')->nullable();
            $table->tinyInteger('recommended_any_camp')->default(1)->comment('1 => no, 2 => yes')->nullable();
            $table->tinyInteger('fake')->default(1)->comment('1 => no, 2 => yes')->nullable();
            $table->tinyInteger('account_status')->nullable();
            $table->tinyInteger('citizen_status')->nullable();
            $table->json('social_coverage')->nullable();
            $table->tinyInteger('share')->default(1)->comment('1 => no, 2 => yes')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->tinyInteger('chat_response_speed')->nullable();
            $table->tinyInteger('behavior')->nullable();
            $table->tinyInteger('hijab')->default(1)->comment('1 => no, 2 => yes')->nullable();
            $table->tinyInteger('coverage_rating')->nullable();
            $table->string('youtube_uname')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('influencers', function (Blueprint $table) {

        });
    }
}
