<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class SocialStatusRequest extends FormRequest
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
       
    
        // return [
        //     'social_data.social_type' => ['required','numeric','in:1,2,3,4'],
        //     'social_data.children_num' => [new RequiredIf( \request('social_data.social_type') !=1 && \request('social_data.social_type'))],

        //    'social_data.children.gender' => [new RequiredIf(\request('social_data.children_num')  && \request('social_data.social_type') !=1),'array','min:'.\request('social_data.children_num'),'max:'.\request('social_data.children_num')],
        //    'social_data.children.gender.*' => [new RequiredIf(\request('social_data.children_num')  && \request('social_data.social_type') !=1),'string','in:male,female'],

        //    'social_data.children.DOB' => [new RequiredIf(\request('social_data.children_num')  && \request('social_data.social_type') !=1 ),'array','min:'.\request('social_data.children_num'),'max:'.\request('social_data.children_num')],
        //    'social_data.children.DOB.*' => [new RequiredIf(\request('social_data.children_num')  && \request('social_data.social_type') !=1),'date','before:today'],

        //    'social_data.children.name' => [new RequiredIf(\request('social_data.children_num')  && \request('social_data.social_type') !=1 ),'array','min:'.\request('social_data.children_num'),'max:'.\request('social_data.children_num')],
        //    'social_data.children.name.*' => [new RequiredIf(\request('social_data.children_num')  && \request('social_data.social_type') !=1),'string'],
        //    'socila_data.step' => 'required',
        // ];
    }
    public function messages()
    {
        if(app()->getLocale()=='ar')
            return [
                'social_data.DOB.*.before' => ' تاريخ الميلاد يجب أن يكون قبل اليوم وبعد 1990 .',
            ];
        else
            return [
                'social_data.DOB.*.before' => ' Birthday must be a date before today and after 1900.',
            ];
    }

}
