<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignCountryFavourite extends Model
{
    use HasFactory;

    protected $fillable =[
        'campaign_id', 'country_id', 'state_id', 'city_id', 'list_id',
    ];

    public function campaign(){
        return $this->belongsTo(Campaign::class,'campaign_id');
    }

    public function listFavourits(){

        return $this->hasMany(GroupListsFavourits::class, 'group_list_id');
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function secrets(){
        return $this->hasMany(CampaignSecret::class,'campaign_country_id');
    }
}
