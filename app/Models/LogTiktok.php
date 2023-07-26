<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTiktok extends Model
{
    use HasFactory;

    protected $fillable = ['tiktok_id','tiktok_username','followers','following','uploads','engagement_average_rate'];

    public function tiktokaccount(){
        return $this->belongsTo('App\Models\ScrapeTiktok','tiktok_id','id');
    }
}
