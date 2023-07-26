<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class InfluencerGroup extends Model
{
	use SoftDeletes;
    protected $table = "influencers_groups";
    protected $guarded = ['id'];
	protected $softDelete = true;

    public function influencer(){
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function group(){
        return $this->belongsTo(GroupList::class, 'group_list_id');
    }
}
