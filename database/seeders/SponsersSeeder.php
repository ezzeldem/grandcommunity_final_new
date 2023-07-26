<?php

namespace Database\Seeders;

use App\Models\OurSponsors;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SponsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('our_sponsors')->delete();
        for($i=0; $i < 6; $i++){
            OurSponsors::create([
                'title' => 'Grand Community',
                'image' =>  asset('/assets/img/brand/logo.png') ,
                'status' => 1,
            ]);
        }

    }
}
