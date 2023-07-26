<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InfluencerClassification;

class InfluencerStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InfluencerClassification::truncate();
       $classification =  ['Face','Speak','Fake','Hijab','Share','All Campagin'];
       $category = ['Vip','Only Delivery','Class A','Class B','Class C'];
       foreach($classification as $influencer_status){
        InfluencerClassification::create([
            'name'=>$influencer_status,
            'status'=>'influencer',
        ]);
       }

       foreach($category as $influencer_status){
        InfluencerClassification::create([
            'name'=>$influencer_status,
            'status'=>'category',
        ]);
       }
    }
}
