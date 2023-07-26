<?php

namespace App\Http\Requests\API\BrandDashboard;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BranchesRequest extends FormRequest
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
            "name" => "required|string|min:3|max:150|unique:branches,name,".$this->id.",id,deleted_at,NULL",
            "subbrand_id" => "required|numeric",
            "country_id" =>"required|numeric|exists:countries,id",
            "city" =>"required|numeric|exists:cities,id",
            'state'=>'required|numeric|exists:states,id',
            'address'=>'sometimes|nullable|string|min:3|max:150',
            'lat'=>'sometimes|nullable|numeric',
            'lng'=>'sometimes|nullable|numeric',
        ];
    }

    protected function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors()->first());
        throw new ValidationException($validator, $response);
    }
}
