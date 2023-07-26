<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('youtube')->nullable();
            $table->string('pinterset')->nullable();
            $table->text('desc_ar')->nullable();
            $table->text('desc_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('youtube');
            $table->dropColumn('pinterset');
            $table->dropColumn('desc_ar');
            $table->dropColumn('desc_en');
        });
    }
}
