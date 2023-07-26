<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalViewAndShareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scrape_tiktoks', function (Blueprint $table) {
            $table->string('total_view')->nullable();
            $table->string('total_share')->nullable();
            $table->boolean('isPrivate')->nullable();

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
}
