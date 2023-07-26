<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTwitter extends Model
{
    use HasFactory;

    protected $fillable = ['twitter_id','twitter_username','followers','following','uploads','engagement_average_rate'];

    public function twitteraccount(){
        return $this->belongsTo('App\Models\ScrapeTwitter','twitter_id','id');
    }
}
