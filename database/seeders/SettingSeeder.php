<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();
        Setting::create([
            'company_name' => 'Grand Community',
            'image' =>  asset('/assets/img/brand/logo.png') ,
            'homepage_pic' => 'test',
            'influencers_count' => '2000',
            'campaign_count' => '250',
            'country_count' => '13',
            'facebook' => 'grand_community',
            'twitter' => 'grand_community',
            'instagram' => 'grand_community',
            'snapchat' => 'grand_community',
            'linkedin' => 'grand_community',
            'account_verification_limit' => 2,
            'google_play' => 'https://www.apple.com/eg/app-store/grand_community',
            'app_store' => 'https://play.google.com/store?utm_source=emea_Med&utm_medium=hasem&utm_content=Sep2020&utm_campaign=Evergreen&pcampaignid=MKT-EDR-emea-eg-1001280-Med-hasem-py-Evergreen-Sep2020-Text_Search_BKWS%7cONSEM_kwid_43700009237562142&gclid=CjwKCAiAtouOBhA6EiwA2nLKH_7S7NJKYA1ZkBDPTJFxRzsoHzuKYF2HMCxER4NQfEkmFN71vUekbBoCJuQQAvD_BwE&gclsrc=aw.ds',
            'phone' => '01525875865',
            'email' => 'grand_community@gmail.com',
            'location' => 'mansoura',
            'slogan' => 'Now... worked man yes',
        ]);
    }
}
