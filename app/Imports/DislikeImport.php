<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\BrandDislike;
use App\Models\Influencer;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use phpDocumentor\Reflection\Types\Integer;

class DislikeImport implements ToCollection,WithHeadingRow,WithValidation, SkipsOnError
{
    use Importable,SkipsErrors;
    public $brand_id; 
    public function __construct($id)
    {
        $this->brand_id = $id;
        
    }
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();
            foreach ($rows as $row) {
                $brand = Brand::find($this->brand_id);
                $influencer = $brand->influencers()->where('insta_uname','LIKE','%'.$row['influncer_name'].'%')->first();
                $data = [
                    'influencer_id'=>$influencer->id,
                    'brand_id' => $this->brand_id,
                ];
                BrandDislike::create($data); 
                DB::commit();
            }
        }catch (\Exception $ex){
            DB::rollBack();
            return $ex;
        }
    }

    public function rules(): array
    {
        return [
            'influncer_name'=>'required|string|max:100',
          
        ];
    }
}
