<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandDislike extends Model
{
    use HasFactory;

    protected $fillable = [
        'influencer_id','brand_id'
    ];
    public function influencer(){
        return $this->belongsTo(Influencer::class,'influencer_id');
    }

}
