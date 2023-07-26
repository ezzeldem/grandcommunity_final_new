<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencers_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('influencer_id');
            $table->unsignedBigInteger('group_list_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('source')->default('INSTAGRAM');
            $table->datetime('date')->nullable();
            $table->timestamp('group_deleted_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('influencers_groups');
    }
};
