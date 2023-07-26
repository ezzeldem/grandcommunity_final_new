<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerChild extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function influencer(){
        return $this->belongsTo(Influencer::class);
    }
}


