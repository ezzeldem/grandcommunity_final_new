<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class FaqRequest extends FormRequest
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
            'question_ar'=> 'required|string|min:10|max:1000',
            'question_en'=> 'required|string|min:10|max:1000',
            'answer_ar'  => 'required|string|min:10|max:1000',
            'answer_en'  => 'required|string|min:10|max:1000',
        ];
    }

    public function messages()
    {
        return[
            'question_ar.required'  => 'The Question field is required',
            'question_ar.max'       =>  'The data is very Large',
            'question_ar.string'    => 'The Question field must be string',
            'question_en.required'  => 'The Question field is required',
            'question_en.string'    => 'The Question field must be string',
            'answer_ar.required'    => 'The answer field is required',
            'answer_ar.string'      => 'The answer field must be string',
            'answer_en.required'    => 'The answer field is required',
            'answer_en.string'      => 'The answer field must be string',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    }
}
