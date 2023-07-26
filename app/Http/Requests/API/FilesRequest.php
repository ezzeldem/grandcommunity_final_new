<?php

namespace App\Http\Requests\API;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FilesRequest extends FormRequest
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
        $rules = [
            'image'=>'required|image|mimes:jpeg,png,jpg',
        ];
      

        return $rules;
    }


    protected function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors());
        throw new ValidationException($validator, $response);
    }

}

