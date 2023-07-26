<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInfluencers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->dropColumn('terms');
            $table->dropColumn('user_name');
            $table->dropColumn('email');
            $table->dropColumn('password');
            $table->foreignId('user_id')->after('id')->nullable()->constrained('users')->onDelete('cascade');
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
            $table->string('user_name')->unique();
            $table->string('email')->unique();
            $table->text('password');
            $table->tinyInteger('terms')->default(0)->comment('0=>approve  1=> noapprove');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}

