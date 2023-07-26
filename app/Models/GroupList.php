<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class GroupList extends Model
{
    use HasFactory, SoftDeletes, HasJsonRelationships;

    protected $fillable=['name','created_by','color','brand_id','country_id','sub_brand_id','deleted_at'];

    protected $casts=['country_id'=>'array'];

    public function brands(){
        return $this->belongsTo('App\Models\Brand','brand_id','id');
    }


    public function sub_brands(){
        return $this->belongsTo('App\Models\Subbrand','sub_brand_id','id');
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
    // get Group depend on global session country
    protected static function booted()
    {

        static::addGlobalScope('countries', function (Builder $builder) {
            if($country=\session()->get('country')){
                $builder->WhereRaw("JSON_CONTAINS(country_id, ?)", [json_encode(array_values($country))]);
            }elseif(\request()->hasHeader('cookieCountry') && \request()->header('cookieCountry') != -1){
//                dd(\request()->header('cookieCountry'));
                $builder->whereJsonContains('country_id',(integer)\request()->header('cookieCountry'));
            }else{
                $builder;
            }
        });
    }

    public function scopeOfFilter($query, $req){
        return $query->when((array_key_exists('name',$req)&&$req['name']!=null),function ($q)use($req){
            $q->where('name', 'LIKE', '%'.$req['name'].'%');
        })->when((array_key_exists('country_id',$req)&&!empty($req['country_id'])),function ($q)use($req){
            $countries = is_array($req['country_id'])?$req['country_id']:explode(',',$req['country_id']);
            $q->whereJsonContains('country_id',$countries[0]);
            for($i = 1; $i <= count($countries) - 1; $i++) {
                $q->orWhereJsonContains('country_id', $countries[$i]);
            }
        });
    }

    public function getCountryIdAttribute(){
        $brand = $this->brands;
        if($brand){
            return is_array($brand->country_id)?$brand->country_id:[];
        }
        return [];
    }

    public function influencers()
    {
        return $this->belongsToMany(Influencer::class,'influencers_groups','group_list_id','influencer_id')->withPivot(['brand_id', 'influencer_id', 'deleted_at', 'group_deleted_at'])->withTimestamps();
    }

    public function countries(){
        return $this->belongsToJson(Country::class,'country_id');
    }

	

}
