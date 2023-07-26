<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUniqueIndexBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropUnique(['insta_uname']);
            $table->dropUnique(['facebook_uname']);
            $table->dropUnique(['tiktok_uname']);
            $table->dropUnique(['snapchat_uname']);
            $table->dropUnique(['twitter_uname']);
            $table->dropUnique(['website_uname']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('insta_uname')->unique()->change();
            $table->string('facebook_uname')->unique()->change();
            $table->string('tiktok_uname')->unique()->change();
            $table->string('snapchat_uname')->unique()->change();
            $table->string('twitter_uname')->unique()->change();
            $table->string('website_uname')->unique()->change();
        });
    }
}
