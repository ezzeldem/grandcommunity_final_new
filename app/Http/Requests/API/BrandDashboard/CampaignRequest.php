<?php

namespace App\Http\Requests\API\BrandDashboard;

use App\Http\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CampaignRequest extends FormRequest
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
        $id = $this->campaign ? $this->campaign->id : false;

        $compliment = $this->campaign ? $this->campaign->compliment : null;
        $hasGiftImage = $compliment ? $compliment->gift_image : false;

        $complimentBranchesRequired = "required_if:compliment_type,1,2,3";
        if(request('campaign_type') == 1){
            $complimentBranchesRequired = "nullable|";
        }

        if(!$this->draft){
            $rules = [
                'name' =>'required|string|max:255',
                'objective_id' =>'required|integer',
                'gender' =>'required|string|in:male,female,both',
                'campaign_type' =>'required',
                'visit_from' =>'nullable|date_format:H:i',
                'visit_to' =>'nullable|date_format:H:i',
                'visit_end_date' =>'nullable|required_if:campaign_type,0,2,3,4|date|after:visit_start_date',
                'deliver_end_date' =>'nullable|required_if:campaign_type,1,2|date|after:deliver_start_date',
                'deliver_from' =>'nullable|date_format:H:i',
                'deliver_to' =>'nullable|date_format:H:i',
                'influencer_per_day' =>'required|integer|digits_between:1,10|lte:influencer_count|regex:/([1-9])+/i',
                'note' =>'sometimes|nullable|string|min:3',
                'brief' =>'required|string',
                'number_of_influ' =>'sometimes|integer',
                'has_guest' =>'sometimes',
                'guest_numbers' =>'required_if:has_guest,1',
                'attached_files' =>'sometimes|nullable|array',
                'compliment_type' =>'sometimes|integer',
                'compliment_branches' =>$complimentBranchesRequired.'exists:branches,id',
                'voucher_expired_date'=>'nullable|required_if:compliment_type,1,3|date',
                'voucher_expired_time'=>'nullable|required_if:compliment_type,1,3|date_format:H:i',
                'voucher_amount'=>'nullable|required_if:compliment_type,1,3|numeric',
                'voucher_amount_currency'=>'nullable|required_if:compliment_type,1,3',
                'gift_image' => $hasGiftImage ? 'nullable|array' : 'required_if:compliment_type,2,3|array',
                'gift_image.*' => $hasGiftImage ? 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' : 'required_if:compliment_type,2,3|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'gift_amount'=>'nullable|required_if:compliment_type,2,3|numeric',
                'gift_amount_currency'=>'nullable|required_if:compliment_type,2,3',
                'gift_description'=>'nullable|string',
                'deleted_attached_files' =>'sometimes|nullable|array',
                'deleted_gift_image' =>'sometimes|nullable|array',
                ];
        }else {
            $rules = [
                'name' =>'required|string|max:255',
                'objective_id' => 'sometimes',
                'gender' =>'sometimes|string|in:male,female,both',
                'campaign_type' =>'sometimes',
                'visit_from' =>'sometimes|nullable|date_format:H:i',
                'visit_to' =>'sometimes|nullable|date_format:H:i',
                'visit_start_date' =>'sometimes|nullable|date|after:yesterday',
                'visit_end_date' =>'sometimes|nullable|date|after:visit_start_date',
                'deliver_start_date' =>'sometimes|nullable|date|after:yesterday',
                'deliver_end_date' =>'sometimes|nullable|date|after:deliver_start_date',
                'deliver_from' =>'sometimes|nullable|date_format:H:i',
                'deliver_to' =>'sometimes|nullable|date_format:H:i',
                'influencer_per_day' =>'sometimes|integer|digits_between:1,10|lte:influencer_count',
                'note' =>'sometimes|nullable|string|min:3',
                'brief' =>'sometimes|nullable|string',
                'number_of_influ' =>'sometimes|integer',
                'has_guest' =>'sometimes',
                'guest_numbers' =>'sometimes|nullable',
                'attached_files' =>'sometimes|nullable|array',
                'country_id' =>'sometimes|array',
                'country_id.*' =>'sometimes|numeric|exists:countries,id',
                'branch_ids' =>'sometimes|array',
                'branch_ids.*' =>'sometimes',
                'sub_brand_id' =>'sometimes',
                'compliment_type' =>'sometimes|integer',
                'compliment_branches' =>'sometimes|nullable|exists:branches,id',
                'voucher_expired_date'=>'sometimes|nullable',
                'voucher_expired_time'=>'sometimes|nullable',
                'voucher_amount'=>'sometimes|nullable',
                'voucher_amount_currency'=>'sometimes|nullable',
                'gift_image'=>'sometimes|array',
                'gift_image.*'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'gift_amount'=>'sometimes|nullable',
                'gift_amount_currency'=>'sometimes|nullable',
                'gift_description'=>'sometimes|nullable|string',
                'deleted_attached_files' =>'sometimes|nullable|array',
                'deleted_gift_image' =>'sometimes|nullable|array',
            ];
        }

        if (!$id) {
            $rules += [
                'country_id' =>'required|array',
                'country_id.*' =>'required|numeric|exists:countries,id',
                'branch_ids' =>'required_if:campaign_type,0,2|array',
                'branch_ids.*' =>'required_if:campaign_type,0,2|string|exists:branches,id',
                'sub_brand_id' =>'required|exists:subbrands,id',
                'visit_start_date' =>'nullable|required_if:campaign_type,0,2,3,4|date|after:yesterday',
                'deliver_start_date' =>'nullable|required_if:campaign_type,1,2|date|after:yesterday',
            ];
        }

        return $rules;
    }

	protected function failedValidation(Validator $validator){
        $response = $this->validationError($validator->errors());
        throw new ValidationException($validator, $response);
    }

}
