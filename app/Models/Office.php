<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country_id', 'status'];

    public function country(){
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }

    public function sales(){
        return $this->belongsTo('App\Models\Admin', 'id', 'sales_id');
    }
}
