<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerChangeDetail extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts=['status'=>'array','address'=>'array'];
    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function state(){
        return $this->belongsTo(State::class,'state_id');

    }
    public function city(){
        return $this->belongsTo(City::class,'city_id');

    }
}
