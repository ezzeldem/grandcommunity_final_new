<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Language extends Model
{
    use HasFactory, HasJsonRelationships;
    protected $fillable = ['name', 'status'];


    public function getNameAttribute(){
        return  @((array)json_decode($this->attributes['name']))[app()->getLocale()];
    }
}
