<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SalesRequest extends FormRequest
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
        $rules = [
            'name'=>'required|string|max:100',
            'username'=>'required|string|max:100|unique:admins,username,NULL,id,deleted_at,NULL',
            'email'=>'required|email|unique:admins,email,NULL,id,deleted_at,NULL',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'image'=>'sometimes|nullable|image',
            'active'=>'required',
            'role_id'=>'required|exists:roles,id',
            'office_id'=>'required|exists:offices,id',
        ];
        if($this->method() == 'PUT' || $this->method() == 'PATCH'){
            $sale = $this->sale;
            $rules = [
                'name'=>'required|string|min:3|max:150',
                'username'=>'required|string|max:100|unique:admins,username,'.$sale->id.',id,deleted_at,NULL',
                'email'=>'required|email|unique:admins,email,'.$sale->id.',id,deleted_at,NULL',
                'password'=>'sometimes|nullable|string|confirmed|min:6',
                'image'=>'sometimes|nullable|image',
            ];
            $isSuperAdmin = $sale->roles()->where('name','superSales')->exists();
            if($sale->id==auth()->user()->id || $isSuperAdmin){
                $rules['role_id']='sometimes|nullable';
            }else{
                $rules['role_id']='required|exists:roles,id';
            }
        }
        return $rules;
    }

    public function messages()
    {
        return[
            'name.required' => 'The role field is required',
            'name.min' => 'The name must be at least :min characters',
            'name.max' => 'The name must be less than :max characters',
            'username.required' => 'The username field is required',
            'username.min' => 'The username must be at least :min characters',
            'username.max' => 'The username must be less than :max characters',
            'username.unique' => 'This username has already been taken',
            'email.required' => 'The email field is required',
            'email.email' => 'Please enter a valid email',
            'email.unique' => 'This email has already been used',
            'active.required' => 'The status field is required',
            'password.required' => 'The password field is required',
            'image.required' => 'The image is required',
            'role_id.required' => 'The role field is required',
            'office_id.required' => 'The office field is required',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    }

}
