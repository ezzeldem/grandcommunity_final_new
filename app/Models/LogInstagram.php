<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogInstagram extends Model
{
    use HasFactory;

    protected $fillable = ['instagram_id','instagram_username','followers','following','uploads','engagement_average_rate'];

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function instaaccount(){
        return $this->belongsTo('App\Models\ScrapeInstagram','instagram_id','id');
    }
}
