<?php

namespace App\Http\Requests\API;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ForgetPassword extends FormRequest
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
        $customValidation = (\request('send_type')==='email')?'email|min:5|exists:users,email,deleted_at,NULL':'numeric|digits_between:6,14|exists:users,phone,deleted_at,NULL';
        if(Route::currentRouteName() == 'forget.step1'){
           $rules = [
                'send_type'=>'required|string|in:email,phone',
                'send_to'=>'required|'.$customValidation,
           ];
       }elseif(Route::currentRouteName() == 'forget.step2'){
           $rules = [
               'send_type'=>'required|string|in:email,phone',
               'send_to'=>'required|'.$customValidation,
               'code'=>'required|numeric|digits:6|exists:users,forget_code'
           ];
       }elseif(Route::currentRouteName() == 'forget.step3'){
            $rules = [
                'send_type'=>'required|string|in:email,phone',
                'send_to'=>'required|'.$customValidation,
                'password' => ['required', 'min:8', 'confirmed' ],
            ];
        }
        elseif(Route::currentRouteName() == 'forget.resend'){
            $rules = [
                'send_type'=>'required|string|in:email,phone',
                'send_to'=>'required|'.$customValidation,
            ];
        }
       return $rules;
    }

    protected function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors());
        throw new ValidationException($validator, $response);
    }

    public function messages()
    {
        if(app()->getLocale()=='ar')
            return [
                "send_to.required"=>"هذا الحقل مطلوب",
                "send_to.numeric"=>'رقم الجوال يجب ان يكون رقما',
                "send_to.email"=>'البريد الالكترونى غير صحيح',
                "send_to.exists"=>(\request('send_type') == 'email') ? 'البريد الالكترونى غير صحيح' : 'رقم الهاتف غير صحيح',
                "send_to.min"=>'البريد الالكتروني يجب ان يحتوي علي الاقل 5 احرف',
                "send_to.digits_between"=>'رقم الجوال يجب ان يكون بين 6 الي 14 رقم',
                "code.digits"=>'يجب أن يكون الكود رقما',
                "code.numeric"=>'يجب أن يكون الكود رقما',
                "code.numeric"=>'يجب أن يكون الكود رقما',
                "code.exists"=>'يجب أن يكون الكود صحيح',
            ];
            else
        return [
                "send_to.required"=>"This field is required",
                "send_to.numeric"=>'The Phone must be a number',
                "send_to.email"=> 'The E-mail address is incorrect.',
                "send_to.exists"=>(\request('send_type') == 'email') ? 'The E-mail address is incorrect.' : 'The phone No. is incorrect',
                "send_to.min"=>'The email must be at least 5 character',
                "send_to.digits_between"=>'The phone must be between 6 and 14 digits',
                "code.digits"=>'code is invalid',
                "code.numeric"=>'code is invalid',
                "code.exists"=>'code must be exists',

        ];
    }
}
