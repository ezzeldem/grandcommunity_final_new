<?php

namespace App\Http\Requests\API;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Validation\ValidationException;
use function GuzzleHttp\Promise\all;

class ContactRequest extends FormRequest
{
    use ResponseTrait;
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
            'name'=>'required|min:3|max:50',
            'email'=>'required|email',
            "country_id"=>"required",
            'phone'=>'required|numeric|digits_between:6,14',
            'code_phone'=>'required',
            'code_whats'=>(\request()->has('checkWhats') && \request('checkWhats')==true)?'required':'',
            'whatsapp'=>(\request()->has('checkWhats') && \request('checkWhats')==true)?'required|numeric|digits_between:6,14':'',
            'message'=>'required|min:25',
            'type'=>'required',
        ];
    }

    public function messages(){
        return [
            'name.required'             => __('api.contact name required'),
            'name.min'                  => __('api.contact name min'),
            'name.max'                  => __('api.contact name max'),
            'country_id.required'       => __('api.country_id required'),
            'email.required'            => __('api.email required'),
            'email.email'               => __('api.email format'),
            'phone.required'            => __('api.phone required'),
            'phone.numeric'             => __('api.phone numeric'),
            'phone.digits_between'      => __('api.phone digits between'),
            'code_phone.required'       => __('api.code_phone required'),
            'code_whats.required'       => __('api.code_whats required'),
            'whatsapp.required'         => __('api.whatsapp required'),
            'whatsapp.numeric'          => __('api.whatsapp numeric'),
            'whatsapp.digits_between'   => __('api.whatsapp digits_between'),
            'message.required'          => __('api.message required'),
            'message.min'               => __('api.message min'),
            
        ];
    }

    protected function failedValidation(Validator $validator){
        // check if request from web or mobile
        if(\request()->ajax()){
            $response = $this->validationError($validator->errors());
        }
        else{
            $response = $this->validationError($validator->errors()->first());
        }

        throw new ValidationException($validator, $response);
    }
}
