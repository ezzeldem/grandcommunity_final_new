<?php

namespace App\Http\Requests\API;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ];
    }
        public function messages()
    {
        return [
            'email.string' => 'email must',
//            'email.string' => 'terms and conditions is required',
//            'terms.boolean' => 'terms and conditions is required',
//            'terms.in' => 'terms and conditions is required',
        ];
    }

    protected function failedValidation(Validator $validator) {
        $response = $this->validationError($validator->errors());
        throw new ValidationException($validator, $response);
    }
}
