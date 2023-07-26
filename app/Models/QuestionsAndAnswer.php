<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class QuestionsAndAnswer extends Model
{
 use HasFactory, HasTranslations;

     public $translatable = ['question', 'answer'];
     protected $fillable = ['question','answer','case_study_id'];

     public function caseStudy(){
        return $this->belongsTo(CaseStudies::class,'case_study_id');
     }
     public function getQuestionAttribute(){
        return  @((array)json_decode($this->attributes['question']))[app()->getLocale()];
    }
    public function getAnswerAttribute(){
        return  @((array)json_decode($this->attributes['answer']))[app()->getLocale()];
    }
}
