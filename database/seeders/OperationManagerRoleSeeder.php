<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Permission;
use App\Models\Role;

class OperationManagerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         *  create new role
         */
        $operationManagerRole = Role::updateOrCreate(['name' => 'operationManager','guard_name' => 'web','type'=>'operations'],
            ['name' => 'operationManager','guard_name' => 'web','type'=>'operations']);

        $manager = Admin::where('email','manager@gmail.com')->where('role','operations')->first();
        if(!$manager){
            $manager = Admin::updateOrCreate([ 'username'=>'manager', 'email'=>'manager@gmail.com','role'=>'operations'],[
                'name'=>'manager',
                'username'=>'manager',
                'email'=>'manager@gmail.com',
                'role'=>'operationManager',
                'password'=>123456,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
        if($operationManagerRole)
            $manager->syncRoles('operationManager');
        /**
         *  get database tables
         */
        $dbTables = dbOperationManagerTables();

        /**
         *  give permission on every database table
         */

        foreach ($dbTables as $table){
            // community permission
            $permissions = Permission::where('name','like','%'.$table)->get();
            foreach ($permissions as $permission){
                /**
                 * assign permission to role
                 */
                $operationManagerRole->givePermissionTo($permission);
                /**
                 * assign permission to user
                 */
                if($manager)
                    $manager->givePermissionTo($permission);
            }
        }
    }
}
