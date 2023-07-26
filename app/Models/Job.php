<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Job extends Model
{
    protected $table='users_jobs';
    use HasFactory , HasJsonRelationships;
    protected $fillable = ['name', 'status'];

	public function getNameAttribute(){
        return @((array)json_decode($this->attributes['name']))[app()->getLocale()];
    }

}
