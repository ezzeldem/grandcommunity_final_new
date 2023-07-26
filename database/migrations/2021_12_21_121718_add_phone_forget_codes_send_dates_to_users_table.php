<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneForgetCodesSendDatesToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique()->nullable()->after('email');
            $table->timestamp('forget_at')->nullable()->after('password');
            $table->string('forget_code')->nullable()->after('password');
            $table->string('forget_type')->nullable()->after('password')->comment('phone,mail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone']);
            $table->dropColumn('phone');
            $table->dropColumn('forget_code');
            $table->dropColumn('forget_at');
            $table->dropColumn('forget_type');
        });
    }
}
