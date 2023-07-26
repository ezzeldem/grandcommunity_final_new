<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Interest extends Model
{
    use HasFactory, HasJsonRelationships;

    protected $fillable = ['interest', 'status'];
    protected $casts= ['interest'=>'array'];


    public function getInterestAttribute(){
        return  @((array)json_decode($this->attributes['interest']))[app()->getLocale()];
    }
}

