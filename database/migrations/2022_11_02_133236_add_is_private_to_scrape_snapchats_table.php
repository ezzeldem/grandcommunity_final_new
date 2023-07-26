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
        Schema::table('scrape_snapchats', function (Blueprint $table) {
            //
			$table->tinyInteger('is_private')->default(0)->after('is_verified');
			$table->dropColumn('snap_id');
			$table->dropColumn('following');
			$table->dropColumn('total_likes');
			$table->dropColumn('total_comments');
			$table->string('total_views')->after('bio')->nullable();
			$table->string('total_share')->after('total_views')->nullable();

        });

		Schema::table('media_snapchats', function (Blueprint $table) {
            //
			$table->renameColumn('video_id','shortcode');
			$table->string('media_id')->after('snapchat_id')->nullable();
			$table->integer('media_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scrape_snapchats', function (Blueprint $table) {
            //
        });
    }
};
