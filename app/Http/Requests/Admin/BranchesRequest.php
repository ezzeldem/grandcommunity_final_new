<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BranchesRequest extends FormRequest
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
            "name" => "required|string",
            "subbrand_id" => "required|numeric|exists:subbrands,id",
            "country_id" =>"required|numeric|exists:countries,id",
            "city" =>"required|string",
            'status'=>'required|numeric|in:0,1',

        ];
    }
}
