<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTiktokImageInScrapeTiktoks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scrape_tiktoks', function (Blueprint $table) {
            $table->text('tiktok_image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scrape_tiktoks', function (Blueprint $table) {
            if (!Schema::hasColumn('scrape_tiktoks', 'tiktok_image')){
                $table->string('tiktok_image')->nullable();
            }
            else{
                $table->dropColumn('tiktok_image')->change();
            }

        });
    }
}
