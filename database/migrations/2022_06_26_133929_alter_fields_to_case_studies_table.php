<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFieldsToCaseStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_studies', function (Blueprint $table) {
            $table->dropColumn(['campain_reach', 'reached','engagement_rate','create_post','post_link','name','description']);
            $table->integer('total_followers')->nullable();
            $table->integer('total_influencers')->nullable();
            $table->integer('created_posts')->nullable();
            $table->tinyInteger('campaign_type')->nullable();
            $table->string('campaign_name',255)->nullable();
            $table->integer('total_days')->nullable();
            $table->text('real')->nullable();
            $table->text('video')->nullable();
            $table->text('image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_studies', function (Blueprint $table) {
            //
        });
    }
}
