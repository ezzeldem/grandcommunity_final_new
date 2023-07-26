<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInterestInInfluencers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencers', function (Blueprint $table) {
            if (!Schema::hasColumn('influencers', 'interest')){
                $table->string('interest',255)->nullable();
            }
            else{
                $table->string('interest',255)->nullable()->change();
            }
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
            if (!Schema::hasColumn('influencers', 'interest')){
                $table->string('interest',255)->nullable();
            }
            else{
                $table->string('interest',255)->nullable()->change();
            }
        });
    }
}
