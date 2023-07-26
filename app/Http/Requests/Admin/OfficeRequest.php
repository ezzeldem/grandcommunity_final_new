<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OfficeRequest extends FormRequest
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
            "name"=> "required|string|max:150",
            "country_id"=> "required|numeric",
            "status"=> "required",
        ];
    }

    public function messages()
    {
        return[
            'name.required'  => 'The name field is required',
            'name.string'    => 'The name must be string',
            'name.max'       => 'The name field maximum length is :max',
            'country_id.required'=> 'The country field is required',
            'country_id.numeric' => 'The country field value is invalid',
            'status.required'    => 'The status field is required',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    }
}
