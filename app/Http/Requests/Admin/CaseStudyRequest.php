<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CaseStudyRequest extends FormRequest
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
        return [
            'total_followers'=>'required|integer',
            'total_influencers'=>'required|integer',
            'total_reals'=>'required|integer',
            'total_days'=>'required|integer',
            'campaign_type'=>'sometimes|nullable',
            'campaign_name'=>'required_with:campaign_type',
            'category'=>'required',
            'real_ar'=>'required',
            'real_en'=>'required',
            'image'=>request()->method() == 'POST' ? 'required|array' : '',
            'channel_data'=>'required|array',
            'client_profile_link'=>'required|url',
        ];
    }

    public function messages()
    {
    return [
        // 'total_reals.required' => 'The total reels field is required',
        // 'real_en.required' => 'The reels description field is required',
        // 'real_ar.required' => 'The reels description field is required',
        // 'channel_data.required' => 'The channel data is required',
        // 'campain_reach.required' => 'The Campagin reach field is required',
        // 'category.required'=>'The category field is required',
        // 'campain_reach.integer' => 'The campagin reach must be integer',
        // 'reached.required' => 'The reach is required',
        // 'reached.integer' => 'The reach is must be integer',
        // 'engagement_rate.required' => 'The engagement rate is required',
        // 'engagement_rate.integer' => 'The engagement rate must be integer',
        // 'create_post.required' => 'The Post is Required',
        // 'create_post.integer' => 'The Post is must be integer',
        // 'post_link.*.required' => 'The Post Link is required',
        // 'post_link.*.regex' => 'The Post Link you must be link',
        // 'ar_ans'=>'answer ar required',
        // 'en_ans'=>'answer en required',
        // 'ar_que'=>'ques ar required',
        // 'en_que'=>'ques en required',
        'total_followers.required' => 'Total Followers is required',
        'total_followers.integer' => 'Total Followers must be integer',
        'total_influencers.required' => 'Total Influencers is required',
        'total_influencers.integer' => 'Total Influencers must be integer',
        'total_reals.required' => 'Total Reals is required',
        'total_reals.integer' => 'Total Reals must be integer',
        'total_days.required' => 'Total Days is required',
        'total_days.integer' => 'Total Days must be integer',
        'campaign_name.required_with' => 'Campaign Name is required',
        'category.required' => 'Category is required',
        'real_ar.required' => 'Real AR is required',
        'real_en.required' => 'Real EN is required',
        'image.required' => 'Image is required',
        'channel_data.required' => 'Channel Data is required',
        'client_profile_link.required' => 'Client Profile Link is required',
        'client_profile_link.url' => 'Client Profile Link must be url',
    ];
    }

    public function failedValidation(Validator $validator){

        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    }


}
