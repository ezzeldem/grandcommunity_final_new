<?php

namespace App\Imports;

use App\Http\Traits\FileAttributes;
use App\Models\Brand;
use App\Models\Country;
use App\Models\Influencer;
use App\Models\Setting;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithValidation;


class BrandImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param array $rows
    *
    */
    public function collection(Collection $rows)
    {
            foreach ($rows as $row) {
                $row['user_id'] = $this->createUser($row);
                $this->createBrand($row);
                DB::commit();
            }
    }
    public function createUser($user){
        $setting = Setting::first();
        $user=User::create([
            'user_name' => $user['user_name'],
            'email' => $user['email'],
            'code' =>$user['main_phone_code'],
            'phone' =>$user['main_phone'],
            'password' => $user['password'],
            'forget_code' => $setting->send_mail ? generateCode() : null,
            'forget_at' => $setting->send_mail ?now() : null,
            'type' => 1
        ]);
        return $user->id;
    }
    public function createBrand($rows){
        $countries_ids = Country::whereIn('code',explode(',',$rows['country_alpha_2_code']))->pluck('id')->toArray();
        Brand::create([
            'user_id' => $rows['user_id'],
            'name' => $rows['name'],
            'code_whats' => $rows['whatsapp_code'],
            'whatsapp' => $rows['whatsapp'],
            'country_id' =>$countries_ids,//($countries_ids)?array_map('strval', $countries_ids->toArray()):'',
            'status' => 2,
            'expirations_date'    => date(json_decode($rows['expirations_date'])),
            'insta_uname'    => $rows['instagram']??'',
            'facebook_uname'    => $rows['facebook']??'',
            'tiktok_uname'    => $rows['tiktok']??'',
            'snapchat_uname'    => $rows['snapchat']??'',
            'twitter_uname'    => $rows['twitter']??'',
        ]);
    }



    public function  rules(): array {
        return [
            '*.user_name' => 'required|unique:users,user_name',
            '*.name' => 'required|unique:brands,name',
            '*.email' => 'required|unique:users,email',
            '*.main_phone_code' => 'required',
            '*.main_phone' => 'required|unique:users,phone',
            '*.whatsapp_code' => 'required',
            '*.whatsapp' => 'required|unique:brands,whatsapp',
            '*.instagram' => 'unique:brands,insta_uname|unique:influencers,insta_uname',
            '*.facebook' => 'unique:brands,facebook_uname|unique:influencers,facebook_uname',
            '*.tiktok' => 'unique:brands,tiktok_uname|unique:influencers,tiktok_uname',
            '*.snapchat' => 'unique:brands,snapchat_uname|unique:influencers,snapchat_uname',
            '*.twitter' => 'unique:brands,twitter_uname|unique:influencers,twitter_uname',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.user_name.unique' => 1,
            '*.name.unique' => 1,
            '*.email.unique' => 1,
            '*.whatsapp.unique' => 1,
            '*.instagram.unique' => 1,
            '*.facebook.unique' => 1,
            '*.tiktok.unique' => 1,
            '*.snapchat.unique' => 1,
            '*.twitter.unique' => 1,

            '*.user_name.required' => 2,
            '*.name.required' => 2,
            '*.gender.required' => 2,
            '*.status.required' => 2,
            '*.main_phone.required' => 2,
            '*.whatsapp_code.required' => 2,
            '*.email.required' => 2,
            '*.main_phone_code.required' => 2,
            '*.whatsapp.required' => 2,
            '*.instagram.required' => 2,
            '*.facebook.required' => 2,
            '*.tiktok.required' => 2,
            '*.snapchat.required' => 2,
            '*.twitter.required' => 2,

            '*.gender.in' => 3,


        ];
    }

}
