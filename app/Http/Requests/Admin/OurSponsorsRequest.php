<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OurSponsorsRequest extends FormRequest
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
        if($this->id){
            return [
                'title'=>'required|min:4',
                'status'=>'required|in:0,1',
                'category_id'=>'required|numeric',
                'priority'=>'required|in:0,1',
            ];
        }
        return [
            'title'=>'required|min:4',
            'status'=>'required|in:0,1',
            'priority'=>'required|in:0,1',
            'category_id'=>'required|numeric',
            'image'=>'required|mimes:jpg,png,jpeg,jfif'

        ];
    }

    public function messages()
    {
        return [
            'category_id.numeric'=>'The category field is required',
            'status.required'=>'The status field is required',
            'status.in'=>'The status field is required',
            'priority.in'=>'The priority field is required',
            'image.required'=>'Image is required',
        ];
    }
}
