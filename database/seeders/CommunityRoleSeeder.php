<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Permission;
use App\Models\Role;

class CommunityRoleSeeder extends Seeder
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
        $communityRole = Role::updateOrCreate(['name' => 'superCommunity','guard_name' => 'web','type'=>'community', 'parent_role' => $parent_role->id],
            ['name' => 'superCommunity','guard_name' => 'web','type'=>'community', 'parent_role' => $parent_role->id]);

        $community = Admin::where('email','community@gmail.com')->where('role','community')->first();
        if(!$community){
            $community = Admin::updateOrCreate([ 'username'=>'community', 'email'=>'community@gmail.com','role'=>'community'],[
                'name'=>'community',
                'username'=>'community',
                'email'=>'community@gmail.com',
                'role'=>'superCommunity',
                'password'=>123456,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
        if($communityRole)
            $community->syncRoles('superCommunity');
        /**
         *  get database tables
         */
        $dbTables = dbCommunityTables();

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
                $communityRole->givePermissionTo($permission);
                /**
                 * assign permission to user
                 */
                if($community)
                    $community->givePermissionTo($permission);
            }
        }
    }
}
