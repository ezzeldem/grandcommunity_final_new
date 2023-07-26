<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandDislikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_dislikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('influencer_id')->nullable()
                ->constrained('influencers')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()
                ->constrained('brands')->onDelete('cascade');
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
        Schema::dropIfExists('brand_dislikes');
    }
}
