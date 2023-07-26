<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSubbrandToRemoveUniqueFromName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subbrands', function (Blueprint $table) {
            if (Schema::hasColumn('subbrands', 'name')) {
                $table->dropUnique(['name']);
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
        Schema::table('subbrands', function (Blueprint $table) {
            if (Schema::hasColumn('subbrands', 'name')) {
                $table->unique('name');
            }
        });
    }
}
