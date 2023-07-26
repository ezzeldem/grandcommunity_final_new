<?php

namespace App\Models;

use App\Http\Traits\FileAttributes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Brand extends Model
{
    use HasFactory, SoftDeletes, FileAttributes, HasJsonRelationships;

    protected $imgFolder = 'photos/brands';

    protected $fillable = [
        'name', 'user_id', 'phone', 'address', 'whatsapp', 'status', 'country_id', 'office_id', 'insta_uname', 'facebook_uname', 'tiktok_uname',
        'snapchat_uname', 'twitter_uname', 'website_uname', 'image', 'expirations_date', 'updated_at', 'created_at', 'whatsapp_code', 'step', 'skipped'
    ];
    protected $casts = [
        "phone" => "array",
        "country_id" => "array",
        'expirations_date' => 'datetime:Y-m-d',
    ];

    protected $appends = ['social_media'];



    // get Brand depend on global session country
    protected static function booted()
    {
        static::addGlobalScope('countries', function (Builder $builder) {
            if ($country = \session()->get('country')) {
                $builder->WhereRaw("JSON_CONTAINS(country_id, ?)", [json_encode(array_values($country))]);
            } elseif (\request()->hasHeader('cookieCountry') && \request()->header('cookieCountry') != -1) {
                $builder->WhereRaw("JSON_CONTAINS(country_id, ?)", [json_encode(\request()->header('cookieCountry'))]);
            } else {
                $builder;
            }
        });
    }

    public function getExpirationsDateAttribute()
    {
        return  $this->attributes['expirations_date'] ? Carbon::parse($this->attributes['expirations_date'])->format('Y-m-d') : '--';
    }

	public function getStatusAttribute()
    {
        if($this->attributes['expirations_date'] && $this->attributes['expirations_date'] <= now() && $this->attributes['expirations_date']  != 2){
            self::where('id',$this->id)->update(['status' =>2]);
            return 2;
        }
        return $this->attributes['status'];
   }


    public function getUserNameAttribute()
    {
        return $this->user->user_name;
    }

    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
    }

    public function brand_countries()
    {
        return $this->hasMany('App\Models\BrandCountry', 'brand_id', 'id');
    }
    public function subbrands()
    {
        return $this->hasMany('App\Models\Subbrand', 'brand_id');
    }
    public function dislikes()
    {
        return $this->hasMany(BrandDislike::class);
    }
    public function favouritesInfluencer()
    {
        return $this->hasMany('App\Models\BrandFav', 'brand_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function office()
    {
        return $this->belongsTo('App\Models\Office', 'office_id');
    }

    public function branchs()
    {
        return $this->hasMany('App\Models\Branch', 'brand_id');
    }

    public function influencers()
    {
        return $this->belongsToMany(Influencer::class, 'brand_favorites', "brand_id", 'influencer_id')->withPivot('date', 'deleted_at');
    }

    public function influencersFavorites() //fixme::new
    {
        return $this->belongsToMany(Influencer::class, 'influencers_groups', "brand_id", 'influencer_id')->withPivot('date', 'deleted_at', 'group_list_id');
    }

    public function campaignBrandInfluencers()
    {
        return $this->hasMany(CampaignInfluencer::class, 'brand_id');
    }

    public function group_lists()
    {
        return $this->hasMany('App\Models\GroupList', 'brand_id');
    }

    public function secrets()
    {
        return $this->hasMany(BrandSecret::class, 'brand_id');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'brand_id');
    }

    public function scopeOfDashboardFilter($query, $req)
    {

        $query->when(($req['country_val'] && $req['country_val'] != null), function ($q) use ($req) {
            $c = array_map('intval', explode(',', $req['country_val']));
            $q->whereJsonContains('country_id', $req['country_val'][0]);
            for ($i = 1; $i < count($c); $i++) {
                $q->orWhereJsonContains('country_id', $c[$i]);
            }
        });
        return $query;
    }

    public function scopeOfFilter($query, $req = null)
    {
        if(!$req){
            $req = [];
        }
        if (isset($req['country_val']) && is_string($req['country_val'])) {
            $req['country_val'] = explode(",", $req['country_val']);
        }
        $query->when(isset($req['custom']) && $req['custom'] != null, function ($q) use ($req) {
            $q->whereHas('user', function ($q) use ($req) {
                $q->where('user_name', 'like', '%' . $req['custom'] . '%');
            });
        })->when((isset($req['status_val']) && $req['status_val'] != null && $req['status_val'] != -1), function ($s) use ($req) {
            $s->where('status', $req['status_val']);
        })->when((isset($req['startDateSearch']) && $req['startDateSearch'] != null) && ($req['endDateSearch'] != null && strtotime($req['startDateSearch']) == true && strtotime($req['endDateSearch'])), function ($q) use ($req) {
            $q->whereBetween('created_at', [Carbon::parse($req['startDateSearch'])->format("Y-m-d"), Carbon::parse($req['endDateSearch'])->format("Y-m-d")]);
        })->when((isset($req['country_val']) && $req['country_val'] != null), function ($q) use ($req) {
            $q->where(function ($q2) use ($req) {
                $q2->whereJsonContains('country_id', $req['country_val'][0]);
                for ($i = 1; $i < count($req['country_val']); $i++) {
                    $q2->orWhereJsonContains('country_id', $req['country_val'][$i]);
                }
            });

        })->when((isset($req['office_val']) && $req['office_val'] != null), function ($q) use ($req) {
            $q->where('office_id', $req['office_val']);
        })->when((isset($req['profile_completed_val']) && $req['profile_completed_val'] != null), function ($q) use ($req) {
            if ($req['profile_completed_val'] == 1) {
                $q->whereNotNull('whatsapp')->whereNotNull('country_id');
            } else {
                $q->where(function ($q2){
                    $q2->whereNull('whatsapp')->orWhereNull('country_id');
                });
                $q->whereNull('whatsapp')->whereNull('country_id')->whereNull('insta_uname');
            }
        })->when((isset($req['pending_search']) && !is_null($req['pending_search'])), function ($q) use ($req) {
            if ($req['pending_search'] == 0) {
                $q->whereHas('subbrands', function ($i) {
                    $i->whereDate('created_at', '>=', Carbon::now()->subDays(2))->where('status', 0);
                });
            } else {
                $q->whereHas('branchs', function ($i) {
                    $i->where('created_at', '>=', Carbon::now()->subDays(2))->where('status', 0);
                });
            }
        })->when((isset($req['lastest_collaboration_search']) && !is_null($req['lastest_collaboration_search'])), function ($q) use ($req) {
            $q->whereHas('campaigns', function ($i) use ($req) {
                if ($req['lastest_collaboration_search'] == 0) {
                    $i->whereDate('created_at', '<=', Carbon::today()->startOfMonth()->subMonth());
                } elseif ($req['lastest_collaboration_search'] == 1) {
                    $i->whereDate('created_at', '<=', Carbon::today()->startOfMonth()->subMonth(3));
                } elseif ($req['lastest_collaboration_search'] == 2) {
                    $i->whereDate('created_at', '<=', Carbon::today()->startOfMonth()->subMonth(6));
                } elseif ($req['lastest_collaboration_search'] == 3) {
                    $i->whereDate('created_at', '<=', Carbon::today()->startOfMonth()->subYear());
                }
            });
        })->when((isset($req['camp_val']) && $req['camp_val'] != null), function ($q) use ($req) {
            $q->whereHas('campaigns', function ($i) use ($req) {
                $i->whereIn('status', $req['camp_val']);
            });
        })->when((isset($req['status_id_search']) && $req['status_id_search'] != null), function ($q) use ($req) {
            $q->where('status', $req['status_id_search']);
        });

        $orderBy = $req['sorted_by']??"id";
        $orderType = $req['sorted_type']??"desc";
        switch ($orderBy){
            case "group_of_brands":
                $query->withCount('subbrands')->orderBy('subbrands_count', $orderType);
                break;
            case "campaigns_count":
                $query->withCount('campaigns')->orderBy('campaigns_count', $orderType);
                break;
            case "expirations_date":
                $query->orderBy('brands.expirations_date', $orderType);
                break;
            case "created_at":
                $query->orderBy('brands.created_at', $orderType);
                break;
            case "user_name":
                $query->orderBy('users.user_name', $orderType);
                break;
            default:
                $query->orderBy('brands.id', "desc");
        }

        return $query;
    }

    public function countries()
    {
        return $this->belongsToJson(Country::class, 'country_id');
    }

    public function instagram()
    {
        return $this->hasone(ScrapeInstagram::class, 'influe_brand_id')->where('type', 2);
    }
    public function tiktok()
    {
        return $this->hasOne(ScrapeTiktok::class, 'influe_brand_id')->where('type', 2);
    }
    public function snapchat()
    {
        return $this->hasone(ScrapeSnapchat::class, 'influe_brand_id')->where('type', 2);
    }
    public function facebook()
    {
        return $this->hasone(ScrapeFacebook::class, 'influe_brand_id')->where('type', 2);
    }
    public function twitter()
    {
        return $this->hasone(ScrapeTwitter::class, 'influe_brand_id')->where('type', 2);
    }

    public function InfluencerPhones()
    {
        return $this->hasMany(InfluencerPhone::class, 'influencer_id');
    }


    public static function socailMediaInputs($socials)
    {

        $data = ['snapchat_uname' => '', 'twitter_uname' => '', 'facebook_uname' => '', 'tiktok_uname' => '', 'insta_uname' => ''];
        foreach ($socials as $single) {
            if (isset($single['key']) && !empty($single['key'])) {
                switch ($single['key']) {
                    case 'snapchat':
                        $data['snapchat_uname'] = $single[$single['key'] . '_value'];
                        break;
                    case 'twitter':
                        $data['twitter_uname'] = $single[$single['key'] . '_value'];
                        break;
                    case 'facebook':
                        $data['facebook_uname'] = $single[$single['key'] . '_value'];
                        break;
                    case 'tiktok':
                        $data['tiktok_uname'] = $single[$single['key'] . '_value'];
                        break;
                    case 'instagram':
                        $data['insta_uname'] = $single[$single['key'] . '_value'];
                        break;
                }
            }
        }
        return $data;
    }
}
