<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvgLikeAndCommintTableScrapInsta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scrape_instagrams', function (Blueprint $table) {
            $table->string('avg_likes')->nullable();
            $table->string('avg_comments')->nullable();
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
