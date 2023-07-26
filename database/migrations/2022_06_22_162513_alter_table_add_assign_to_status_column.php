<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAddAssignToStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            if(!Schema::hasColumn('tasks','tasks_user_id_foreign')){
                $table->bigInteger('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('admins')->onDelete('cascade');
            }
            if(!Schema::hasColumn('tasks','tasks_tasks_id_foreign')){
                $table->bigInteger('status_id')->unsigned()->nullable();
                $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
            }
            if(!Schema::hasColumn('tasks','assign_status')){
                $table->string('assign_status')->nullable()->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
}
