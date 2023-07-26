<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddInstaBrefaredSocialToCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('note')->nullable()->after('confirmation_link');
            $table->longText('brief')->nullable()->after('confirmation_link');
            $table->json('social_channels')->nullable()->after('confirmation_link');
            $table->string('insta')->nullable()->after('confirmation_link');
            $table->string('whats_number')->nullable()->after('sub_brand_id');
            $table->string('phone')->nullable()->after('sub_brand_id');
            $table->time('visit_to')->nullable()->after('visit_end_date');
            $table->time('visit_from')->nullable()->after('visit_end_date');
            $table->time('delivery_to')->nullable()->after('deliver_end_date');
            $table->time('delivery_from')->nullable()->after('deliver_end_date');
        });
        DB::statement("ALTER TABLE `campaigns` MODIFY `status` INTEGER  comment '0->Active, 1->pending, 2->finished, 3->canceled,4->confirmed';");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->dropColumn('brief');
            $table->dropColumn('social_channels');
            $table->dropColumn('insta');
            $table->dropColumn('whats_number');
            $table->dropColumn('phone');
            $table->dropColumn('visit_to');
            $table->dropColumn('visit_from');
            $table->dropColumn('delivery_from');
            $table->dropColumn('delivery_to');
        });
        DB::statement("ALTER TABLE `campaigns` MODIFY `status` INTEGER  comment '0->Active, 1->pending, 2->finished, 3->canceled';");

    }
}
