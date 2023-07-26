<?php

namespace Database\Seeders;

use App\Imports\JobsImport;
use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->truncate();
        Excel::import(new JobsImport(), public_path('front\excel\jobs.xlsx'));
    }
}
