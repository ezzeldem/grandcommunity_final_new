<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Category::truncate();
        $categories=['Foods','Drinks','Fashion','Perfumes','Media','Medical','Companies'];
        $categories_icons=['fas fa-pizza-slice','fas fa-cocktail','fas fa-tshirt','fas fa-air-freshener','fas fa-icons','fas fa-briefcase-medical','fas fa-building'];
        for ($i=0;$i< count($categories);$i++){
            Category::create([
                'title' => $categories[$i],
                'icon'  => $categories_icons[$i]
            ]);
        }

    }
}
