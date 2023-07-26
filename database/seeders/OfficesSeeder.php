<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class OfficesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offices')->delete();

        $active_countries = Country::where('active', 1)->get();
        $offices = [];
        foreach($active_countries as $country){
            array_push($offices, array($country->name.' Office', $country->id, 1));
        }
        
        $filter_office = [];
        foreach ($offices as $office){
            array_push($filter_office,array('name' => $office[0], 'country_id'=> $office[1], "status" => $office[2]));
        }
        DB::table('offices')->insert($filter_office);
    }
}
