<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
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
            'description' => 'required|string',
            'start_date' => 'required|date|after:today|before:01-01-2025',
            'end_date' => 'required|date|after:start_date|before:01-01-2025',
            'assign_status' => 'required',
            'assigned_to' => 'required',
            'priority' => 'required',
            'status' => 'required',
            'file' => request()->method() == 'POST' ? 'required|max:50000|mimes:xlsx,doc,docx,ppt,pptx,png,jpg' : 'sometimes|nullable|max:50000|mimes:xlsx,doc,docx,ppt,pptx,png,jpg',
        ];
    }

    public function validate(){
        return array_merge(parent::validated(),[
            'user_id' => request('assign_status') == 0 ? request('assigned_to') : null,
            'status_id' => request('assign_status') == 1 ? request('assigned_to') : null,
        ]);
    }

    /**messages
     * @return string[]
     */
    public function messages()
    {
        return [
            'description.required'=>'The task description is required',
            'start_date.required'=>'The start date field is required',
            'end_date.required'=>'The end date field is required',
            'assign_status.required'=>'The assign status field is required',
            'assigned_to.required'=>'The assigned to field is required',
            'priority.required'=>'The priority field is required',
            'status.required'=>'The status field is required',
            'file.required'=>'The task file is required',
        ];
    }

    public function failedValidation(Validator $validator){
        if(request()->ajax()){
            
            throw new HttpResponseException(response()->json(['status' => false, 'errors' => $validator->errors()]));
        }else{
            throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
        }
    }
    
}
