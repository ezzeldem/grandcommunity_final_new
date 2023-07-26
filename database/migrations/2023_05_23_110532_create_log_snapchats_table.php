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
        Schema::create('log_snapchats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('snapchat_id')->nullable();
            $table->string('snapchat_username')->nullable();
            $table->string('followers')->nullable();
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
        Schema::dropIfExists('log_snapchats');
    }
};
