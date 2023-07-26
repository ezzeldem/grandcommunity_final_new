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
        Schema::table('scrape_instagrams', function (Blueprint $table) {
            //
			$table->tinyInteger('is_private')->default(0)->after('is_verified');
			$table->text('details')->Nullable()->after('is_private');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scrape_instagrams', function (Blueprint $table) {
            //
        });
    }
};
