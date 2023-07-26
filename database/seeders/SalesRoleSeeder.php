<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Permission;
use App\Models\Role;

class SalesRoleSeeder extends Seeder
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
        $salesRole = Role::updateOrCreate(['name' => 'superSales','guard_name' => 'web','type'=>'sales', 'parent_role' => $parent_role->id],
            ['name' => 'superSales','guard_name' => 'web','type'=>'sales']);

        $sales = Admin::where('email','sales@gmail.com')->where('role','sales')->first();
        if(!$sales){
            $sales = Admin::updateOrCreate([ 'username'=>'sales', 'email'=>'sales@gmail.com','role'=>'sales'],[
                'name'=>'sales',
                'username'=>'sales',
                'email'=>'sales@gmail.com',
                'role'=>'superSales',
                'password'=>123456,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
        if($salesRole)
            $sales->syncRoles('superSales');
        /**
         *  get database tables
         */
        $dbTables = dbSalesTables();

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
                $salesRole->givePermissionTo($permission);
                /**
                 * assign permission to user
                 */
                if($sales)
                    $sales->givePermissionTo($permission);
            }
        }
    }
}
