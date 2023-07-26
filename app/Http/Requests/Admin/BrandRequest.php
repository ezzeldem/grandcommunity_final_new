<?php

namespace App\Http\Requests\Admin;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BrandRequest extends FormRequest
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
    public function rules(){
        $method = request()->route()->getActionMethod() == "update"?"update":"create";
        $entityData = is_object($this->route('brand'))?$this->route('brand'):Brand::find((int)$this->route('brand'));
        $expirationDateAfterToday = "|after:today";
        if($method == "update"){
            if($entityData && $entityData->expirations_date == request('expirations_date')){
                $expirationDateAfterToday = "";
            }
        }
        $validationWebsiteInputType = "url";
        if(filter_var("http://".request('website_uname'), FILTER_VALIDATE_URL) !== false){
            $validationWebsiteInputType = "string";
        }

        $phone_same_as_whatsapp_required = "required|";
        if(request('phone_same_as_whatsapp')){
            $phone_same_as_whatsapp_required = "nullable|";
        }

        $brand_id = (int)$this->brand;
        $user_id = (int)$this->user_id;
        $rules = [
            'name'=>'required|string|min:2|max:100|unique:brands,name,NULL,id,deleted_at,NULL',
            'user_name'=>'required|min:4|string|max:100|unique:users,user_name,NULL,id,deleted_at,NULL',
            'email'=>'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'main_phone'=>'required|numeric|digits_between:6,14|unique:subbrands,phone,NULL,id,deleted_at,NULL',
            'password' => ['required', 'min:8' ],
            // 'password' => ['required', 'min:8', 'required_with:password_confirmation', 'same:password_confirmation' ],
            // 'password_confirmation' => 'required|min:8',
            'main_phone_code' => 'required',
            'whatsapp' => $phone_same_as_whatsapp_required.'numeric|digits_between:6,14|unique:subbrands,whats_number,NULL,id,deleted_at,NULL',
            'whatsapp_code'=>$phone_same_as_whatsapp_required.'min:1',
            'image' => 'mimes:jpg,png,jpeg',
            'status' => 'required|in:1,0,2,3',
            'country_id'=>'required|array|min:1',
            // 'office_id'=>'required',
            'socail.*.instagram'             => 'sometimes|required|string|regex:/^[a-zA-Z0-9$@$!%*?&#^-_. +]+$/|max:255|unique:brands,insta_uname,NULL,id,deleted_at,NULL',
            'socail.*.facebook'                 => 'sometimes|required|nullable|string|unique:brands,facebook_uname,NULL,id,deleted_at,NULL',
            'socail.*.tiktok'                   => 'sometimes|required|nullable|string|unique:brands,tiktok_uname,NULL,id,deleted_at,NULL',
            'socail.*.snapchat'                 => 'sometimes|required|nullable|string|unique:brands,snapchat_uname,NULL,id,deleted_at,NULL',
            'socail.*.twitter'                  => 'sometimes|required|nullable|string|unique:brands,twitter_uname,NULL,id,deleted_at,NULL',
            'website_uname'                  => 'sometimes|nullable|'.$validationWebsiteInputType.'|unique:brands,website_uname,NULL,id,deleted_at,NULL',
            'expirations_date'=>'sometimes|nullable'.$expirationDateAfterToday,

            'socials.*' => 'required|array|min:1'
        ];
        if($this->method() == 'PUT' || $this->method() == 'PATCH'){
            $rules = [
                'name'=>'required|string|min:2|max:100|unique:brands,name,'.$brand_id.',id,deleted_at,NULL',
                'user_name'=>'required|string|max:100|unique:users,user_name,'.$user_id.',id,deleted_at,NULL',
                'email'=>'required|email|unique:users,email,'.$user_id.',id,deleted_at,NULL',
                'main_phone'=>'required|numeric|digits_between:6,14|unique:subbrands,phone,'.$brand_id.',brand_id',
                // 'password'=>'sometimes|nullable|confirmed|min:8',
                'password'=>'sometimes|nullable|min:8',
                'whatsapp' => $phone_same_as_whatsapp_required.'numeric|digits_between:6,14|unique:subbrands,whats_number,'.$brand_id.',brand_id',
                'whatsapp_code'=>$phone_same_as_whatsapp_required.'min:1',
                'main_phone_code' => 'required',
                'image' => 'required_without:id|mimes:jpg,png,jpeg',
                'status' => 'required|in:1,0,2,3',
                'country_id'=>'required|array|min:1',
                //'office_id'=>'required',
                // unique: influencers ['insta_uname', 'facebook_uname', 'tiktok_uname', 'snapchat_uname', 'twitter_uname', 'website_uname', 'whatsapp', 'main_phone']
                // unique: subbrands ['insta_uname', 'facebook_uname', 'tiktok_uname', 'snapchat_uname', 'twitter_uname', 'website_uname', 'whatsapp', 'main_phone']
                'socail.*.instagram'                  => 'sometimes|required|string|regex:/^[a-zA-Z0-9$@$!%*?&#^-_. +]+$/|unique:brands,insta_uname,'.$brand_id.',id,deleted_at,NULL',
                'socail.*.facebook'               => 'sometimes|required|nullable|string|unique:brands,facebook_uname,'.$brand_id.',id,deleted_at,NULL',
                'socail.*.tiktok'                 => 'sometimes|required|nullable|string|unique:brands,tiktok_uname,'.$brand_id.',id,deleted_at,NULL',
                'socail.*.snapchat'               => 'sometimes|required|nullable|string|unique:brands,snapchat_uname,'.$brand_id.',id,deleted_at,NULL',
                'socail.*.twitter'                => 'sometimes|required|nullable|string|unique:brands,twitter_uname,'.$brand_id.',id,deleted_at,NULL',
                'website_uname'=>'sometimes|nullable|'.$validationWebsiteInputType.'|unique:brands,website_uname,'.$brand_id.',id,deleted_at,NULL',
                'expirations_date'=>'sometimes|nullable'.$expirationDateAfterToday,
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return[
            'name.required' => 'The brand name field is required',
            'user_name.required' => 'The username field is required',
            'email.required' => 'The email field is required',
            'main_phone.required' => 'The main phone number field is required',

            'password.required' => 'The password field is required',
            // 'password_confirmation.required' => 'The password confirmation field is required',
            'main_phone_code.required' => 'The country code is required',
            'whatsapp.required' => 'The WhatsApp phone number field is required',
            'whatsapp_code.required' => 'The country code is required',

            'image.required' => 'The image field is required',
            'status.required' => 'The status field is required',
            'country_id.required' => 'The countries field is required',
            'office_id.required' => 'The offices field is required',
            'insta_uname.required' => 'The Instagram username field is required',
            'facebook_uname.required' => 'The Facebook username field is required',
            'tiktok_uname.required' => 'The TikTok username field is required',
            'snapchat_uname.required' => 'The Snapchat username field is required',
            'twitter_uname.required' => 'The Twitter username field is required',
            'website_uname.required' => 'The Website username field is required',
            'expirations_date.required' => 'The expiration date field is required',

            'branches.required' => 'Please insert a branch first',
        ];
    }

    protected function prepareForValidation()
    {
        if($websiteName = $this->get('website_uname')){
            $this->merge(['website_uname' => str_replace(['https://', 'http://'], ['', ''], $websiteName)]);
        }

        if($this->get('phone_same_as_whatsapp')){
            $this->merge(['whatsapp' => $this->get('main_phone'), 'whatsapp_code' => $this->get('main_phone_code')]);
        }
    }

    // public function failedValidation(Validator $validator){
    //     throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    // }

}
