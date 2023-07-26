<?php

namespace Database\Seeders;

use App\Models\Campaign;
use Illuminate\Database\Seeder;
use App\Models\CaseStudies;
use App\Models\CaseStudyCategory;
use App\Models\Category;
use App\Models\QuestionsAndAnswer;
use Faker\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

class CaseStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   
     // QuestionsAndAnswer::create(['question'=>['en'=>$facker->title,'ar'=>$facker_ar->title],'answer'=>['en'=>$facker->text,'ar'=>$facker_ar->text],'case_study_id'=>CaseStudies::all()->random()->id]);
 



    public function run()
    { 

        DB::table('case_studies')->truncate();
        $faker = Factory::create('de_DE');
       $channel =  [1,2,3];
       $camp = Campaign::select('id')->get();
       $image = ['202206291259download.jpg','202206291259download.jpg'];
       $real = 
        ['en'=>$faker->realText,'ar'=>$faker->realText];
    
       if($camp->count() > 0){
        foreach ($camp as $val) {
            CaseStudies::create(['total_followers'=>200,'total_influencers'=>2000,'campaign_type'=>1,'campaign_name'=>$val->id,'total_days'=>22,'real'=>json_encode($real,true),'image'=>json_encode($image,true) ,'category_id'=>Category::all()->random()->id,'client_profile_link'=>'https://www.instagram.com/','channels'=>json_encode($channel,true),'total_reals'=>10000]);
        }
       }
        


    }
}