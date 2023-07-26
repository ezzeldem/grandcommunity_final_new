<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInstagramImageInScrapeInstagrams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scrape_instagrams', function (Blueprint $table) {
            $table->text('insta_image')->nullable()->change();
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
            if (!Schema::hasColumn('scrape_instagrams', 'insta_image')){
                $table->string('insta_image')->nullable();
            }
            else{
                $table->dropColumn('insta_image')->change();
            }
        });
    }
}
