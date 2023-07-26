<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaTwitter extends Model
{
    protected $fillable = ['twitter_id','shortcode','caption','favorite_count','quote_count','reply_count','retweet_count'];
    protected $table='media_twitter';

	protected $hidden = ['created_at','updated_at'];

    public function twitteraccount(){
        return $this->belongsTo(ScrapeTwitter::class,'twitter_id','id');
    }
}
