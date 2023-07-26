<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;
    protected $table='status';
    protected $guarded = [];
    public $translatable = ['name'];
    protected $casts= ['name'=>'array'];

    public function getNameAttribute(){
        return @((array)json_decode($this->attributes['name']))[app()->getLocale()];
    }
}
