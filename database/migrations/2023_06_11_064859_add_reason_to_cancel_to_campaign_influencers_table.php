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
        Schema::table('campaign_influencers', function (Blueprint $table) {
            $table->string('reason_to_cancel')->nullable()->after('status');
            $table->string('feedback')->nullable()->after('reason_to_cancel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_influencers', function (Blueprint $table) {
            //
        });
    }
};
