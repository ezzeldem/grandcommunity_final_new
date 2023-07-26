<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterActiveInInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->string('active')->default(2)
                ->comment('0=>inactive,1=> active,2=>pending,3=>reject')->change();
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
            $table->string('active')->default(0)
                ->comment('0=>inactive,1=> active')->change();
        });
    }
}
