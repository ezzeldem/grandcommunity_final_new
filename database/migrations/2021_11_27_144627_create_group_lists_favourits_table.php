<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupListsFavouritsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_lists_favourits', function (Blueprint $table) {
            $table->id();
            $table->integer('influencer_id')->default(0);
            $table->integer('group_list_id')->default(0); //->constrained('group_lists')->onDelete('cascade');
            $table->integer('brand_id')->default(0); //->constrained('brands')->onDelete('cascade');
            $table->integer('created_by')->default(0); //->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_lists_favourits');
    }
}
