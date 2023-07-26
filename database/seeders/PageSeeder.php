<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title'=>['ar'=>'من نحن','en'=>'about'],
                'description'=>['ar'=>'من نحن','en'=>'about'],
                'slug'=>'about',
                'position'=>0,
                'status'=>1,
                'image'=>null,
                'created_by'=>1,
            ],
            [
                'title'=>["ar"=>"الشروط والاحكام","en"=>"terms"],
                'description'=>["ar"=>"الشروط والاحكام","en"=>"terms"],
                'slug'=>'terms',
                'position'=>0,
                'status'=>1,
                'image'=>null,
                'created_by'=>1,
            ]
        ];
        foreach($pages as $page)
            Page::updateOrCreate(["slug"=>$page['slug']],$page);
    }
}
