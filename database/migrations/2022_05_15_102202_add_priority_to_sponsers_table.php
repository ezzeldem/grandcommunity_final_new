<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityToSponsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('our_sponsors', function (Blueprint $table) {
            $table->tinyInteger('priority')->default(0)->comment('1 => high priority, 0 => normal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('our_sponsors', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
}
