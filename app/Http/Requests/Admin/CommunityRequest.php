<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CommunityRequest extends FormRequest
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
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|mi n:6',
            'image'=>'sometimes|nullable',
            'image.*'=>'mimes:jpg,png,jpeg',
            'role_id'=>'required|exists:roles,id',

        ];
        if($this->method() == 'PUT' || $this->method() == 'PATCH'){
            $community = $this->community;
            $rules = [
                'name'=>'required|string|min:3|max:150',
                'username'=>'required|string|max:100|unique:admins,username,'.$community->id.',id,deleted_at,NULL',
                'email'=>'required|email|unique:admins,email,'.$community->id.',id,deleted_at,NULL',
                'active'=>'required|integer|in:0,1',
                'password'=>'sometimes|nullable|string|confirmed|min:6',
                'image'=>'sometimes|nullable|image',
            ];
            $isSuperAdmin = $community->roles()->where('name','superCommunity')->exists();
            if($community->id==auth()->user()->id || $isSuperAdmin){
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
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    }
}
