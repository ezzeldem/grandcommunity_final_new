<?php

namespace App\Models;

use App\Http\Traits\FileAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;
    use FileAttributes;
    protected $imgFolder = 'photos/statistics';

    protected $fillable = [
        'ar_title', 'en_title', 'ar_body', 'en_body', 'count', 'image','active'
    ];


    protected $appends = ['title','body'];

    public function getTitleAttribute(){
        if(\request()->has('lang')){
            if(\request('lang') == 'ar')
                return $this->attributes['ar_title'];
            return $this->attributes['en_title'];
        }else{
            if(app()->getLocale() == 'ar')
                return $this->attributes['ar_title'];
            return $this->attributes['en_title'];
        }

    }



    public function getBodyAttribute(){
        if(\request()->has('lang')){
            if(\request('lang') == 'ar')
                return $this->attributes['ar_body'];
            return $this->attributes['en_body'];
        }else{
            if(app()->getLocale() == 'ar')
                return $this->attributes['ar_body'];
            return $this->attributes['en_body'];
        }

    }

    public function scopeOfFilter($query,$req)
    {
        return $query;
    }
}
