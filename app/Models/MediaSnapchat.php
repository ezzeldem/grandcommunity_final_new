<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaSnapchat extends Model
{
    use HasFactory;
    protected $fillable = ['snapchat_id','media_id','shortcode','media_type','view','share'];
	protected $hidden = ['created_at','updated_at'];
    public function snapaccount(){
        return $this->belongsTo(ScrapeSnapchat::class,'snapchat_id','id');
    }
}
