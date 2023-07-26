<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable()->after('city_id');
            $table->tinyInteger('social_type')->nullable()->comment("single'=>1,'married'=>2,'single_father'=>3,'single_mother'=>4");
            $table->tinyInteger('children_num')->nullable();
            $table->json('children')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->dropColumn('state_id');
            $table->dropColumn('social_type');
            $table->dropColumn('children_num');
            $table->dropColumn('children');
        });
    }
}
