<?php

namespace Database\Seeders;

use App\Models\SecretPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecretPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('secret_permissions')->truncate();
        $permissions = [
            ['name'=>'show Scanner Page'],
            ['name'=>'Show Reports'],
            ['name'=>'Show Delivery Page'],
            ['name'=>'Search Manually'],
            ['name'=>'Show Confirmation'],
            ['name'=>'Show Pdf Report']
        ];
        SecretPermission::insert($permissions);
    }
}
