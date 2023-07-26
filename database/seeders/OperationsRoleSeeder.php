<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Permission;
use App\Models\Role;

class OperationsRoleSeeder extends Seeder
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
        $parent_role = Role::where('name','LIKE','%OperationManager%')->first();
        $operationsRole = Role::updateOrCreate(['name' => 'superOperations','guard_name' => 'web','type'=>'operations', 'parent_role' => $parent_role->id],
            ['name' => 'superOperations','guard_name' => 'web','type'=>'operations']);

        $operations = Admin::where('email','operations@gmail.com')->where('role','operations')->first();
        if(!$operations){
            $operations = Admin::updateOrCreate([ 'username'=>'operations', 'email'=>'operations@gmail.com','role'=>'operations'],[
                'name'=>'operations',
                'username'=>'operations',
                'email'=>'operations@gmail.com',
                'role'=>'superOperation',
                'password'=>123456,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }

        if($operationsRole)
            $operations->syncRoles('superOperations');
        /**
         *  get database tables
         */
        $dbTables = dbOperationsTables();

        /**
         *  give permission on every database table
         */

        foreach ($dbTables as $table){
            // sales permission
            $permissions = Permission::where('name','like','%'.$table)->get();
            foreach ($permissions as $permission){
                /**
                 * assign permission to role
                 */
                $operationsRole->givePermissionTo($permission);
                /**
                 * assign permission to user
                 */
                if($operations)
                    $operations->givePermissionTo($permission);
            }
        }
    }
}
