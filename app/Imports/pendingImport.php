<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class pendingImport implements ToCollection,WithHeadingRow,WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
         
        foreach ($rows as $row)
        {
  
            
           
        }
    }

    public function rules(): array
    {
        return [
            "insatgram_username" => "abdullah",
            "snapchat_username" => "www.snapshat",
            "fullname" => "fulname",
            "country" => "egypt",
            "socials" => 'null',
            "followers" => 'null',
            "engagment" => 'null',
            "qrcode_status" => 'null',
            "confirm_date" => 'null',
            "influencer_status" => 'null',
            "branches" => 'null',
            "coverages_status" => 'null',
            "coverages_date" => 'null',
            "brief" => 'null',
            "languages" => 'null',
            "voerages" => 'null',
            "rate" => 'nullable',
            "role" => 'nullable',
           
        ];
    }
}

