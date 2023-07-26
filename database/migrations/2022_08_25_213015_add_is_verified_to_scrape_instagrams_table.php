<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsVerifiedToScrapeInstagramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scrape_instagrams', function (Blueprint $table) {
            //
            $table->boolean('is_verified')->after('engagement_average_rate');
        });

        Schema::table('scrape_snapchats', function (Blueprint $table) {
            //
            $table->boolean('is_verified')->after('engagement_average_rate');
        });

        Schema::table('scrape_twitters', function (Blueprint $table) {
            //
            $table->boolean('is_verified')->after('engagement_average_rate');
        });

        Schema::table('scrape_facebooks', function (Blueprint $table) {
            //
            $table->boolean('is_verified')->after('engagement_average_rate');
        });

        Schema::table('scrape_tiktoks', function (Blueprint $table) {
            //
            $table->boolean('is_verified')->after('engagement_average_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scrape_instagrams', function (Blueprint $table) {
            //
        });
    }
}
