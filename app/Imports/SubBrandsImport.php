<?php

namespace App\Imports;

use App\Http\Requests\Admin\ImportSubBrandsRequest;
use App\Models\Brand;
use App\Models\Country;
use App\Models\Subbrand;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use function Clue\StreamFilter\fun;

class SubBrandsImport implements ToCollection,WithHeadingRow,WithValidation
{

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $default_img = 'photos/brands/avatar.png';

        foreach ($rows as $row)
        {
            $brand = Brand::whereHas('user', function ($q) use ($row) {
                $q->where('users.user_name',$row['brand_user_name']);
            })->first();
            $country = Country::whereIn('code',$row['country_alpha_2_code']);
            $country_ids =   array_map('strval',$country->get()->pluck('id')->toArray());
            if ($brand && $country->exists()){
                Subbrand::create([
                    'name'     => $row['name'],
                    'brand_id'     => $brand->id,
                    'status'    => $row['status'],
                    'country_id'    => $country_ids,
                    'phone'    => $row['phone'],
                    'whats_number'    => $row['whatsapp'],
                    'preferred_gender'    => $row['preferred_gender'],
                    'image'    => $default_img,
                    'link_insta'    => $row['instagram'],
                    'link_facebook'    => $row['facebook'],
                    'link_tiktok'    => $row['tiktok'],
                    'link_snapchat'    => $row['snapchat'],
                    'link_twitter'    => $row['twitter'],
                    'link_website'    => $row['website'],
                ]);
            }

        }

    }
    public function prepareForValidation($data, $index)
    {
        $data['country_alpha_2_code'] = explode(',',$data['country_alpha_2_code']) ;

        return $data;
    }

    public function rules(): array
    {
        return [
            'name'=>'required|string|unique:subbrands,name',
            'status'=>'required|integer|in:0,1',
            'brand_user_name'=>'required|string|exists:users,user_name',
            'country_alpha_2_code'=>'required|array',
            'country_alpha_2_code.*'=>'required|string|exists:countries,code',
            'phone' => 'required|numeric|unique:subbrands,phone',
            'whatsapp' => 'required|numeric|unique:subbrands,whats_number',
            'preferred_gender' => 'required|string|in:male,female,both',
            'instagram' => 'required|string|unique:subbrands,link_insta',
            'facebook' => 'required|string|unique:subbrands,link_facebook',
            'tiktok' => 'required|string|unique:subbrands,link_tiktok',
            'snapchat' => 'required|string|unique:subbrands,link_snapchat',
            'twitter' => 'required|string|unique:subbrands,link_twitter',
            'website' =>'required|string|unique:subbrands,link_website',
        ];
    }
}
