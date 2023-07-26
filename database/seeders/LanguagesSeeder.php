<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->truncate();
        $data=[
            'Arabic' => 'عريي',
            'English' => 'انجليزي',
            'French' => 'فرنسي',
        ];
        foreach ($data as $key => $value){
            Language::create([
                'name_en'=>$key,
                'name_ar'=>$value
            ]);
        }

    }
}
