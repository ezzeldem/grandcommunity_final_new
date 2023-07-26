<?php

namespace App\Http\Requests\Admin;

use App\Models\Influencer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangeDetailInfluencerRequest extends FormRequest
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

        $influencer =Influencer::findOrFail(request('influencer_id'));

        return [
            'phone'=>'required|numeric|digits_between:6,14|unique:users,phone,'.$influencer->user_id.',id,deleted_at,NULL',
            'code'=>'required',
            'address'=>'sometimes|nullable|array',
            'address.*'=>'required|min:5|max:140',
            'country_id' =>'required|numeric|exists:countries,id',
            'state_id' =>'required|numeric|exists:states,id',
            'city_id' =>'required|exists:cities,id',
            'return_date'=>'required|date',
            'note'=>'sometimes|nullable|min:10',
            'insta_uname'=>'required|string|unique:influencers,insta_uname,'.$influencer->id.',id,deleted_at,NULL'

        ];
    }
    public function messages()
    {
        return[
            "address.en.required"  =>"input address English is required",
            "address.ar.required"  =>"input address Arabic is required",
        ];
    }

}
