<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaInstagram extends Model
{
    use HasFactory;

    protected $fillable = ['instagram_id','media_id','caption','media_type','shortcode','likes','comments','type','post_reel_type'];

	protected $hidden = ['created_at','updated_at'];
    public function instaaccount(){
        return $this->belongsTo(ScrapeInstagram::class,'instagram_id','id');
    }
}
