<?php

namespace App\Http\Requests\API;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
        //email regex -> regex:/(\w+)@(\w+)\.(\w+)/i
        $rules = [
            'name' => 'required|string|min:3|max:50|unique:brands,name,NULL,id,deleted_at,NULL|not_in:' . checkDataNotRelatedToAdmin(request()->name),
            'user_name' => 'required|string|min:3|max:50|unique:users,user_name,NULL,id,deleted_at,NULL|not_in:' . checkDataNotRelatedToAdmin(request()->user_name),
            'email' => 'required|string|email:filter|unique:users,email,NULL,id,deleted_at,NULL|not_in:' . checkDataNotRelatedToAdmin(request()->email),
            'password' => ['required', 'min:8'],
            'type' => 'required|in:0,1',
            'terms' => 'required|boolean|in:true,1',
            'social.*' => 'required|array|min:1',
            'social.*.instagram_value' => 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:brands,insta_uname,NULL,id,deleted_at,NULL|unique:influencers,insta_uname,NULL,id,deleted_at,NULL',
            'social.*.facebook_value' => 'sometimes|required|max:50|regex:/^[a-zA-Z0-9_.-]*$/u|nullable|string|unique:brands,facebook_uname,NULL,id,deleted_at,NULL|unique:influencers,facebook_uname,NULL,id,deleted_at,NULL',
            'social.*.twitter_value' => 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:brands,twitter_uname,NULL,id,deleted_at,NULL|unique:influencers,twitter_uname,NULL,id,deleted_at,NULL',
            'social.*.snapchat_value' => 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:brands,snapchat_uname,NULL,id,deleted_at,NULL|unique:influencers,snapchat_uname,NULL,id,deleted_at,NULL',
            'social.*.tiktok_value' => 'sometimes|required|regex:/^[a-zA-Z0-9_.-]*$/u|max:50|nullable|string|unique:brands,tiktok_uname,NULL,id,deleted_at,NULL|unique:influencers,tiktok_uname,NULL,id,deleted_at,NULL',
            'country_id' => 'required|exists:countries,id',
            'code' => 'required|not_in:0',
            'phone' => 'required|numeric|regex:/^[0-9]+$/u|digits_between:6,14|unique:users,phone,NULL,id,deleted_at,NULL|unique:brands,whatsapp,NULL,id,deleted_at,NULL|unique:influencers,whats_number,NULL,id,deleted_at,NULL|unique:subbrands,whats_number,NULL,id,deleted_at,NULL',
        ];

        if (request()->type == 1) {
            $Date_custom = date('1900-01-01');
            $rules['address'] = 'required|string|min:3|max:100';
            $rules['date_of_birth'] = 'required|date|before:today|after:' . $Date_custom;
            $rules['nationality'] = 'required|numeric|exists:nationalities,id';
            $rules['gender'] = 'required|in:0,1';
        }

        return $rules;
    }

    public function messages()
    {
        if(app()->getLocale()=='ar')
            return [
                'date_of_birth.before' => ' تاريخ الميلاد يجب أن يكون قبل اليوم وبعد 1990 .',
                'date_of_birth.after' => ' تاريخ الميلاد يجب أن يكون قبل اليوم وبعد 1990 .',
            ];
        else
            return [
                'date_of_birth.before' => ' Date of birth must be before today and after 1990 .',
                'date_of_birth.after' => ' Date of birth must be before today and after 1990 .',
            ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = $this->validationError($validator->errors());
        throw new ValidationException($validator, $response);
    }
}
