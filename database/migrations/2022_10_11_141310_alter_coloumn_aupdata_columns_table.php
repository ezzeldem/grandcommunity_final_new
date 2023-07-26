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
        Schema::table('campaigns', function (Blueprint $table) {
            if(Schema::hasColumn('campaigns','influencer_count','count_of_visit','count_of_delivery','voucher_branches','confirmation_delivery_link','confirmation_link','campaign_status')){
                $table->dropColumn('influencer_count');
                $table->dropColumn('count_of_visit');
                $table->dropColumn('count_of_delivery');
                // $table->dropColumn('branch_ids');
                $table->dropColumn('voucher_branches');
                $table->dropColumn('confirmation_delivery_link');
                $table->dropColumn('confirmation_link');
                $table->dropColumn('campaign_status');
            }
               
                if(!Schema::hasColumn('campaigns','camp_invetation','camp_brief','camp_note','objective_id','min_story')){
                    $table->text('camp_brief')->nullable();
                    $table->text('camp_invetation')->nullable();
                    $table->text('camp_note')->nullable();
                    $table->integer('objective_id')->nullable();
                    $table->integer('min_story')->nullable();
                }
                $table->text('brief')->nullable()->change();
                $table->bigInteger('camp_id')->nullable()->change();
               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            //
        });
    }
};
