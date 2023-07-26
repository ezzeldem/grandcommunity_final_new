<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Spatie\Translatable\HasTranslations;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use function Psy\debug;

class Country extends Model
{
    use HasFactory,HasJsonRelationships;

    protected $fillable = ['id','name','code','phonecode','timezone','currency_code'];
  protected $appends=['url'];
    public function states(){
        return $this->hasMany(State::class,'country_id','id');
    }

    public function brands(){
        return $this->hasManyJson(Brand::class, 'country_id');
    }

    public function subbrands(){
        return $this->hasManyJson(Subbrand::class, 'country_id');
    }

    public function getUrlAttribute(){
        return "https://hatscripts.github.io/circle-flags/flags/".strtolower($this->code).".svg";
    }

    public function cities(){
        return $this->hasManyThrough(City::class,State::class);
    }
    public function getNameAttribute(){
         return  @((array)json_decode($this->attributes['name']))[app()->getLocale()];
    }

    public function offices(){
        return $this->hasMany(Office::class,'country_id','id');
    }
}

