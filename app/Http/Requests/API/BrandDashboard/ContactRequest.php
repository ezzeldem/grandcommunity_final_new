<?php

namespace App\Http\Requests\API\BrandDashboard;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ContactRequest extends FormRequest
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
        return [
            'name'=>'required|min:3|max:50',
            'email'=>'required|email',
            'phone'=>'required|numeric|digits_between:6,14',
            'message'=>'required|min:25',
            'type'=>'required',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'=>__('contact.name field required'),
            'name.min'=>__('api.name min'),
            'name.max'=>__('api.name max'),
            'email.required'=>__('api.email required'),
            'email.email'=>__('api.email foramt'),
            'phone.required'=>__('api.phone required'),
            'phone.numeric'=>__('api.phone numeric'),
            'phone.digits_between'=>__('api.phone digits_between'),
            'message.required'=>__('api.message required'),
            'message.min'=>__('api.message min'),
            'type.required'=>__('api.type required'),
        ];
    }

    // protected function failedValidation(Validator $validator){
    //     $response = $this->validationError($validator->errors()->first());
    //     throw new ValidationException($validator, $response);
    // }
}
