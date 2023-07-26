<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class ComplainRequest extends FormRequest
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
            "influencer_id"=> "required",
            "campaign_id"  => "required",
            "complain"     => "required|string|max:1000",
        ];
    }

    /**messages
     * @return string[]
     */
    public function messages()
    { 
        return  [
            'influencer_id.required'=> 'Influencer did not detected.',
            'campaign_id.required'  => 'Campaign did not detected.',
            'complain.required'     => 'Complain field is required.',
        ];
    }


    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([$validator->errors(),500]));
    }

}
