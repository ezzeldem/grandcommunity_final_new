<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Permission;
use App\Models\Role;

class  RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();

        DB::table('permissions')->truncate();

        DB::table('role_has_permissions')->truncate();

        DB::table('model_has_permissions')->truncate();

        DB::table('model_has_roles')->truncate();
        Schema::enableForeignKeyConstraints();
        /**
         *  create new role
         */
        $superRole = Role::updateOrCreate(['name' => 'superAdmin','guard_name' => 'web','type'=>'admin']);

        $admin = Admin::where('email','admin@gmail.com')->where('role','admin')->first();
        if(!$admin){
            $admin = Admin::updateOrCreate([ 'username'=>'Admin', 'email'=>'admin@gmail.com'],[
                'name'=>'Admin',
                'username'=>'Admin',
                'email'=>'admin@gmail.com',
                'role'=>'admin',
                'password'=>123456,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
        if($superRole)
            $admin->syncRoles('superAdmin');
        /**
         *  get database tables
         */
        $dbTables = adminDbTablesPermissions();

        /**
         *  give permission on every database table
         */

        //  dd($dbTables);
        foreach ($dbTables as $table){
            if($table == 'brands_buttons' ){
                $readPermission =   Permission::create(['name' => 'read '.$table,'guard_name' => 'web']);
                $createPermission = Permission::create(['name' => 'create '.$table,'guard_name' => 'web']);
                $updatePermission = Permission::create(['name' => 'update '.$table,'guard_name' => 'web']);
                $deletePermission = Permission::create(['name' => 'delete '.$table,'guard_name' => 'web']);
                $branchesPermission = Permission::create(['name' => 'branches '.$table,'guard_name' => 'web']);
                $groupOfBrandPermission = Permission::create(['name' => 'groupOfBrand '.$table,'guard_name' => 'web']);
                $campaignsPermission = Permission::create(['name' => 'campaigns '.$table,'guard_name' => 'web']);
                $overviewPermission =   Permission::create(['name' => 'overview '.$table,'guard_name' => 'web']);
                $wishlistPermission = Permission::create(['name' => 'wishlist '.$table,'guard_name' => 'web']);
                $dislikePermission = Permission::create(['name' => 'dislike '.$table,'guard_name' => 'web']);
            }else{
                // admin permission
                $readPermission =   Permission::create(['name' => 'read '.$table,'guard_name' => 'web']);
                $createPermission = Permission::create(['name' => 'create '.$table,'guard_name' => 'web']);
                $updatePermission = Permission::create(['name' => 'update '.$table,'guard_name' => 'web']);
                $deletePermission = Permission::create(['name' => 'delete '.$table,'guard_name' => 'web']);
            }
            /**
             * assign permission to role
             */
            if($table == 'brands_buttons'){
                $superRole->givePermissionTo($readPermission,$createPermission, $updatePermission, $deletePermission, $overviewPermission, $branchesPermission, $groupOfBrandPermission, $campaignsPermission, $wishlistPermission,$dislikePermission);
            }else{
                $superRole->givePermissionTo($readPermission,$createPermission, $updatePermission, $deletePermission);
            }
            // $superRole->givePermissionTo($readPermission,$createPermission, $updatePermission, $deletePermission,$overviewPermission,$branchesPermission,$groupOfBrandPermission,$campaignsPermission,$wishlistPermission,$dislikePermission);
            /**
             * assign permission to user
             */
            if($admin){
                if($table == 'brands_buttons'){
                    $admin->givePermissionTo($readPermission,$createPermission, $updatePermission, $deletePermission,$overviewPermission,$branchesPermission,$groupOfBrandPermission,$campaignsPermission,$wishlistPermission,$dislikePermission);
                }else{
                    $admin->givePermissionTo($readPermission,$createPermission, $updatePermission, $deletePermission);
                }
            }
        }
    }
}
