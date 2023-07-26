<?php

namespace App\Http\Requests\API\BrandDashboard;

use http\Env\Response;
use Illuminate\Validation\Rule;
use App\Http\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class EditProfile extends FormRequest
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
     * @return array
     */
    public function validationData(){
        if(!is_file($this['image']))
            return $this->except(['image']);
        return $this->all();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = isset($this->id) ? $this->id : auth()->user()->brands->id;
        $brandId = auth()->user()->brands->id;
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        return [
            "image" => "sometimes|nullable|image",
            // "phone" => "sometimes|array",
            "phone" => "sometimes|nullable|numeric|digits_between:6,14",
            // "phone_code" => "sometimes|array",
            "code" => "sometimes|nullable|numeric",
            "address" => "sometimes|nullable|string|min:3|max:250",
            "name" => "sometimes|nullable|string|min:3|max:200",
            "password" => "sometimes|nullable|string|min:8|max:150|confirmed",
			'social.*'=>'required|array|min:1',
			"social.*.instagram_value" => "sometimes|nullable|string|min:3|max:200|".Rule::unique('brands', 'insta_uname')->ignore($brandId),
            "social.*.facebook_value" => "sometimes|nullable|string|min:3|max:200|".Rule::unique('brands', 'facebook_uname')->ignore($brandId),
            "social.*.tiktok_value" => "sometimes|nullable|string|min:3|max:200|".Rule::unique('brands', 'tiktok_uname')->ignore($brandId),
            "social.*.snapchat_value" => "sometimes|nullable|string|min:3|max:200|".Rule::unique('brands', 'snapchat_uname')->ignore($brandId),
            "social.*.twitter_value" => "sometimes|nullable|string|min:3|max:200|".Rule::unique('brands', 'twitter_uname')->ignore($brandId),
            "website_uname" => "nullable|".Rule::unique('brands', 'website_uname')->ignore($brandId),
            "whatsapp_code" => "sometimes|nullable|numeric|digits_between:1,6",
            "sometimes|nullable|numeric|digits_between:6,14|".Rule::unique('brands', 'whatsapp')->ignore($brandId),
            "id" => "sometimes|nullable|numeric|exists:users,id",
        ];
    }



    // public function messages()
    // {

    //     return [
    //         "insta_uname.unique" => 'insta_unique',
    //         "facebook_uname.unique" => 'face_unique',
    //         "tiktok_uname.unique" => 'tiktok_unique',
    //         "snapchat_uname.unique" => 'snap_unique',
    //         "twitter_uname.unique" => 'twitter_unique',
    //         "website_uname.unique" => 'website_unique',
    //         "website_uname.url" => 'website_valid_url',

    //         "insta_uname.min" => 'insta_min',
    //         "facebook_uname.min" => 'face_min',
    //         "tiktok_uname.min" => 'tiktok_min',
    //         "snapchat_uname.min" => 'snap_min',
    //         "twitter_uname.min" => 'twitter_min',

    //         "insta_uname.max" => 'insta_max',
    //         "facebook_uname.max" => 'face_max',
    //         "tiktok_uname.max" => 'tiktok_max',
    //         "snapchat_uname.max" => 'snap_max',
    //         "twitter_uname.max" => 'twitter_max',
    //     ];
    // }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors());
        throw new ValidationException($validator, $response);
    }
}
