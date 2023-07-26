<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'company_name'=>'required|string|max:100',
            'image' => 'required_without:id|mimes:jpg,png,jpeg',
            'banner' => 'image|mimes:jpg,png,jpeg',
            'homepage_pic' => 'required_without:id|mimes:jpg,png,jpeg',
            'influencers_count'=>'required|numeric',
            'campaign_count'=>'required|numeric',
            'country_count'=>'required|numeric',
            'facebook'=>'required',
            'twitter'=>'required',
            'instagram'=>'required',
            'snapchat'=>'required',
            'linkedin'=>'required',
            'account_verification_limit'=>'required|numeric',
            'google_play'=>'required|url',
            'app_store'=>'required|url',
            'phone'=>'required|numeric',
            'email'=>'required|email',
            'location'=>'required|max:200',
            'slogan'=>'required|max:220',
        ];
        return  $rules;

    }
}
