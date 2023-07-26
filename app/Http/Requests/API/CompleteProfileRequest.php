<?php

namespace App\Http\Requests\API;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\ValidationException;

class CompleteProfileRequest extends FormRequest
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
        $user_id = $this->user()->id;
        $rules = [
            'userData' => 'sometimes|nullable|array',
            'userData.password' => 'sometimes|nullable|string|min:6|confirmed',
            'brand' => 'sometimes|array',
        ];

        if ($this->user()->type == 1) {

            $Date_custom = date('1900-01-01');
            $influe_id = $this->user()->influencers->id;

            if ($this->request->has('step') && $this->step == 1) {
                $rules['brand.name'] = 'required|string';
                $rules['brand.email'] = 'required|email|unique:users,email,' . $user_id . ',id,deleted_at,NULL';

                $rules['brand.country_id'] = 'required|exists:countries,id';
                $rules['brand.city_id'] = 'nullable|numeric|exists:cities,id';
                $rules['brand.state_id'] = 'nullable|numeric|exists:states,id';
                $rules['brand.address'] = 'sometimes|required|string|min:3|max:100';

                $rules['brand.nationality'] = 'nullable|numeric|exists:nationalities,id';
                $rules['brand.gender'] = 'required|string|in:0,1';
                $rules['brand.date_of_birth'] = 'required|date|before:today|after:' . $Date_custom;
                $rules['brand.lang'] = 'nullable|array|min:1';
                $rules['brand.interest'] = 'nullable|array|min:1';
                $rules['brand.classification_ids'] = 'nullable|array|min:1';
                $rules['brand.coverage_channel'] = 'nullable|array|min:1';
                $rules['brand.job'] = 'nullable|numeric';

                $rules['brand.whatsapp'] = 'required|numeric|digits_between:6,14|unique:influencers,whats_number,' . $influe_id . ',id,deleted_at,NULL|unique:brands,whatsapp,' . $influe_id . '|unique:subbrands,whats_number,' . $influe_id;
                $rules['brand.code'] = 'required|not_in:0';
                $rules['brand.phone'] = 'required|numeric|regex:/^[0-9]+$/u|digits_between:6,14|unique:users,phone,' . $user_id . ',id,deleted_at,NULL';
                $rules['brand.phones.*'] = 'sometimes|array';
                $rules['brand.phones.*.phone'] = 'sometimes|numeric|regex:/^[0-9]+$/u|digits_between:6,14';
                $rules['brand.phones.*.phone_code'] = 'sometimes|not_in:0';

                $rules['brand.social.*'] = 'required|array|min:1';
                $rules['brand.social.*.facebook_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:influencers,facebook_uname,' . $influe_id . ',id,deleted_at,NULL|unique:brands,facebook_uname|unique:subbrands,link_facebook';
                $rules['brand.social.*.instagram_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:influencers,insta_uname,' . $influe_id . ',id,deleted_at,NULL|unique:brands,insta_uname|unique:subbrands,link_insta';
                $rules['brand.social.*.snapchat_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:influencers,snapchat_uname,' . $influe_id . ',id,deleted_at,NULL|unique:brands,snapchat_uname|unique:subbrands,link_snapchat';
                $rules['brand.social.*.tiktok_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:influencers,tiktok_uname,' . $influe_id . ',id,deleted_at,NULL|unique:brands,tiktok_uname|unique:subbrands,link_tiktok';
                $rules['brand.social.*.twitter_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:influencers,twitter_uname,' . $influe_id . ',id,deleted_at,NULL|unique:brands,twitter_uname|unique:subbrands,link_twitter';

                $rules['brand.website_uname'] = 'sometimes|nullable|url|unique:influencers,website_uname,' . $influe_id . ',id,deleted_at,NULL|unique:brands,website_uname|unique:subbrands,link_website';
                $rules['brand.req_img'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg';
            }

            if ($this->request->has('step') && $this->step == 2) {
                $rules['step'] = ['required', 'numeric', 'in:1,2,3'];
                $rules['social_data.social_type'] = ['required', 'numeric', 'in:1,2,3,4'];
                $rules['social_data.children_num'] = [new RequiredIf(\request('social_data.social_type') != 1 && \request('social_data.social_type'))];
                // $rules['social_data.children.name']      = [new RequiredIf(\request('social_data.children_num')  && \request('social_data.social_type') !=1 ),'array','min:'.\request('social_data.children_num'),'max:'.\request('social_data.children_num')];
                $rules['social_data.children.*.name'] = [new RequiredIf(\request('social_data.children_num') && \request('social_data.social_type') != 1), 'string'];
                // $rules['social_data.children.gender']    = [new RequiredIf(\request('social_data.children_num')  && \request('social_data.social_type') !=1),'array','min:'.\request('social_data.children_num'),'max:'.\request('social_data.children_num')];
                $rules['social_data.children.*.gender'] = [new RequiredIf(\request('social_data.children_num') && \request('social_data.social_type') != 1), 'string', 'in:0,1'];
                // $rules['social_data.children.DOB']       = [new RequiredIf(\request('social_data.children_num')  && \request('social_data.social_type') !=1 ),'array','min:'.\request('social_data.children_num'),'max:'.\request('social_data.children_num')];
                $rules['social_data.children.*.DOB'] = [new RequiredIf(\request('social_data.children_num') && \request('social_data.social_type') != 1), 'date', 'before:today'];

            }

            if (!$this->request->has('step')) {
                $rules['brand.country_id'] = 'required|exists:countries,id';
                $rules['brand.nationality'] = 'required|numeric|exists:nationalities,id';
                $rules['brand.gender'] = 'required|string|in:0,1';
                $rules['brand.date_of_birth'] = 'required|date|before:today|after:' . $Date_custom;
                $rules['brand.lang'] = 'required';
                $rules['brand.whatsapp'] = 'required|numeric|digits_between:6,14|unique:influencers,whats_number,' . $influe_id . ',id,deleted_at,NULL|unique:brands,whatsapp|unique:subbrands,whats_number';
                $rules['brand.job'] = 'required|numeric';
            }

            // $rules['brand.request_from'] = 'sometimes|nullable|string';
        } else {

            $brand_id = $this->user()->brands->id;

            $rules['brand.country_id.*'] = 'sometimes|exists:countries,id';
            $rules['brand.whatsapp'] = 'sometimes|numeric|digits_between:6,14|unique:brands,whatsapp,' . $brand_id . ',id,deleted_at,NULL|unique:influencers,whats_number';
            $rules['brand.social.*'] = 'required|array|min:1';
            $rules['brand.website_uname'] = 'sometimes|nullable|url|unique:brands,website_uname,' . $brand_id . ',id,deleted_at,NULL|unique:influencers,website_uname';
            $rules['brand.social.*.facebook_value'] = 'sometimes|required|max:50|regex:/^[a-zA-Z0-9_.-]*$/u|nullable|string|unique:brands,facebook_uname,' . $brand_id . ',id,deleted_at,NULL|unique:influencers,facebook_uname';
            $rules['brand.social.*.instagram_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:brands,insta_uname,' . $brand_id . ',id,deleted_at,NULL|unique:influencers,insta_uname';
            $rules['brand.social.*.snapchat_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:brands,snapchat_uname,' . $brand_id . ',id,deleted_at,NULL|unique:influencers,snapchat_uname';
            $rules['brand.social.*.tiktok_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:brands,tiktok_uname,' . $brand_id . ',id,deleted_at,NULL|unique:influencers,tiktok_uname';
            $rules['brand.social.*.twitter_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:brands,twitter_uname,' . $brand_id . ',id,deleted_at,NULL|unique:influencers,twitter_uname';
            $rules['brand.req_img'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg';

            if (request()->get("validate_sub_brand") == 1 || request()->get("step") == 2) {
                $rules['sub_brand'] = 'sometimes|nullable';
                $rules['sub_brand.country_id'] = 'sometimes|nullable';
                $rules['sub_brand.code_whats'] = 'sometimes';
                $rules['sub_brand.code_phone'] = 'sometimes';
                $rules['sub_brand.country_id'] = 'sometimes|nullable';
                $rules['sub_brand.country_id.*'] = 'sometimes|nullable|exists:countries,id';
                $rules['sub_brand.req_img'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg';
                $rules['sub_brand.name'] = 'sometimes|nullable|string|unique:subbrands,name,' . $brand_id . ',brand_id,deleted_at,NULL';

                if (!$this->user()->brands->subbrands()->exists()) {
                    $rules['sub_brand.preferred_gender'] = 'sometimes|nullable|string|in:male,female,both';
                    $rules['sub_brand.social.*.facebook_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_facebook|unique:influencers,facebook_uname|unique:brands,facebook_uname,' . $brand_id . ',id,deleted_at,NULL';
                    $rules['sub_brand.social.*.instagram_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_insta|unique:influencers,insta_uname|unique:brands,insta_uname,' . $brand_id . ',id,deleted_at,NULL';
                    $rules['sub_brand.social.*.snapchat_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_snapchat|unique:influencers,snapchat_uname|unique:brands,snapchat_uname,' . $brand_id . ',id,deleted_at,NULL';
                    $rules['sub_brand.social.*.tiktok_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_tiktok|unique:influencers,tiktok_uname,|unique:brands,tiktok_uname,' . $brand_id . ',id,deleted_at,NULL';
                    $rules['sub_brand.social.*.twitter_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:subbrands,link_twitter|unique:influencers,twitter_uname|unique:brands,twitter_uname,' . $brand_id . ',id,deleted_at,NULL';
                    $rules['sub_brand.link_website'] = 'sometimes|nullable|url|unique:subbrands,link_website|unique:influencers,website_uname|unique:influencers,website_uname|unique:brands,website_uname,' . $brand_id . ',id,deleted_at,NULL';
                    $rules['sub_brand.phone'] = 'sometimes|nullable|numeric|digits_between:6,14|unique:subbrands,phone';
                    $rules['sub_brand.whats_number'] = 'sometimes|nullable|numeric|digits_between:6,14|unique:subbrands,whats_number';
                } else {
                    $rules['sub_brand.preferred_gender'] = 'sometimes|nullable|string|in:male,female,both';
                    $rules['sub_brand.social.*.facebook_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string';
                    $rules['sub_brand.social.*.instagram_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string';
                    $rules['sub_brand.social.*.snapchat_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string';
                    $rules['sub_brand.social.*.tiktok_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string';
                    $rules['sub_brand.social.*.twitter_value'] = 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string';
                    $rules['sub_brand.link_website'] = 'sometimes|nullable|url';
                    $rules['sub_brand.phone'] = 'sometimes|nullable|numeric|digits_between:6,14';
                    $rules['sub_brand.whats_number'] = 'sometimes|nullable|numeric|digits_between:6,14';
                }
            }

            // branches
            if (request()->get("validate_branches") == 1) {
                $rules['branches'] = 'sometimes|nullable';
                $rules['branches.*'] = 'sometimes|nullable'; // send as object
                $rules['branches.*.address'] = 'sometimes|nullable|string';
                $rules['branches.*.city'] = 'sometimes|nullable|numeric|exists:cities,id';
                $rules['branches.*.state'] = 'sometimes|nullable|numeric|exists:states,id';
                $rules['branches.*.country_id'] = 'sometimes|nullable|numeric|exists:countries,id';
                $rules['branches.*.name'] = 'min:5|sometimes|nullable|string';
            }
        }

        return $rules;
    }

    public function messages()
    {
        if (app()->getLocale() == 'ar') {
            return [
                'brand.date_of_birth.before' => ' تاريخ الميلاد يجب أن يكون قبل اليوم وبعد 1990 .',
                'brand.date_of_birth.after' => ' تاريخ الميلاد يجب أن يكون قبل اليوم وبعد 1990 .',
                'brand.website_uname.url' => 'رابط الموقع يجب أن يكون صحيح .',
                'brand.req_img.mimes' => 'يجب ان تكون صورة  ',
                'sub_brand.req_img.image' => 'يجب ان تكون صورة.',

            ];
        } else {
            return [
                'brand.date_of_birth.before' => 'influencer birthday must be a date before today and after 1900.',
                'brand.date_of_birth.after' => 'influencer birthday must be a date before today and after 1900.',
                'brand.website_uname.url' => ' website must be a url.',
                'sub_brand.req_img.image' => 'upload only images.',
                'brand.req_img.mimes' => 'upload only images',

            ];
        }

    }

    protected function failedValidation(Validator $validator)
    {
        $response = $this->validationError($validator->errors());
        throw new ValidationException($validator, $response);
    }

}
