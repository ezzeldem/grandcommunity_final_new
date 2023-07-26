<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGroupListToChangeNameColum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_lists', function (Blueprint $table) {
            if (Schema::hasColumn('group_lists', 'name')){
                 $table->dropUnique('name');
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
        Schema::table('group_lists', function (Blueprint $table) {
            if (Schema::hasColumn('group_lists', 'name')){
                $table->unique('name');
            }
        });
    }
}
