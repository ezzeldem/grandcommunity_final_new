<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubBrandIdColumnGroupListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_lists', function (Blueprint $table) {
            if(!Schema::hasColumn('group_lists','sub_brand_id')){    
                $table->unsignedBigInteger('sub_brand_id')->nullable();
                $table->foreign('sub_brand_id')->references('id')->on('subbrands');
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
            if(Schema::hasColumn('group_lists',['sub_brand_id'])){
                $table->dropColumn('sub_brand_id');
            }
        });
    }
}
