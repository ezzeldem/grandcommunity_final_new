<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogCamp extends Model
{
    use HasFactory;
    protected $fillable = ['campaign_id','influencer_id','user_id','action_type','action'];


    public function getCreatedAtAttribute()
    {
        return Carbon::parse( $this->attributes['created_at'])->diffForHumans();
    }

    public function campaign(){
        return $this->belongsTo(Campaign::class,'campaign_id','id','campaign_id');
    }

    public function admin(){
        return $this->belongsTo(Admin::class,'campaign_id','id','campaign_id');
    }

    public function influencer(){
        return $this->belongsTo(Influencer::class,'influencer_id','id','influencer_id');
    }
}

