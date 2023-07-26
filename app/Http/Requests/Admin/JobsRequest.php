<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class JobsRequest extends FormRequest
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
        return [
            'name_ar'=> 'required|string',
            'name_en'=> 'required|string',
        ];
    }

    public function messages()
    {
        return[
            'name_ar.required'  => 'The name field is required',
            'name_en.required'  => 'The name field is required',
            'name_ar.string'    => 'The name must be a string',
            'name_en.string'    => 'The name must be a string',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    }
}
