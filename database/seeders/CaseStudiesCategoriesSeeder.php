<?php

namespace Database\Seeders;

use App\Models\CaseStudyCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseStudiesCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('case_study_categories')->truncate();
        $data = ['life style','food','healty','sport'];
        foreach ($data as $cat){
            CaseStudyCategory::create([
                'name' => $cat
            ]);
        }
    }
}
