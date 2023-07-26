<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matchCampaign extends Model
{
    use HasFactory;


    protected $fillable = ['name_ar', 'name_en', 'status'];


    public function getNameAttribute(){
        if(\request()->has('lang')){
            if(\request('lang') == 'ar')
                return $this->attributes['name_ar'];
            return $this->attributes['name_en'];
        }else{
            if(app()->getLocale() == 'ar')
                return $this->attributes['name_ar'];
            return $this->attributes['name_en'];
        }

    }
}
