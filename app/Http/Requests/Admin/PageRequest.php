<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;

class PageRequest extends FormRequest
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
            'slug'              => Str::slug(request('title')[0], '-'),
            'created_by'        => Auth::user()->id,
            'title'             => handleInputLanguage(request('title')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title"                 => "required|array|max:100",
            "title.*"               => "required|string|max:255",
            "sub_title"             => "required|array|max:100",
            "sub_title.*.*"         => "required|string|max:255",
            "sub_description"       => "required|array|max:100",
            "sub_description.*.*"   => "required|string",
            'status'                => 'required|in:1,0',
            'position'              => 'required|in:1,0',
            'slug'                  =>  request()->method() == 'PUT' ? 'required|unique:pages,slug,'.request()->segment(3).',id,deleted_at,NULL' : 'required|unique:pages,slug',
            'page_type'             => 'boolean',
            'image'                 => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'created_by'            => 'required',
        ];
    }

    /**messages
     * @return string[]
     */
    public function messages()
    { 
            $msgs = [
                'slug.required'             => 'The main title field is required.',
                'slug.unique'               => 'The slug has already been taken.',
                'title.0.*.required'        => 'The title EN field is required.',
                'title.1.*.required'        => 'The title AR field is required.',
                'title.0.*.string'          => 'The title EN field must be of type string.',
                'title.1.*.string'          => 'The title AR field must be of type string.',
                'title.0.*.max'             => 'The title EN field max length is 255 .',
                'title.1.*.max'             => 'The title AR field max length is 255 .',
                'sub_description.0.*.required'  => 'The description EN field is required.',
                'sub_description.1.*.required'  => 'The description AR field is required.',
                'sub_description.0.*.string'    => 'The description EN field must be of type string.',
                'sub_description.1.*.string'    => 'The description AR field must be of type string.',
                'created_by'                => 'Must be signed in'
            ];
        return $msgs;
    }


    public function failedValidation(Validator $validator){
        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    }

}
