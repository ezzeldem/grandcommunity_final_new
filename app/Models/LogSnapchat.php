<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSnapchat extends Model
{
    use HasFactory;

    protected $fillable = ['snapchat_id','snapchat_username','followers','uploads','engagement_average_rate'];

    public function snapchataccount(){
        return $this->belongsTo('App\Models\ScrapeSnapchat','snapchat_id','id');
    }
}
