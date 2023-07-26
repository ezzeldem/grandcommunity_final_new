<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfluencerClassification extends Model
{
    //use HasFactory;
    protected $fillable = ['name', 'status'];
     protected $casts=['name'=>'array'];


     public function getNameAttribute(){
         return  @((array)json_decode($this->attributes['name']))[app()->getLocale()];
     }
}
