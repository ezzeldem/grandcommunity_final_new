<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable =['id','name','country_id','city','status','subbrand_id','brand_id','state','created_at','address','lat','lng'];
    protected $hidden = ['pivot'];
    protected $casts = [
        'status'=> 'string',
        'city'=> 'integer',
        'state'=> 'integer',
    ];

    public function subbrand(){
        return $this->belongsTo(Subbrand::class,'subbrand_id','id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id','id');
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }
    public function cities(){
        return $this->belongsTo(City::class,'city','id');
    }
    public function states(){
        return $this->belongsTo(State::class,'state','id');
    }

    public function getCreatedAtAttribute($val){
        return $val ? Carbon::parse($val)->format('Y-m-d') : '..';
    }

    // get branches depend on global session country
    protected static function booted()
    {
        static::addGlobalScope('countries', function (Builder $builder) {
            if($country=\session()->get('country')){
                $builder->whereIn('country_id', $country);
            }
            elseif(\request()->hasHeader('cookieCountry') && \request()->header('cookieCountry') != -1){
                $builder->whereIn("country_id",explode(',',\request()->header('cookieCountry')));
            }
            else{
                $builder;
            }
        });
    }

    public function scopeOfFilter($query,$req)
    {
     $query->when(array_key_exists('status_val', $req) && $req['status_val'] != null, function ($q) use ($req) {
            $status=($req['status_val']==2)?0:$req['status_val'];
            $q->where('branches.status', intval($status));
        })->when(array_key_exists('country_val', $req) && $req['country_val'] != null, function ($q) use ($req) {
			// if(is_array($req['country_val']))
			//    $q->whereIn('branches.country_id',$req['country_val']);
			// else
            //    $q->where('branches.country_id', (int)$req['country_val']);
            if(gettype( $req['country_val'])!="array"){
                $req['country_val']=explode(',',$req['country_val']);
            }
            $q->whereIn('branches.country_id',$req['country_val']);
        })->when(array_key_exists('brand_val', $req) && $req['brand_val'] != null, function ($q) use ($req) {
            $q->where('brand_id', $req['brand_val']);
        })->when(array_key_exists('subbrand_val', $req) && $req['subbrand_val'] != null, function ($q) use ($req) {
            $q->where(function ($q) use ($req) {
                $q->where('branches.subbrand_id', $req['subbrand_val'])
                    ->orWhere('branches.subbrand_id', 0);
            });
        })->when(array_key_exists('city_val', $req) && $req['city_val'] != null, function ($q) use ($req) {
            $q->where('branches.city', $req['city_val']);
        })->when((array_key_exists('start_date', $req) && $req['start_date'] != null) &&
            (array_key_exists('end_date', $req) && $req['end_date'] != null), function ($q) use ($req) {
            $q->whereBetween('created_at', [Carbon::parse($req['start_date']),Carbon::parse($req['end_date'])->addDay()]);

        })->when((array_key_exists('searchTerm', $req) && $req['searchTerm'] != null) , function ($q) use ($req) {
            $q->where('branches.name', 'LIKE', '%'.$req['searchTerm'].'%');

        })->when((array_key_exists('subbrand', $req) && $req['subbrand'] != null) , function ($q) use ($req) {
            $q->where('branches.subbrand_id', $req['subbrand']);
        });

    }

    public function scopeOfFilterBrand($query,$req)
    {
        return $query->when(isset($req['status_val']) && !is_null($req['status_val']), function ($q) use ($req) {
            $q->where('status', intval($req['status_val']));
        })->when(isset($req['country_val']) && !is_null($req['country_val']), function ($q) use ($req) {
            $q->where('country_id', $req['country_val']);
        });

    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class,'branche_campaigns','branche_id','campaign_id');
    }

}
