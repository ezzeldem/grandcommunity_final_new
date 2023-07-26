<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Country;
use App\Models\Job;
use App\Models\Subbrand;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class JobsImport implements  ToCollection,WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {

        foreach ($rows->toArray() as $row)
        {

            Job::create([
                "name"=>["en"=>$row['marketing_coordinator'] ,"ar"=>$row['mnsk_tsoyk_tsoyk']],
                'status'=>1,
            ]);
        }

    }


}
