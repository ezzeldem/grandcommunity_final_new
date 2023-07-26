<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'answer', 'status'];

    protected $casts = ['question'=>'array','answer'=>'array'];
    protected $appends=['answer_lang','question_lang'];
    public function getQuestionAttribute(){
        if(\request()->header('Accept-Language')){
            if(\request()->header('Accept-Language') == 'ar'){
                return json_decode($this->attributes['question'])->ar;
            }else{
            return json_decode($this->attributes['question'])->en;
            }
        }else{
            return json_decode($this->attributes['question'])->en;
        }

    }
    public function getQuestionLangAttribute(){
            return json_decode($this->attributes['question']);
    }

    public function getAnswerAttribute(){
        if(\request()->header('Accept-Language')){
            if(\request()->header('Accept-Language') == 'ar'){
                return json_decode($this->attributes['answer'])->ar;
            }else{
            return json_decode($this->attributes['answer'])->en;
            }
        }else{
            return json_decode($this->attributes['answer'])->en;
        }

    }
    
    public function getAnswerLangAttribute(){
        return json_decode($this->attributes['question']);
    }

   public function scopeOfFilter($query,$req)
    {
        return $query;
    }
}
