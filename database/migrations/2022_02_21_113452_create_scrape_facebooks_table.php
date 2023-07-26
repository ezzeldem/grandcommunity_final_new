<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScrapeFacebooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrape_facebooks', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('type')->nullable()->comment('1=>influencer,2=>brand');
            $table->unsignedBigInteger('influe_brand_id')->nullable();
            $table->string('face_username')->nullable();
            $table->string('face_id')->nullable();
            $table->string('name')->nullable();
            $table->string('face_image')->nullable();
            $table->string('followers')->nullable();
            $table->string('following')->nullable();
            $table->string('uploads')->nullable();
            $table->decimal('engagement_average_rate')->nullable();
            $table->text('bio')->nullable();
            $table->string('total_likes')->nullable();
            $table->string('total_comments')->nullable();
            $table->timestamp('last_check_date')->nullable();
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
        Schema::dropIfExists('scrape_facebooks');
    }
}
