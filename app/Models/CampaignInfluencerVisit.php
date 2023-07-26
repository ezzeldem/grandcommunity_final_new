<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignInfluencerVisit extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded=[];

    public function campaignInfluncer(){
        return $this->belongsTo(CampaignInfluencer::class,'campaign_influencer_id');
    }

    public function campaign(){
        return $this->belongsToMany(Campaign::class, 'campaign_influencers','id','campaign_id','campaign_influencer_id','id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');

    }
    public function Campaigndata()
    {
        return $this->belongsTo(Campaign::class, 'campaign_influencers','id','campaign_id','campaign_influencer_id','id');
    }
    public function notification()
    {
        return $this->morphMany('App\Models\Notification', 'notifable');
    }
}
