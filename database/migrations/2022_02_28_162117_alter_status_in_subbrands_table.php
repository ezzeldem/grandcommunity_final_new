<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStatusInSubbrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subbrands', function (Blueprint $table) {
            $table->string('status')->default(0)
                ->comment('0=>inactive,1=> active')->change();
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
            $table->string('status')->default(1)
                ->comment('0=>inactive,1=> active')->change();
        });
    }
}
