<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOfficeIdToBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            if(!Schema::hasColumn('brands','office_id')){
                $table->BigInteger('office_id')->nullable()->unsigned();
                $table->foreign('office_id')->references('id')->on('offices');
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
        Schema::table('brands', function (Blueprint $table) {
            if(Schema::hasColumn('brands','office_id')){
                $table->dropForeign('brands_office_id_foreign');
                $table->dropColumn('office_id');
            }
        });
    }
}
