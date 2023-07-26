<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StatisticsRequest extends FormRequest
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
//        dd(\request()->all());
        $rules =  [
            'lang'=>'required|string|in:ar,en',
            'count'=>'required|numeric',
            'ar_title'=>'required|string',
            'ar_body'=>'required|string',
            'en_title'=>'required|string',
            'en_body'=>'required|string',
            'image'=>'sometimes|nullable|file',
        ];
        return  $rules;
    }
}
