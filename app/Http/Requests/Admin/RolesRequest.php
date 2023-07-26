<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RolesRequest extends FormRequest
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


        $rules =  [
            'name'          =>'required|string|min:3|max:50|unique:roles,name',
            'permissions'   =>'required|array',
            'permissions.*' =>'required|string|min:3|max:150',
            'type'          =>'required|string|min:3|max:50|in:admin,operations',
            'user_id'       => 'required',
        ];

        if($this->method() == 'PUT' || $this->method() == 'PATCH'){
            $rules =  [
                'name'=>'required|string|min:3|max:50|unique:roles,name,'.$this->role->id.',id',
                'permissions'=>'required|array',
                'permissions.*'=>'required|string|min:3|max:150',
            ];
        }

        if($this->user()->roles == 'admin'){
            $rules['type'] = 'required|string|min:3|max:50|in:admin,sales,operations';
        }

        return $rules;
    }

    public function messages(){
        return [
            'name.required'         => 'The role name field is required',
            'name.unique'           => 'The role name has already been taken',
            'name.min'              => 'The role name must be at least 3 characters',
            'name.max'              => 'The role name may not be greater than 50 characters',
            'permissions.required'  => 'THe role persmissions field is required',
            'type.required'         => 'The role type field is required',
            'type.in'               => 'The selected role type is invalid',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    }
}
