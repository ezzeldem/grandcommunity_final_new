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
        Schema::create('media_twitter', function (Blueprint $table) {
            $table->id();
			$table->integer('twitter_id');
			$table->bigInteger('shortcode');
			$table->longText('caption')->nullable();
			$table->integer('favorite_count')->default(0);
			$table->integer('quote_count')->default(0);
			$table->integer('reply_count')->default(0);
			$table->integer('retweet_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_twitter');
    }
};
