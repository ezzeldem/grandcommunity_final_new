<?php

namespace App\Http\Requests\Admin;

use App\Models\Country;
use App\Models\Influencer;
use App\Models\Nationality;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class InfluencerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = request()->route()->getActionMethod() == "update"?"update":"create";
        $entityData = is_object($this->route('influence'))?$this->route('influence'):Influencer::find((int)$this->route('influence'));
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

        $phone_same_as_whatsapp_required = "nullable|";


        $childInfoValidateStatus = "nullable";
        $childrenNum = (int) request('children_num');
        if($childrenNum > 0 && (count(array_filter(array_values(request('childname', [])))) < $childrenNum || count(array_filter(array_values(request('childdob', [])))) < $childrenNum || count(array_filter(array_values(request('childgender', [])))) < $childrenNum)){
            $childInfoValidateStatus = "required";
        }

        $Date_custom = date('1900-01-01');
        $rules = [
            'name' => 'required|min:3|max:100',
            'image' => 'sometimes|mimes:jpg,png,jpeg',
            'gender' => 'required|in:1,0',
            'country_visited_outofcountry' => 'required_if:active,7',
            'influencer_return_date' => 'required_if:active,7',
            'address' => 'sometimes|required|nullable|min:5|max:140',
//            'address' => 'sometimes|required_with:address_ar|nullable|min:5|max:140',
//            'address_ar' => 'sometimes|required_with:address|nullable|min:5|max:140',
            'expirations_date' => 'sometimes|nullable|date'.$expirationDateAfterToday,
            'country_id' => 'required|numeric|exists:countries,id',
            'children_num' => [new RequiredIf(\request('marital_status') != 1 && \request('marital_status'))],
            'date_of_birth' => 'required|nullable|date|before:today|after:' . $Date_custom,
            'nationality' => 'required',
//            'lang' => 'required',
            'main_phone_code' => 'required',
            'main_phone' => 'required',
//            'phone_code' => 'required',
            'marital_status' => 'numeric|in:1,2,3,4',
            'childname.*' => [new RequiredIf((int) \request('children_num') > 0)],
            'childdob.*' => [new RequiredIf((int) \request('children_num') > 0)],
            'childgender.*' => [new RequiredIf((int) \request('children_num') > 0)],
            'social.*.*' => 'required|string|min:1',
            'children_info' => $childInfoValidateStatus,
            'active' => "required"
        ];
        switch ($this->id) {
            case true:
                $rules += [
                    'password' => ['sometimes', 'nullable', 'min:8'],
                    'socail.*.instagram' => 'sometimes|required|string|regex:/^[a-zA-Z0-9$@$!%*?&#^-_. +]+$/|unique:influencers,insta_uname,' . $this->id . ',id,deleted_at,NULL',
                    // 'password'                     => 'sometimes', 'nullable', 'min:8', 'required_with:password_confirmation', 'confirmed', 'same:password_confirmation',
                    'whats_number'                    => $phone_same_as_whatsapp_required.'numeric|digits_between:6,14|unique:influencers,whats_number,' . $this->id . ',id,deleted_at,NULL',
                    'whatsapp_code'                   => $phone_same_as_whatsapp_required.'numeric|digits_between:1,5',
                    'socail.*.facebook'               => 'sometimes|required|nullable|string|unique:influencers,facebook_uname,' . $this->id . ',id,deleted_at,NULL',
                    'socail.*.tiktok'                 => 'sometimes|required|nullable|string|unique:influencers,tiktok_uname,' . $this->id . ',id,deleted_at,NULL',
                    'socail.*.snapchat'               => 'sometimes|required|nullable|string|unique:influencers,snapchat_uname,' . $this->id . ',id,deleted_at,NULL',
                    'socail.*.twitter'                => 'sometimes|required|nullable|string|unique:influencers,twitter_uname,' . $this->id . ',id,deleted_at,NULL',
                    'website_uname'                => 'sometimes|nullable|'.$validationWebsiteInputType.'|unique:influencers,website_uname,' . $this->id . ',id,deleted_at,NULL',
                    'email'                        => 'required|email|unique:users,email,' . $this->user_id . ',id,deleted_at,NULL',
                     'user_name'                    => 'required|string|min:3|max:100|unique:users,user_name,'.$this->user_id.',id,deleted_at,NULL|regex:/^[a-zA-Z0-9$@$!%*?&#^-_. +]+$/',
                ];
                break;
            case false:
                $rules += [
                    'password' => ['required', 'min:8'],
                    'whats_number' => $phone_same_as_whatsapp_required.'numeric|digits_between:6,14|unique:influencers,whats_number,NULL,id,deleted_at,NULL',
                    'whatsapp_code' => $phone_same_as_whatsapp_required.'numeric|digits_between:1,5',
                    'socail.*.facebook' => 'sometimes|required|nullable|string|unique:influencers,facebook_uname,NULL,id,deleted_at,NULL',
                    'socail.*.tiktok' => 'sometimes|required|nullable|string|unique:influencers,tiktok_uname,NULL,id,deleted_at,NULL',
                    'socail.*.snapchat' => 'sometimes|required|nullable|string|unique:influencers,snapchat_uname,NULL,id,deleted_at,NULL',
                    'socail.*.instagram' => 'sometimes|required|string|regex:/^[a-zA-Z0-9$@$!%*?&#^-_. +]+$/|max:255|unique:influencers,insta_uname,NULL,id,deleted_at,NULL',
                    'socail.*.twitter' => 'sometimes|required|nullable|string|unique:influencers,twitter_uname,NULL,id,deleted_at,NULL',
                    // 'password'                       => 'required', 'min:8', 'required_with:password_confirmation', 'confirmed', 'same:password_confirmation',
                    'website_uname'                  => 'sometimes|nullable|'.$validationWebsiteInputType.'|unique:influencers,website_uname,NULL,id,deleted_at,NULL',
                    'email'                          => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                    'user_name'                      => 'required|string|min:3|max:100|unique:users,user_name,Null,id,deleted_at,NULL|regex:/^[a-zA-Z0-9$@$!%*?&#^-_. +]+$/',

                ];
                break;
            default:
                break;
        }

        return $rules;
        // 'children.*.dob' => 'required',
    }

    protected function prepareForValidation()
    {
        if($websiteName = $this->get('website_uname')){
            $this->merge(['website_uname' => str_replace(['https://', 'http://'], ['', ''], $websiteName)]);
        }

        if($this->get('phone_same_as_whatsapp')){
            $this->merge(['whats_number' => $this->get('main_phone'), 'whatsapp_code' => $this->get('main_phone_code')]);
        }

        $country = Country::find((int) $this->get('country_id'));
        $nationality = Nationality::find((int) $this->get('nationality'));

        if($country && $nationality){
            if(strtolower($country->code) == strtolower($nationality->code)){
                $this->merge(['citizen_status' => 1]);
            }else{
                $this->merge(['citizen_status' => 2]);
            }
        }

        $this->merge(['has_voucher' => (int) $this->get('has_voucher')]);
    }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    // }
}
