<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AdminRequest extends FormRequest
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
            'active'=>'required|integer|in:0,1',
            'role_id' => 'required',
            'password' => ['required', 'min:6', 'required_with:password_confirmation', 'same:password_confirmation',Password::default()->mixedCase() ],
            'password_confirmation' => 'required|min:6'
        ];
        if($this->method() == 'PUT' || $this->method() == 'PATCH'){
            $admin = $this->admin;
            $rules = [
                'name'=>'required|string|min:3|max:150',
                'username'=>'required|string|max:100|unique:admins,username,'.$admin->id.',id,deleted_at,NULL',
                'email'=>'required|email|unique:admins,email,'.$admin->id.',id,deleted_at,NULL',
                'active'=>'required|integer|in:0,1',
                'password'=>'sometimes|nullable|string|
                |min:6',
                'image'=>'sometimes|nullable|image|mimes:png,jpg,jpeg',
            ];
            $isSuperAdmin = $admin->roles()->where('name','superAdmin')->exists();
            if($admin->id==auth()->user()->id || $isSuperAdmin){
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
            'role_ids.required' => 'The role field is required',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    }
}
