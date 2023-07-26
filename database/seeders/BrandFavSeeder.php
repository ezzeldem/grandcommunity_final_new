<?php

namespace Database\Seeders;

use App\Models\BrandFav;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class BrandFavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       BrandFav::create([
            'brand_id' =>'619cacbe480f000094007fc5' ,
            'influencer_id' => '619cff2f480f000094007fc8',
            'date'  => now(),
            'source' =>'INSTAGRAM',
           'deleted_at'=>now()
        ]);


    }
}
