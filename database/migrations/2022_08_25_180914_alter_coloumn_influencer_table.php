<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColoumnInfluencerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->dropColumn('fast_code');
            $table->dropColumn('location');
          //  $table->dropColumn('code');
            $table->dropColumn('face');
            $table->dropColumn('speak');
            $table->dropColumn('fake');
            $table->dropColumn('share');
            $table->dropColumn('hijab');
            $table->dropColumn('reason');
            $table->dropColumn('social_coverage');
            $table->dropColumn('recommended_any_camp');
            $table->renameColumn('status', 'category_ids');
            $table->renameColumn('account_status', 'account_type');
            //$table->renameColumn('active', 'influencer_status');
            $table->renameColumn('social_type', 'marital_status');
            $table->dateTime('influencer_return_date')->nullable();
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
            $table->renameColumn('category_id', 'status');
            $table->renameColumn('influencer_status', 'active');
            $table->renameColumn('marital_status', 'social_type');
            $table->renameColumn('account_type', 'account_status');
        });
    }
}
