<?php

namespace App\Http\Requests\Admin;

use App\Http\Traits\ResponseTrait;
use App\Models\Brand;
use App\Models\Subbrand;
use App\Models\GroupList;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class GroupListRequest extends FormRequest
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
        $brand_id = ( $this->is('api/*')) ? Auth::user()->brands()->first()->id : request()->brand_id;
            $rules =  [
                'color'=>'required|string',
//                'country_id.*'=>'required|numeric|exists:countries,id',
                'name'=>[
                    'required',
                    Rule::unique('group_lists', 'name')->ignore($this->id, 'id')
                        ->where(function ($query) use($brand_id) {return $query->where('brand_id', $brand_id)->whereDeletedAt(null);})
                ]
            ];

            if(request()->has('sub_brand_id')){
                $rules['sub_brand_id'] = 'required|exists:subbrands,id';
            }else{
                $subrands = Subbrand::where('brand_id',request()->brand_id)->where('status',1)->count();
                if($subrands > 1)
                    $rules['sub_brand_id'] = 'sometimes|required|exists:subbrands,id';
            }

            return $rules;
    }

    public function messages()
    {
        return [
            'country_id.required'=>"The Country Field is Required"
        ];
    }

    protected function failedValidation(Validator $validator) {
        $response = $this->validationError($validator->errors());
        throw new ValidationException($validator, $response);
    }
}
