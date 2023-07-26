<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignCoverageChannel extends Model
{
    use HasFactory;
    protected $table = 'campaign_coverage_channels';
    protected $guarded = [];
    protected $casts = [

        'posts'=>'array',
        'stories'=>'array',
        'reels'=>'array',
        


    ];

    public function CampaignCoverage(){
        return $this->hasMany(CampaignCoverageChannel::class);
    }
}
