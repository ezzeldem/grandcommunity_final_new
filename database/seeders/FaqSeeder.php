<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $faker = Factory::create('de_DE');
        DB::table('faqs')->truncate();
        for ($i = 0; $i < 100; $i++) {
           $faqs[] = [
            
                'question'=> json_encode(['en' =>  $faker->sentence(mt_rand(3, 6), true) , 'ar' =>  $faker->sentence(mt_rand(3, 6), true)]),
                'answer'   =>  json_encode(['en' => $faker->paragraph() , 'ar' => $faker->paragraph()]),

           
        ];
    }
    $chunks = array_chunk($faqs, 20);
    foreach ($chunks as $chunk) {
        Faq::insert($chunk);
    }
       
    }
}
