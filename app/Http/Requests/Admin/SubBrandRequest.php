<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubBrandRequest extends FormRequest
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
        $sub_brand_id =$this->sub_brand??'';
        if(is_object($sub_brand_id)){
            $sub_brand_id = $sub_brand_id->id;
        }
        $validationWebsiteInputType = "url";
        if(filter_var("http://".request('link_website'), FILTER_VALIDATE_URL) !== false){
            $validationWebsiteInputType = "string";
        }

        $rules = [
            //"subbrand_name" => ['required', 'string',
            //    Rule::unique('subbrands', 'name')
            //        ->where(function ($query){return $query->where('brand_id',  request()->brand_id)->whereDeletedAt(null);})
            //],
            "name"          => "required|string|unique:subbrands,name",
            "brand_id"      => "required|string|exists:brands,id",
            "country_id"    => "required|array",
            "country_id.*"  => "required",
            "preferred_gender" => "required|string|in:male,female,both",
            "phone"         => "required|numeric|unique:subbrands,phone|digits_between:6,14",
            "status"        => "required|integer|in:0,1,2",
            "whats_number"  => "required|numeric|unique:subbrands,whats_number|digits_between:6,14",
            "link_insta"    => "required|string|unique:subbrands,link_insta",
            "link_facebook" => "sometimes|nullable|string|unique:subbrands,link_facebook",
            "link_tiktok"   => "sometimes|nullable|string|unique:subbrands,link_tiktok",
            "link_snapchat" => "sometimes|nullable|string|unique:subbrands,link_snapchat",
            "link_twitter"  => "sometimes|nullable|string|unique:subbrands,link_twitter",
            "link_website"  => "sometimes|nullable|".$validationWebsiteInputType."|unique:subbrands,link_website",
            "image"         => "nullable|sometimes|image|mimes:jpg,jpeg,png",
            //"code_whats"    => "required|numeric",
            //"code_phone"    => "required|numeric",
            //"branches"      => "required",
        ];

        if($this->method() == 'PUT' || $this->method() == 'PATCH'){
            //dd($this->all());
            $rules['name']          =   "required|string|unique:subbrands,name,$sub_brand_id";
            $rules['phone']         =   "required|string|digits_between:6,14|unique:subbrands,phone,$sub_brand_id";
            $rules['whats_number']  =   "required|string|digits_between:6,14|unique:subbrands,whats_number,$sub_brand_id";
            $rules['link_insta']    =   "sometimes|nullable|string|unique:subbrands,link_insta,$sub_brand_id";
            $rules['link_facebook'] =   "sometimes|nullable|string|unique:subbrands,link_facebook,$sub_brand_id";
            $rules['link_tiktok']   =   "sometimes|nullable|string|unique:subbrands,link_tiktok,$sub_brand_id";
            $rules['link_snapchat'] =   "sometimes|nullable|string|unique:subbrands,link_snapchat,$sub_brand_id";
            $rules['link_twitter']  =   "sometimes|nullable|string|unique:subbrands,link_twitter,$sub_brand_id";
            $rules['link_website']  =   "sometimes|nullable|".$validationWebsiteInputType."|unique:subbrands,link_website,$sub_brand_id";
            $rules['branches']      =   "sometimes|nullable";
            $rules['status']        =   "required|integer|in:0,1";
        }
        return  $rules;
    }

    public function messages()
    {
        return [
            'name.required'=>'Brand Name Field is Required',
            'name.unique'=>'Brand Name Already been taken',
            'preferred_gender.required'=>"Preferred Influencer Gender Field Is Required",
            'subbrand_status.required'=>"Brand Status Field is Required",
            'country_id.required'=>'Country Field Is Required'
        ];
    }

    protected function prepareForValidation()
    {
        if($websiteName = $this->get('link_website')){
            $this->merge(['link_website' => str_replace(['https://', 'http://'], ['', ''], $websiteName)]);
        }
    }

    // public function failedValidation(Validator $validator){
    //     // throw new HttpResponseException(response()->json(['errors'=>$validator->errors()],422));
    //     throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    // }

}
