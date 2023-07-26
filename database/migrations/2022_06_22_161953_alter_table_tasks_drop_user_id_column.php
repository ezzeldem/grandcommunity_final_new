<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTasksDropUserIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            if(Schema::hasColumn('tasks','tasks_user_id_foreign')){
                $table->dropForeign('tasks_user_id_foreign'); 
            }
            if(Schema::hasColumn('tasks','user_id')){
                $table->dropColumn('user_id'); 
            }
            if(Schema::hasColumn('tasks','tasks_status_id_foreign')){
                $table->dropForeign('tasks_user_id_foreign'); 
            }
            if(Schema::hasColumn('tasks','status_id')){
                $table->dropColumn('status_id'); 
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
