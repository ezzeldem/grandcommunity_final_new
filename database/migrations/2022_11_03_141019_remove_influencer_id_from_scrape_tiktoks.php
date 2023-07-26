<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scrape_tiktoks', function (Blueprint $table) {
            //
			$table->dropColumn('avg_likes');
			$table->dropColumn('avg_comments');
			$table->dropColumn('avg_view');
			$table->dropColumn('avg_share');
			$table->dropColumn('total_comments');
			$table->dropColumn('total_view');
			$table->dropColumn('total_share');
        });


		Schema::table('media_tiktoks', function (Blueprint $table) {
            //
			 $table->string('media_url')->after('video_id')->nullable();
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
            //
        });
    }
};
