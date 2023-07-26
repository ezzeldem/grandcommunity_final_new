<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class ConfirmationRequest extends FormRequest
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


    protected function prepareForValidation(): void
    {
        $this->merge([
            'coverage_date' => is_null(request('coverage_date')) ? NULL : request('coverage_date'),
        ]);
    //    dd(request('coverage_date'));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd(request()->all());
        return [
            "influencer_id"     => "required",
            "campaign_id"       => "required",
            "confirmation_date" => "sometimes|nullable",
            "coverage_date"     => "sometimes|nullable|after:today",
            "brief"             => "sometimes|nullable",
            "status"            => "required",
        ];
    }

    /**messages
     * @return string[]
     */
    public function messages()
    { 
        return  [
            'influencer_id.required'        => 'Influencer did not detected.',
            'campaign_id.required'          => 'Campaign ID did not Matched with any of our records.',
            'confirmation_date.required'    => 'Confirmation Date field is required.',
            'coverage_date.required'        => 'Coverage Date field is required.',
            'brief.required'                => 'Brief field is required.',
            'status.required'               => 'Status field is required.',
        ];
    }


    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([$validator->errors(),500]));
    }

}
