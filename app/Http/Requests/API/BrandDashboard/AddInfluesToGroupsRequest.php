<?php

namespace App\Http\Requests\API\BrandDashboard;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AddInfluesToGroupsRequest extends FormRequest
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
            'copy_all_id' => 'required|array',
            'copy_all_id.*' => 'required|numeric|exists:influencers,id',
            'choose_group_list' => 'required|array',
            'choose_group_list.*' => 'required|numeric|exists:group_lists,id',
        ];
    }

    protected function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors()->first());
        throw new ValidationException($validator, $response);
    }
}
