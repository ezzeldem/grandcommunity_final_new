<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignSecretPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_secret_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_secret_id')
                ->constrained('campaign_secrets')->onDelete('cascade');
            $table->foreignId('secret_permission_id')
                ->constrained('secret_permissions')->onDelete('cascade');
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
        Schema::dropIfExists('campaign_secret_permissions');
    }
}
