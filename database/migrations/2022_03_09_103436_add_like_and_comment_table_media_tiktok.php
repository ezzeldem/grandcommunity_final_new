<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLikeAndCommentTableMediaTiktok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_tiktoks', function (Blueprint $table) {
            $table->string('likes')->nullable();
            $table->string('comments')->nullable();
            $table->string('view')->nullable();
            $table->string('share')->nullable();
            $table->string('type')->default(1)->comment('1=>video 2=>image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_tiktoks', function (Blueprint $table) {
            //
        });
    }
}
