<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLikesAndCommentsTableMediaInsta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_instagrams', function (Blueprint $table) {
            $table->string('likes')->nullable();
            $table->string('comments')->nullable();
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
        Schema::table('media_instagrams', function (Blueprint $table) {
            //
        });
    }
}
