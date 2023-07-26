<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerComplainReply extends Model
{
    use HasFactory;
    protected $fillable = ['complain_reply_id', 'reply_text','user_id'];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse( $this->attributes['created_at'])->diffForHumans();
    }

    public function admin()
    {
       return $this->belongsTo(Admin::class,'user_id');
    }
}
