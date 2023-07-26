<?php

namespace Database\Seeders;

use App\Models\Social;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('socials')->delete();
        Social::create(['name'=>'facebook']);
        Social::create(['name'=>'insatgram']);
        Social::create(['name'=>'snapchat']);
        Social::create(['name'=>'twitter']);
        Social::create(['name'=>'linkedin']);
    }
}
