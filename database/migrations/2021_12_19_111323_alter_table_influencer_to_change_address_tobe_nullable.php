<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInfluencerToChangeAddressTobeNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->integer('country_id')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->text('interest')->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->dropColumn('country_id');
            $table->dropColumn('address');
            $table->dropColumn('interest');
            $table->dropColumn('date_of_birth');
        });
    }
}
