<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Country;
use App\Models\Subbrand;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BranchsImport implements  ToCollection,WithHeadingRow,WithValidation
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $subBrand = Subbrand::where('name',$row['subbrnad_name']);
            $country = Country::where('code',$row['country_alpha_2_code']);
            if ($subBrand->exists() && $country->exists()) {
                Branch::create([
                    'name' => $row['name'],
                    'subbrand_id' =>$subBrand->first()->id,
                    'status' => $row['status'],
                    'country_id' => $country->first()->id,
                    'city' => $row['city'],
                ]);
            }
        }

    }

    public function rules(): array
    {
        return [
            'name'=>'required|string',
            'status'=>'required|integer|in:0,1',
            'country_alpha_2_code'=>'required|string|exists:countries,code',
            'city'=>'required|string',
            'subbrnad_name'=>'required|string|exists:subbrands,name',
        ];
    }
}
