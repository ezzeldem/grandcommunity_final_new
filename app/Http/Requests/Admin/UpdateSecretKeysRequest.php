<?php

namespace App\Http\Requests\Admin;

use App\Models\Campaign;
use App\Models\CampaignCountryFavourite;
use App\Models\CampaignSecret;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSecretKeysRequest extends FormRequest
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
         $rules = [
                'secret'=>'required|array',
                'secret.*'=>'required|string|min:5|unique_secret_key',
                'permissions'=>'required|array', //required_if:campaign_type,0,1,2
            ];

            $permissionsRules = [];

            for ($i=0; $i < count(request('secret', [])); $i++){
                $permissionsRules['permissions.'.$i] = 'required|array';
            }

        return array_merge($rules, $permissionsRules);
    }


    public function messages()
    {
        return[
            'permissions.required' => 'Please Place Permission',
            'permissions.*.required' => 'Please Place Permission',
            'permissions.*.*.required' => 'Please Place Permission'
        ];
    }



    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        $validator->addImplicitExtension('unique_secret_key', function($attribute, $value, $parameters) {
            $index = (int) substr($attribute, strpos($attribute, ".") + 1);
            $otherSecrets = request('secret', []);
            unset($otherSecrets[$index]);
            if(in_array($value, $otherSecrets)){
                return false;
            }
            $instance = new CampaignSecret;
            $campaign = Campaign::find((int) $this->route('campaign_id'));
            if(!$value){
                return false;
            }
            if($campaign && $campaign->id){
                $valueExist = CampaignSecret::whereNotIn('campaign_country_id', CampaignCountryFavourite::where('country_id', $index)->where('campaign_id', $campaign->id)->pluck('id')->toArray())->where('secret', $instance->encrypt($value))->first();
            }else{
                $valueExist = CampaignSecret::where('secret', $instance->encrypt($value))->first();
            }
            return !$valueExist;
        });

        $validator->addReplacer('unique_secret_key', function ($message, $attribute, $rule, $parameters, $validator) {
            return __("The :attribute should be unique.", compact('attribute'));
        });

        return $validator;
    }


}
