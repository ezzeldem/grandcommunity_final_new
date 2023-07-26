<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('user_name');
            $table->dropColumn('email');
            $table->dropColumn('password');
            $table->json('country_id')->nullable()->change();
            $table->text('address')->nullable()->change();
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
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('country_id');
            $table->dropColumn('address');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('user_name')->unique();
            $table->string('email')->unique();
            $table->string('password');
        });
    }
}
