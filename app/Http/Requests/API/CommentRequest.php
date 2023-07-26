<?php

namespace App\Http\Requests\API;

use App\Http\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class CommentRequest extends FormRequest
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
            'name'=> 'required|string|max:199',
            'website'=> 'nullable|string',
            'comment'  => 'required|string',
            'email'  => 'required|email',
            'article_id'=>'required'
        ];
    }

    public function messages()
    {
        return[
            'name.required'     => __('api.contact name required'),
            'name.string'       => __('api.name string'),
            'comment.required'  => __('api.comment required'),
            'email.require'     => __('api.contact email required'),
            'email.email'       => __('api.contact email format'),
        ];
    }

    public function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors()->first());
        throw new ValidationException($validator, $response);
    }
}
