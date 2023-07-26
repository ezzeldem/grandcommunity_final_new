<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $fillable = ['country_id', 'name'];
    protected $table = 'states';

    public function cities(){
        return $this->hasMany(City::class,'state_id','id');
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function getNameAttribute(){
        return @((array)json_decode($this->attributes['name']))[app()->getLocale()];
    }
}
