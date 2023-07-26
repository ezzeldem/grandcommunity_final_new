<?php

namespace App\Http\Requests\API\BrandDashboard;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SubBrandRequest extends FormRequest
{
    use ResponseTrait;
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
        $brand_id = isset($this->brand_id)? $this->brand_id : @auth()->user()->brands->id;

        if(!$this->sub_brand){
            $rules = [
                "name" => ['required', 'string',
                    Rule::unique('subbrands', 'name')
                        ->where(function ($query)use($brand_id){return $query->where('brand_id', $brand_id)->whereDeletedAt(null);})
                ],
                "brand_id" => "sometimes|nullable|string|exists:brands,id",
                "country_id.*" =>"required",
                "preferred_gender" => "required|string|in:male,female,both",
                "phone" => "required|numeric|digits_between:6,14|unique:subbrands,phone",
                "whats_number" => "required|numeric|digits_between:6,14|unique:subbrands,whats_number",
                "code_whats" => "required|numeric",
                "code_phone" => "required|numeric",
				'social.*'=>'required|array|min:1',
                "social.*.instagram_value" => "sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_insta|unique:influencers,insta_uname|unique:brands,insta_uname",
                "social.*.facebook_value" => "sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_facebook|unique:influencers,facebook_uname|unique:brands,facebook_uname",
                "social.*.tiktok_value" => "sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_tiktok|unique:influencers,tiktok_uname|unique:brands,tiktok_uname",
                "social.*.snapchat_value" => "sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_snapchat|unique:influencers,snapchat_uname|unique:brands,snapchat_uname",
                "social.*.twitter_value" => "sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_twitter|unique:influencers,twitter_uname|unique:brands,twitter_uname",
                "link_website" => "sometimes|nullable|url|unique:subbrands,link_website|unique:influencers,website_uname|unique:brands,website_uname",
				'image'=>'sometimes|nullable'

            ];
        }else{
            $rules = [
                "name" => "sometimes|nullable|string|unique:subbrands,name,".$this->sub_brand,
                "brand_id" => "sometimes|nullable|string|exists:brands,id",
                "country_id.*" =>"sometimes",
                "preferred_gender" => "sometimes|nullable|string|in:male,female,both",
                "phone" => "sometimes|nullable|numeric|digits_between:6,14|unique:subbrands,phone,".$this->sub_brand,
                "whats_number" => "sometimes|nullable|numeric|digits_between:6,14|unique:subbrands,whats_number,".$this->sub_brand,
                "code_whats" => "sometimes|nullable|numeric",
                "code_phone" => "sometimes|nullable|numeric",
				'social.*'=>'required|array|min:1',
                "social.*.instagram_value" => "sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_insta,".$this->sub_brand."|unique:influencers,insta_uname|unique:brands,insta_uname",
                "social.*.facebook_value" => "sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_facebook,".$this->sub_brand."|unique:influencers,facebook_uname|unique:brands,facebook_uname",
                "social.*.tiktok_value" => "sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_tiktok,".$this->sub_brand."|unique:influencers,tiktok_uname|unique:brands,tiktok_uname",
                "social.*.snapchat_value" => "sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_snapchat,".$this->sub_brand."|unique:influencers,snapchat_uname|unique:brands,snapchat_uname",
                "social.*.twitter_value" => "sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_twitter,".$this->sub_brand."|unique:influencers,twitter_uname|unique:brands,twitter_uname",
                "link_website" => "sometimes|nullable|url|unique:subbrands,link_website,".$this->sub_brand."|unique:influencers,website_uname|unique:brands,website_uname",
				'image'=>'sometimes|nullable'

            ];
        }
       return  $rules;
    }

	protected function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors());
        throw new ValidationException($validator, $response);
    }
}
