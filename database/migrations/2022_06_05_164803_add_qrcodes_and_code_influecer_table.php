<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQrcodesAndCodeInfluecerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->Text('qrcode')->nullable();
            $table->Text('influ_code')->nullable();
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
            if(Schema::hasColumn('influencers',['qrcode','influ_code'])){
                $table->dropColumn(['qrcode','influ_code']);
            }
        });
    }
}
