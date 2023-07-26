<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerComplain extends Model
{
    use HasFactory;

    protected $fillable = ['influencer_id', 'campaign_id', 'status','complain'];


    public function campaign()
    {
       return $this->belongsTo(Campaign::class,'campaign_id');
    }

    public function influencer()
    {
       return $this->belongsTo(Influencer::class,'influencer_id');
    }

    public function replies()
    {
       return $this->hasMany(InfluencerComplainReply::class,'complain_reply_id');
    }


    public function getCreatedAtAttribute()
    {
        return Carbon::parse( $this->attributes['created_at'])->diffForHumans();
    }

    
}
