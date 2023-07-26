<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleRequest extends FormRequest
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
        if(is_array(request('tags'))){
            $tags = handleInputLanguage(array_merge([implode(',',request('tags')[0]??[]),implode(',',request('tags')[1]??[])]));
        }else{
            $tags = request('tags');
        }

        $desc = collect(request('sub_description'))->map(function($item){
            return collect($item)->map(function($i){
                return $i == '<p><br></p>' ? NULL : $i;
            });
        });

        $this->merge([
            'created_by'        => Auth::user()->id,
            'title'             => handleInputLanguage(request('title')),
            'slug'              => Str::slug(request('title')[0], '-') ?? NULL,
            'tags'              => $tags,
            'sub_description'   => $desc->toArray(),
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
            'title'                 => "required|array|max:1000",
            'title.*'               => "required|string|max:255",
            'sub_title'             => "required|array|max:1000",
            'sub_title.*.*'         => "required|string|max:255",
            'sub_description'       => "required|array|max:10000",
            'sub_description.*.*'   => "required|string|min:50|max:10000",
            'status'                => 'required|in:1,0',
            'image'                 => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'tags'                  => 'required|array|max:255',
            'tags.*'                => 'required|string|max:255',
            'slug'                  =>  request()->method() == 'PUT' ? 'nullable|unique:articles,slug,'.$this->article->id.',id,deleted_at,NULL' : 'nullable|unique:articles,slug,NULL,id,deleted_at,NULL',
            'created_by'            => 'required',
            'page_type'             => 'boolean'
        ];
    }

    // public function validated(){
    //     return array_merge(parent::validated(),[
    //         'tags' => implode(',',request('tags')),
    //     ]);
    // }
    /**messages
     * @return string[]
     */
    public function messages()
    {
        return [
            'title.*.required'          => 'The title field is required.',
            'title.*.*.string'          => 'The title field must be of type string.',
            'title.*.*.max'             => 'The title field max length is 255.',
            
            'slug.unique'               => 'The main title is already exists.',
            
            'sub_title.*.*.required'    => 'The title field is required.',
            'sub_title.*.*.string'      => 'The title field must be of type string.',
            'sub_title.*.*.max'         => 'The title field max length is 255 .',
            
            'sub_description.*.*.required'  => 'The description field is required.',
            'sub_description.*.*.string'    => 'The description field must be of type string.',
            
            'description.*.*.required'  => 'The description field is required.',
            'description.*.*.string'    => 'The description field must be of type string.',
            
            'created_by'                => 'Must be signed in.',
            
            'tags.*.required'           => 'The tags field is required.',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
    }
}
