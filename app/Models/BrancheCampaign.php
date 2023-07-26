<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrancheCampaign extends Model
{
    use HasFactory;

    protected $fillable = ['branche_id', 'campaign_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branche_id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
