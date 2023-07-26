<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;


class CoverageChannel extends Model
{
    use HasFactory , HasJsonRelationships;
    
    protected $fillable = ['name'];

    protected $hidden = ['status', 'updated_at', 'created_at'];

	public function getNameAttribute(){
        return @((array)json_decode($this->attributes['name']))[app()->getLocale()];
    }
}
