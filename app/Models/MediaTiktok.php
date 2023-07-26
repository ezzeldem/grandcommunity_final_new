<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaTiktok extends Model
{
    use HasFactory;
    protected $fillable = ['tiktok_id','video_id','media_url','created_at','updated_at','likes','share','view','comments','type'];
	protected $hidden = ['created_at','updated_at'];
    public function tiktokaccount(){
        return $this->belongsTo('App\Models\ScrapeTiktok','tiktok_id','id');
    }
}
