<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerPhone extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey   = 'influencer_id';
    public    $incrementing = false;
    public function influencer(){
        return $this->belongsTo(Influencer::class);
    }
}
