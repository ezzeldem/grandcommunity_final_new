<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $table = 'nationalities';

    protected $fillable = [
        'code','name','active'
    ];

        public function getNameAttribute(){
        return @((array)json_decode($this->attributes['name']))[app()->getLocale()];
    }
}
