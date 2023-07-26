<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandFav extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];
    protected $table='brand_favorites';
    protected $casts=[
        'date'=>'date',
        'deleted_at'=>'date',
        'group_list_id'=>'array'
    ];
    public function influencers(){
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }

    public function campaingInfluencer(){
        return $this->hasMany('App\Models\CampaignInfluencer', 'influencer_id', 'influencer_id')->where('brand_id', $this->brand_id);
    }
}
