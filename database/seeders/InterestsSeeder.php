<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Seeder;

class InterestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Interest::truncate();
        $interests=['interest 1','interest 2','interest 3', 'interest 3','interest 5','interest 6'];

        for ($i=0;$i< count($interests);$i++){
            Interest::create([
                'interest' => $interests[$i],
                'status' => 1,
            ]);
        }

    }
}
