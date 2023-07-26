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
        Schema::table('media_instagrams', function (Blueprint $table) {
            //
			$table->dropColumn('video_id');
			$table->bigInteger('media_id');
			$table->string('shortcode')->after('media_id');
			$table->text('caption')->after('shortcode')->nullable();
			$table->string('media_type')->after('caption')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_instagrams', function (Blueprint $table) {
            //
        });
    }
};
