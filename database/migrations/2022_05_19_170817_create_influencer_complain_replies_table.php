<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencerComplainRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_complain_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complain_reply_id')->unsigned();
            $table->foreign('complain_reply_id')->references('id')->on('influencer_complains');
            $table->text('reply_text')->nullable();
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
        Schema::dropIfExists('influencer_complain_replies');
    }
}
