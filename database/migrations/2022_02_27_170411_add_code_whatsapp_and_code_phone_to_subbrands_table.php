<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeWhatsappAndCodePhoneToSubbrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subbrands', function (Blueprint $table) {
            $table->integer('code_whats')->nullable();
            $table->integer('code_phone')->nullable();
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
            $table->dropColumn('code_whats');
            $table->dropColumn('code_phone');
        });
    }
}
