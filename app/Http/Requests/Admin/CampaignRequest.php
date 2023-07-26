<?php

namespace App\Http\Requests\Admin;

use App\Models\Campaign;
use App\Models\CampaignCountryFavourite;
use App\Models\CampaignSecret;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CampaignRequest extends FormRequest
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
        $method = request()->route()->getActionMethod() == "update"?"update":"create";
        $campaignData = $this->route('campaign')?:new Campaign;
        $visitDateAfterYesterday = "|date_and_time_after_now"; //"|after:yesterday";
        $deliverDateAfterYesterday = "|date_and_time_after_now";
        $voucherExpiredDateAfterYesterday = "|date_and_time_after_now";
        if($method == "update" && $campaignData){
            if($campaignData->visit_start_date == request('visit_start_date')){
                $visitDateAfterYesterday = "";
            }

            if($campaignData->deliver_start_date  == request('deliver_start_date')){
                $deliverDateAfterYesterday = "";
            }

            if($campaignData->voucher_expired_date  == request('voucher_expired_date')){
                $voucherExpiredDateAfterYesterday = "";
            }
        }

        $favListIsRequired = "required";
        if($method == "update"){
            $oldCountries = array_map('intval',$campaignData->country_id);
            $newCountries = array_map('intval', request('country_id', []));
            sort($oldCountries); sort($newCountries);
            if($oldCountries === $newCountries){
                $favListIsRequired = "nullable";
            }
        }

        $ruleStep1 = [
            'name' => 'required|string|min:3|max:255', //|regex:/([a-zA-Z])+([0-9])*/i
            'brand_id' => 'required|string|exists:brands,id',
            'gender' => 'required|string|in:male,female,both',
            'status' =>'required|integer',
            'campaign_type' =>'required',
            'country_id' =>'required|array',
            'country_id.*' =>'required|numeric',
            'visit_start_date' => 'nullable|required_if:campaign_type,0,2|date'.$visitDateAfterYesterday.'|before:01-01-2025',
            'visit_end_date' => 'nullable|required_if:campaign_type,0,2|date|before:01-01-2025',
            'visit_from' => 'nullable|required_if:campaign_type,0,2',
            'visit_to' => 'nullable|required_if:campaign_type,0,2',
            'deliver_start_date' => 'nullable|required_if:campaign_type,1,2|date'.$deliverDateAfterYesterday,
            'deliver_end_date' => 'nullable|required_if:campaign_type,1,2|date',
            'deliver_from' => 'nullable|required_if:campaign_type,1,2',
            'deliver_to' =>'nullable|required_if:campaign_type,1,2',
            'sub_brand_id' => 'required|nullable|string|exists:subbrands,id',
            // 'branch_ids' =>'required|array',
            // 'branch_ids.*' =>'required|string|exists:branches,id',
            'branch_ids' => 'required_if:campaign_type,0,2|array',
            'branch_ids.*' => 'required_if:campaign_type,0,2|string|exists:branches,id',
            'target_influencer'=>'required|min:0|integer',
            'influencer_per_day'=>'required|integer|max:'.(int)request('target_influencer'),
            'target_confirmation' =>'nullable|integer', //|lte:target|regex:/([1-9])+/i
            'daily_confirmation'=>'required|integer|max:'.(int)request('target_confirmation'),
//            'delivery_coverage' => 'nullable|required_if:campaign_type,1,2|url',
            'list_ids'=> $favListIsRequired,
            'list_ids.*'=>$favListIsRequired,
            'list_ids.*.*'=>$favListIsRequired.'|string',
            'objective_id' => 'required|integer',
        ];

        if(request('visit_start_date') && request('visit_from')
            && request('visit_end_date') && request('visit_to')
            && strtotime(request('visit_start_date')." ".request('visit_from')) > strtotime(request('visit_end_date')." ".request('visit_to'))){
            $ruleStep1['visit_end_date'] = 'date|after:visit_start_date';
        }

        if(request('deliver_start_date') && request('deliver_from')
            && request('deliver_end_date') && request('deliver_to')
            && (request('deliver_start_date')." ".request('deliver_from')) > (request('deliver_end_date')." ".request('deliver_to'))){
            $ruleStep1['deliver_end_date'] = 'date|after:deliver_start_date';
        }

        $complimentCampaignEntity = $campaignData->compliment;
        $oldGiftImages = $complimentCampaignEntity?($complimentCampaignEntity->gift_image?:[]):[];
        $deletedGiftImages = request('deleted_gift_image')?explode("||", (string) request('deleted_gift_image')):[];
        $giftImageRequired = "required_if:compliment_type,2,3|";

        if(count($oldGiftImages) > 0 && count($deletedGiftImages) < count($oldGiftImages)){
            $giftImageRequired = "nullable|";
        }


        $complimentBranchesRequired = "required_if:compliment_type,1,2,3";
        if(request('campaign_type') == 1){
            $complimentBranchesRequired = "nullable";
        }


        $ruleStep2 = [
//            'min_story' => 'required|integer',
//            'has_voucher' => 'required|integer',
            'coverage' => 'required_with:channel_id_1,channel_id_2,channel_id_3,channel_id_4,channel_id_5|array',
            'coverage.*' => 'required_with:channel_id_1,channel_id_2,channel_id_3,channel_id_4,channel_id_5',
        ];

        if(in_array((int) request('campaign_type'), [0, 1, 2])){
            $ruleStep2 = array_merge($ruleStep2, [
//                'secret'=>'required|array',
//                'secret.*'=>'required|string|min:5|unique_secret_key',
//                'permissions'=>'required|array', //required_if:campaign_type,0,1,2
//                'permissions.*'=>'required|array', //required_if:campaign_type,0,1,2
//                'permissions.*.*'=> 'required|string', //required_if:campaign_type,0,1,2
                'voucher_expired_date'=>'required_if:compliment_type,1,3'.$voucherExpiredDateAfterYesterday,
                'voucher_expired_time'=>'required_if:compliment_type,1,3',
                'voucher_amount'=>'required_if:compliment_type,1,3',
                'voucher_amount_currency'=>'required_if:compliment_type,1,3',
                // 'compliment_branches' => 'required_if:compliment_type,1,2,3',
                'compliment_branches' => $complimentBranchesRequired,
                'gift_image'=> $giftImageRequired.'array',
                'gift_amount'=>'required_if:compliment_type,2,3',
                'gift_description'=> 'nullable|min:3|string', //'required_if:compliment_type,2,3',
                'gift_amount_currency'=>'required_if:compliment_type,2,3',
            ]);

            $permissionsRules = [];

//            for ($i=0; $i < count(request('secret', [])); $i++){
//                $permissionsRules['permissions.'.$i] = 'required|array';
//            }

            $ruleStep2 = array_merge($ruleStep2, $permissionsRules);
        }


        $ruleStep4 = [

        ];
        $ruleStep3 = [
            'note'=> "nullable|string",
            'brief'=> "required|string",
            'invitation'=>"nullable|string",
//            'visit_coverage' => 'nullable|required_if:campaign_type,0,2|string',
        ];

        if(in_array(request('campaign_type'), [0, 2])){
            $guest_numbers = request('has_guest') > 0?"required|min:1|not_in:0":"nullable";
            $ruleStep3 = array_merge($ruleStep3, [
                'has_guest' => 'required|integer|in:0,1',
                'guest_numbers'=> $guest_numbers,
            ]);
        }

        $rules = ['step' => 'required|min:1|max:4'];

        switch ((int) request('step')){
            case 1:
                $rules += $ruleStep1;
                $rules += $ruleStep2;
                break;
            case 2:
                $rules += $ruleStep2;
                $rules += $ruleStep3;
                break;
        }

        return $rules;
    }


    public function messages()
    {
        return[
            'gift_image'=> 'Gift files is required.',
            'brief.required' => 'The campaign brief is required.',
            'has_guest.required' => 'The guest are allowed field is required',
            'country_id.required' => 'The countries field is required',
            'platform_type.required' => 'The platform field is required',
            'visit_end_date.after' => 'Visit end date time must be after visit start date time',
            'deliver_end_date.after' => 'Deliver end date time must be after deliver start date time',
            'type_share.required'     => 'the type share is required',
            'sub_brand_id.required' => 'The brands field is required',
            'has_voucher.required' => 'The voucher is provided field is required',
            'start_date.required' => 'The start date field is required',
            'start_date.date' => 'The start date format is incorrect',
            'end_date.required' => 'The end date field is required',
            'end_date.date' => 'The end date format is incorrect',
            'brand_id.required' => 'The brand field is required',
//            'secret.*.required' => 'The secret key field is required',
            'branch_ids.required' => 'The branch field is required',
            'branch_ids.array' => 'The branch field format is incorrect',
            'branch_ids.min' => 'The branch field must include at least one branch',
            'list_ids.required' => 'The lists field is required',
            'list_ids.array' => 'The lists field format is inorrect',
            'list_ids.min' => 'The lists field must include at least one branch',
            'influencers_price.required' => 'The influencer\'s charge field is required',
            'influencers_price.integer' => 'The influencers price must be Integer',
            'influencers_price.min' => 'The influencer\'s price minimum value is 1 ',
            'influencer_count.required' => 'The influencers count field is required ',
            'influencer_count.integer' => 'The influencers count must be Integer',
            'influencer_count.min' => 'The influencers count minimum value is 1 ',

            'influencer_per_day.required' => 'The influencers per day field is required ',
            'influencer_per_day.integer' => 'The influencers per day must be integer',
            'influencer_per_day.min' => 'The influencers per day minimum value is 1',
            'influencer_per_day.gt' => 'The influencer per day field must be greter than influnencer count',
            'influencers_script.required' =>  'The influencer script field is required',
            'influencers_script.string' =>  'The influencer script field must be string',
            'company_msg.required' =>  'The company message field is required',
            'company_msg.string' =>  'The company message field must be a string',
//            'permissions.required' => 'Please Place Permission',
//            'permissions.*.required' => 'Please Place Permission',
//           'permissions.*.*.required' => 'Please Place Permission'
        ];
    }

    //    public function failedValidation(Validator $validator){
    //        dd($validator->errors());
    //        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    //    }


    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
//        $validator->addImplicitExtension('unique_secret_key', function($attribute, $value, $parameters) {
//            $index = (int) substr($attribute, strpos($attribute, ".") + 1);
//            $otherSecrets = request('secret', []);
//            unset($otherSecrets[$index]);
//            if(in_array($value, $otherSecrets)){
//                return false;
//            }
//            $instance = new CampaignSecret;
//            $campaign = $this->route('campaign');
//            if(!$value){
//                return false;
//            }
//            if($campaign && $campaign->id){
//                $valueExist = CampaignSecret::whereNotIn('campaign_country_id', CampaignCountryFavourite::where('country_id', $index)->where('campaign_id', $campaign->id)->pluck('id')->toArray())->where('secret', $instance->encrypt($value))->first();
//            }else{
//                $valueExist = CampaignSecret::where('secret', $instance->encrypt($value))->first();
//            }
//            return !$valueExist;
//        });
//
//        $validator->addReplacer('unique_secret_key', function ($message, $attribute, $rule, $parameters, $validator) {
//            return __("The :attribute should be unique.", compact('attribute'));
//        });

        $validator->addImplicitExtension('date_and_time_after_now', function($attribute, $value, $parameters) {
            switch ($attribute){
                case "visit_start_date";
                    if(in_array((int) request('campaign_type'), [0, 2])) {
                        return strtotime(request('visit_start_date')." ".request('visit_from')) > time();
                    }
                    return true;
                case "deliver_start_date";
                    if(in_array((int) request('campaign_type'), [1, 2])) {
                        return strtotime(request('deliver_start_date') . " " . request('deliver_from')) > time();
                    }
                    return true;
                case "voucher_expired_date";
                if(in_array((int) request('compliment_type'), [1, 3])){
                    return strtotime(request('voucher_expired_date')." ".request('voucher_expired_time')) > time();
                }
                return true;
                default:
                    return true;
            }
        });

        $validator->addReplacer('date_and_time_after_now', function ($message, $attribute, $rule, $parameters, $validator) {
            return __("The date and time should be after now time.", compact('attribute'));
        });

        return $validator;
    }


}
