<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTiktoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_tiktoks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tiktok_id')->nullable();
            $table->string('tiktok_username')->nullable();
            $table->string('followers')->nullable();
            $table->string('following')->nullable();
            $table->string('uploads')->nullable();
            $table->decimal('engagement_average_rate')->nullable();
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
        Schema::dropIfExists('log_tiktoks');
    }
}
