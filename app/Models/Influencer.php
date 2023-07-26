<?php

namespace App\Models;

use App\Http\Traits\FileAttributes;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\AppendsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Spatie\Translatable\HasTranslations;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

// use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;


class Influencer extends Model
{

    use HasFactory, FileAttributes, SoftDeletes, HasJsonRelationships, SearchTrait,AppendsTrait;

    protected $imgFolder = 'photos/influencers/personal';
    protected $softDelete = true;
    protected $searchableColumns = ['name'];


    protected $fillable = [
        'id','vInflUuid', 'phone', 'name', 'user_id', 'image', 'has_voucher', 'attitude_id', 'account_type', 'whats_number', 'address', 'address_ar', 'interest', 'date_of_birth', 'expirations_date', 'job',
        'country_id', 'insta_uname', 'facebook_uname', 'tiktok_uname', 'snapchat_uname', 'twitter_uname', 'gender', 'active', 'code_whats',
        'nationality', 'city_id', 'lang', 'children_num', 'children', 'state_id', 'website_uname',
        'ethink_category', 'min_voucher', 'citizen_status', 'v_by_g', 'licence',
        'youtube_uname', 'influ_code', 'qrcode', 'classification_ids', 'category_ids', 'marital_status', 'country_visited_outofcountry', 'influencer_return_date', 'step', 'coverage_channel', 'deleted_by'
    ];


    protected $casts = [
        'phone' => 'array',
        'children' => 'array',
        'lang' => 'array',
        'interest' => 'array',
        'coverage_channel' => 'array',
        'category_ids' => 'array',
        'date_of_birth' => 'datetime:Y-m-d',
        'expirations_date' => 'datetime:Y-m-d',
        'influencer_return_date' => 'datetime:Y-m-d',
        'created_at' => 'date:Y-m-d',
        'classification_ids' => 'array',
    ];

    protected $appends = ['influencer_classification', 'social_media'];

    public function getClassificationIdsAttribute($val)
    {
        if (!empty($val)){
            return json_decode($val);
        }

        return [];

    }


    public function getInfluencerClassificationAttribute()
    {
        if (is_array($this->classification_ids)){
            return InfluencerClassification::whereIn('id', $this->classification_ids)->pluck('name')->toArray();
        }

        return [];
    }

     public function setVInflUuidAttribute($val)
     {
		if(is_null($val))
          $this->attributes['vInflUuid'] = generateRandomInfluencerId();
     }


    public function getAddreses()
    {
        $address = [];
        if ($this->address != null) {
            $address['en'] =  $this->address;
            $address['ar'] =  $this->address_ar;
        }
        return $address;
    }

    public function getCategoryIdsAttribute($val)
    {
        $category_id =  $val?json_decode($val):[];
        return    $category_id;
    }

    public function scopeCategories()
    {
        if(is_array($this->category_ids)){
            return InfluencerClassification::whereIn('id', $this->category_ids)->whereStatus('category')->pluck('name')->toArray();
        }

        return [];
    }

    public function scopeOfFilter($query, $req)
    {
        if(isset($req['searchWord']) && $req['searchWord']){
            $query->where(function ($q) use ($req) {
                $q->whereHas('user', function ($subQ) use ($req) {
                    $subQ->where('user_name', 'like', '%' . $req['searchWord'] . '%');
                })->orWhere("name", 'like', '%' . $req['searchWord'] . '%');
            });
        }

        // if(isset($req['have_child']) && !is_null($req['have_child']) && (int) $req['have_child'] == 0){
        //     $query->where(function ($q){
        //         $q->where('children_num', 0)
        //           ->orWhere('children_num', null);
        //     });
        // }

        // if($req['have_child'] > 0){
        //     $query->where('children_num', ">", 0);
        // }

       $query = $query->when(array_key_exists('check_status', $req) && $req['check_status'] != null, function ($q) use ($req) {
            $q->whereJsonContains('status', $req['check_status'][0]);
            for ($i = 1; $i < count($req['check_status']); $i++) {
                $q->orWhereJsonContains('status', $req['check_status'][$i]);
            }

        })->when((array_key_exists('start_date', $req) && $req['start_date'] != null && $req['end_date'] != "start_date") &&
            (array_key_exists('end_date', $req) && $req['end_date'] != null && $req['end_date'] != "endDateSearch"), function ($q) use ($req) {
            $q->whereBetween('created_at', [Carbon::parse($req['start_date']), Carbon::parse($req['end_date'])])
                ->orWhereRaw('DATE(created_at) = ?', [Carbon::parse($req['start_date'])])
                ->orWhereRaw('DATE(created_at) = ?', [Carbon::parse($req['end_date'])]);

        })->when((array_key_exists('name_search', $req) && $req['name_search'] != null), function ($q) use ($req) {
            $q->where('influencers.name', 'like', "%" . $req['name_search'] . "%");
        })->when((array_key_exists('have_child', $req) && !$req['have_child'] != null), function ($q) use ($req) {
			if($req['have_child'] == "0")
			      $q->where('children_num', 0)->orWhere('children_num', null);
			else
			    $q->where('children_num', ">", 0);
        });

       return $query;
    }

    public function scopeOfSocialFilter($query, $req)
    {

        $query->where(function ($i) use ($req) {
            if (!isset($req['dislike_favourites'])) {
                $i->WhereDoesntHave('dislikes', function ($x) {
                    $x->where('brand_id', @auth()->user()->brands->id);
                });
            } else {
                if ($req['dislike_favourites'] == 'dislike') {
                    $i->WhereHas('dislikes', function ($x) {
                        $x->where('brand_id', @auth()->user()->brands->id);
                    });
                }
            }
        })
            ->when(array_key_exists('search', $req) && $req['search'] != null, function ($q) use ($req) {
                $q->where('name', 'like', "%" . $req['search'] . "%");
            })
            ->when(array_key_exists('InfluencerType', $req) && $req['InfluencerType'] != null, function ($q) use ($req) {
                if ($req['InfluencerType'] == 'vip') {
                    $q->whereJsonContains('status', 2);
                } elseif ($req['InfluencerType'] == 'child') {
                    $q->where('social_status', 2);
                } else {
                    $q->where($req['InfluencerType'], 1);
                }
            })->when(array_key_exists('InfluencerGender', $req) && $req['InfluencerGender'] != null, function ($q) use ($req) {
                if ($req['InfluencerGender'] == 'male') {
                    $q->where('gender', 1);
                } else {
                    $q->where('gender', 0);
                }
            })->when(array_key_exists('InfluencerAge', $req) && $req['InfluencerAge'] != null, function ($q) use ($req) {
                $q->where('date_of_birth',  Carbon::now()->subYear($req['InfluencerAge'])->format('Y-m-d'));
            })
            ->when(array_key_exists('InfluencerInterests', $req) && $req['InfluencerInterests'] != null, function ($q) use ($req) {

                $q->WhereJsonContains('interest', $req['InfluencerInterests']);
            })

            ->when(array_key_exists('InfluencerJob', $req) && $req['InfluencerJob'] != null, function ($q) use ($req) {
                $q->select('influencers.*')
                    ->join('jobs', 'jobs.id', '=', 'influencers.job')
                    ->where("influencers.job", $req['InfluencerJob']);
            })
            ->when(array_key_exists('InfluencerLanguage', $req) && $req['InfluencerLanguage'] != null, function ($q) use ($req) {
                $q->WhereJsonContains("lang", $req['InfluencerLanguage']);
            })
            ->when(array_key_exists('InfluencerAccountStatus', $req) && $req['InfluencerAccountStatus'] != null, function ($q) use ($req) {
                $q->where('account_status', $req['InfluencerAccountStatus']);
            })
            ->when(array_key_exists('InfluencerRating', $req) && $req['InfluencerRating'] != null, function ($q) use ($req) {
                $q->where('rating', $req['InfluencerRating']);
            })
            ->when(array_key_exists('InfluencerSocialClass', $req) && $req['InfluencerSocialClass'] != null, function ($q) use ($req) {
                $q->where('social_class', $req['InfluencerSocialClass']);
            })
            ->when(array_key_exists('InfluencerEthnic', $req) && $req['InfluencerEthnic'] != null, function ($q) use ($req) {
                $q->where('ethink_category', $req['InfluencerEthnic']);
            })
            ->when(array_key_exists('InfluencerCitizenship', $req) && $req['InfluencerCitizenship'] != null, function ($q) use ($req) {
                $q->where('citizen_status', $req['InfluencerCitizenship']);
            })
            ->when((array_key_exists('dislike_favourites', $req) && $req['dislike_favourites'] != null), function ($q) use ($req) {
                if ($req['dislike_favourites'] == 'favorite')
                    $q->whereRelation('brands', 'brand_favorites.brand_id', @auth()->user()->brands->id);
                elseif ($req['dislike_favourites'] == 'dislike') {
                    $q->whereRelation('dislikes', 'brand_id', @auth()->user()->brands->id);
                } elseif ($req['dislike_favourites'] == 'name') {
                    $q->orderByRaw("influencers.name " . $req['name_sort_type']);
                } elseif ($req['dislike_favourites'] == 'followers') {
                    $q->select('influencers.*')
                        ->join('scrape_instagrams', 'scrape_instagrams.influe_brand_id', '=', 'influencers.id')
                        ->orderByRaw("CONVERT(scrape_instagrams.followers, SIGNED) " . $req['followers_sort_type']);
                } elseif ($req['dislike_favourites'] == 'new') {
                    $q->select('influencers.*');
                } elseif ($req['dislike_favourites'] == 'lastAdded') {
                    $q->orderBy('created_at', 'desc');
                } elseif ($req['dislike_favourites'] == 'groupData') {
                    $brand_id = @auth()->user()->brands->id;
                    $group_id = $req['group_id'];
                    $q->whereHas('brands', function ($s) use ($group_id, $brand_id) {
                        $s->where('brands.id', $brand_id);
                        $s->where(function ($q2) use ($group_id) {
                            $q2->whereJsonContains('brand_favorites.group_list_id', [['list_id' => (int) $group_id, 'deleted_at' => null]]);
                            $q2->orWhereJsonContains('brand_favorites.group_list_id', [['list_id' => (string) $group_id, 'deleted_at' => null]]);
                        });
                    });
                }
            })
            ->when(array_key_exists('country_id', $req) && $req['country_id'] != null, function ($q) use ($req) {
                //            dd($req['countries_id']);
                $countries = is_array($req['country_id']) ? $req['country_id'] : explode(',', $req['country_id']);
                $q->whereIn('country_id', $countries);
            })
            ->when(array_key_exists('searchCountry', $req) && $req['searchCountry'] != null, function ($q) use ($req) {
                $q->whereHas('country', function (Builder $query) use ($req) {
                    $query->where('name', 'like', '%' . $req['searchCountry'] . '%');
                });
                //                $q->whereRelation('country','code',$req['searchCountry']);
            })
            ->when(array_key_exists('tiktok', $req) && $req['tiktok'] == true, function ($q) use ($req) {
                $q->where('tiktok_uname', '!=', null)->has('tiktok');
            })
            ->when(array_key_exists('instagram', $req) && $req['instagram'] == true, function ($q) use ($req) {
                $q->where('insta_uname', '!=', null)->has('instagram');
            })
            ->when(array_key_exists('snapchat', $req) && $req['snapchat'] == true, function ($q) use ($req) {
                $q->where('snapchat_uname', '!=', null)->has('snapchat');
            })
            ->when(array_key_exists('facebook', $req) && $req['facebook'] == true, function ($q) use ($req) {
                $q->where('facebook_uname', '!=', null)->has('facebook');
            })
            ->when(array_key_exists('twitter', $req) && $req['twitter'] == true, function ($q) use ($req) {
                $q->where('twitter_uname', '!=', null)->has('twitter');
            })
            ->when(array_key_exists('min_followers', $req) && $req['min_followers'] != null && !array_key_exists('max_followers', $req), function ($q) use ($req) {
                $q->where(function ($i) use ($req) {
                    $i->when(array_key_exists('socialByFollowers', $req) && $req['socialByFollowers'] == 'instagram', function ($q) use ($req) {
                        $q->WhereHas('instagram', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_instagrams.followers,double)>=?", [$req['min_followers']]);
                        });
                    })->when(array_key_exists('socialByFollowers', $req) && $req['socialByFollowers'] == 'tiktok', function ($q) use ($req) {
                        $q->WhereHas('tiktok', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_tiktoks.followers,double)>=?", [$req['min_followers']]);
                        });
                    })->when(array_key_exists('socialByFollowers', $req) && $req['socialByFollowers'] == 'snapchat', function ($q) use ($req) {
                        $q->WhereHas('snapchat', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_snapchats.followers,double)>=?", [$req['min_followers']]);
                        });
                    });
                });
            })
            ->when(array_key_exists('max_followers', $req) && $req['max_followers'] != null && !array_key_exists('min_followers', $req), function ($q) use ($req) {
                $q->where(function ($i) use ($req) {
                    $i->when(array_key_exists('socialByFollowers', $req) && $req['socialByFollowers'] == 'instagram', function ($q) use ($req) {
                        $q->WhereHas('instagram', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_instagrams.followers,double)<=?", [$req['max_followers']]);
                        });
                    })->when(array_key_exists('socialByFollowers', $req) && $req['socialByFollowers'] == 'tiktok', function ($q) use ($req) {
                        $q->WhereHas('tiktok', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_tiktoks.followers,double)<=?", [$req['max_followers']]);
                        });
                    })->when(array_key_exists('socialByFollowers', $req) && $req['socialByFollowers'] == 'snapchat', function ($q) use ($req) {
                        $q->WhereHas('snapchat', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_snapchats.followers,double)<=?", [$req['max_followers']]);
                        });
                    });
                });
            })
            ->when((array_key_exists('min_followers', $req) && $req['min_followers'] != null) &&
                (array_key_exists('max_followers', $req) && $req['max_followers'] != null), function ($q) use ($req) {
                $q->when(array_key_exists('socialByFollowers', $req) && $req['socialByFollowers'] == 'instagram', function ($i) use ($req) {
                    $i->WhereHas('instagram', function ($s) use ($req) {
                        $s->whereRaw("CONVERT(scrape_instagrams.followers,double) BETWEEN  ? and ?", [$req['min_followers'], $req['max_followers']]);
                    });
                })->when(array_key_exists('socialByFollowers', $req) && $req['socialByFollowers'] == 'tiktok', function ($i) use ($req) {
                    $i->WhereHas('tiktok', function ($s) use ($req) {
                        $s->whereRaw("CONVERT(scrape_tiktoks.followers,double) BETWEEN  ? and ?", [$req['min_followers'], $req['max_followers']]);
                    });
                })->when(array_key_exists('socialByFollowers', $req) && $req['socialByFollowers'] == 'snapchat', function ($i) use ($req) {
                    $i->WhereHas('snapchat', function ($s) use ($req) {
                        $s->whereRaw("CONVERT(scrape_snapchats.followers,double) BETWEEN  ? and ?", [$req['min_followers'], $req['max_followers']]);
                    });
                });
            })
            ->when(array_key_exists('min_engagement', $req) && $req['min_engagement'] != null && !array_key_exists('max_engagement', $req), function ($q) use ($req) {
                $q->where(function ($i) use ($req) {
                    $i->when(array_key_exists('socialByEng', $req) && $req['socialByEng'] == 'instagram', function ($q) use ($req) {
                        $q->WhereHas('instagram', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_instagrams.engagement_average_rate,double)>=?", [$req['min_engagement']]);
                        });
                    })->when(array_key_exists('socialByEng', $req) && $req['socialByEng'] == 'tiktok', function ($q) use ($req) {
                        $q->WhereHas('tiktok', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_tiktoks.engagement_average_rate,double)>=?", [$req['min_engagement']]);
                        });
                    })->when(array_key_exists('socialByEng', $req) && $req['socialByEng'] == 'snapchat', function ($q) use ($req) {
                        $q->WhereHas('snapchat', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_snapchats.engagement_average_rate,double)>=?", [$req['min_engagement']]);
                        });
                    });
                });
            })
            ->when(array_key_exists('max_engagement', $req) && $req['max_engagement'] != null && !array_key_exists('min_engagement', $req), function ($q) use ($req) {
                $q->where(function ($i) use ($req) {
                    $i->when(array_key_exists('socialByEng', $req) && $req['socialByEng'] == 'instagram', function ($q) use ($req) {
                        $q->WhereHas('instagram', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_instagrams.engagement_average_rate,double)<=?", [$req['max_engagement']]);
                        });
                    })->when(array_key_exists('socialByEng', $req) && $req['socialByEng'] == 'tiktok', function ($q) use ($req) {
                        $q->WhereHas('tiktok', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_tiktoks.engagement_average_rate,double)<=?", [$req['max_engagement']]);
                        });
                    })->when(array_key_exists('socialByEng', $req) && $req['socialByEng'] == 'snapchat', function ($q) use ($req) {
                        $q->WhereHas('snapchat', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_snapchats.engagement_average_rate,double)<=?", [$req['max_engagement']]);
                        });
                    });
                });
            })
            ->when((array_key_exists('min_engagement', $req) && $req['min_engagement'] != null) &&
                (array_key_exists('max_engagement', $req) && $req['max_engagement'] != null), function ($q) use ($req) {
                $q->where(function ($i) use ($req) {
                    $i->when(array_key_exists('socialByEng', $req) && $req['socialByEng'] == 'instagram', function ($q) use ($req) {
                        $q->WhereHas('instagram', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_instagrams.engagement_average_rate,double) BETWEEN  ? and ?", [$req['min_engagement'], $req['max_engagement']]);
                        });
                    })->when(array_key_exists('socialByEng', $req) && $req['socialByEng'] == 'tiktok', function ($q) use ($req) {
                        $q->WhereHas('tiktok', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_tiktoks.engagement_average_rate,double) BETWEEN  ? and ?", [$req['min_engagement'], $req['max_engagement']]);
                        });
                    })->when(array_key_exists('socialByEng', $req) && $req['socialByEng'] == 'snapchat', function ($q) use ($req) {
                        $q->WhereHas('snapchat', function ($s) use ($req) {
                            $s->whereRaw("CONVERT(scrape_snapchats.engagement_average_rate,double) BETWEEN  ? and ?", [$req['min_engagement'], $req['max_engagement']]);
                        });
                    });
                });
            })
            ->when(array_key_exists('last_added', $req) && $req['last_added'] == true, function ($q) use ($req) {
                $q->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()]);
            })
            ->when(array_key_exists('sort_by', $req) && array_key_exists('sort_type', $req), function ($q) use ($req) {
                if ($req['sort_by'] != null && $req['sort_type'] != null) {
                    if (($req['sort_by'] == 'id' || $req['sort_by'] == 'name')) {
                        $q->orderBy($req['sort_by'], $req['sort_type']);
                    } elseif ($req['sort_by'] == 'lastAdd') {
                        $q->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()]);
                    } elseif ($req['sort_by'] == 'public') {
                        $q->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()]);
                    } elseif ($req['sort_by'] == 'private') {
                        $q->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()]);
                    } elseif ($req['sort_by'] == 'favourite') {
                        $q->whereRelation('brands', 'brand_favorites.brand_id', @auth()->user()->brands->id);
                    } else {
                        if (array_key_exists('instagram', $req) && $req['instagram'] == true) {
                            $q->select('influencers.*')
                                ->join('scrape_instagrams', 'scrape_instagrams.influe_brand_id', '=', 'influencers.id')
                                ->orderByRaw("CONVERT(scrape_instagrams." . $req['sort_by'] . ", SIGNED) " . $req['sort_type']);
                        } elseif (array_key_exists('tiktok', $req) && $req['tiktok'] == true) {
                            $q->select('influencers.*')
                                ->join('scrape_tiktoks', 'scrape_tiktoks.influe_brand_id', '=', 'influencers.id')
                                ->orderByRaw("CONVERT(scrape_tiktoks." . $req['sort_by'] . ", SIGNED) " . $req['sort_type']);
                        } elseif (array_key_exists('snapchat', $req) && $req['snapchat'] == true) {
                            $q->select('influencers.*')
                                ->join('scrape_snapchats', 'scrape_snapchats.influe_brand_id', '=', 'influencers.id')
                                ->orderByRaw("CONVERT(scrape_snapchats." . $req['sort_by'] . ", SIGNED) " . $req['sort_type']);
                        }
                    }
                }
            });
        //        dd($query->toSql());

    }

    public function scopeOfGroupFilter($query, $req)
    {
        //fixme::groupUpdates
        $first_q = '';

        $query->when(array_key_exists('groupId', $req) && $req['groupId'] != 0 && $req['del'] == 0, function ($q) use ($req) {
            $q->where('influencers_groups.group_list_id', (int) $req['groupId'])->whereNull('influencers_groups.group_deleted_at');
        })->when(array_key_exists('groupId', $req) && $req['groupId'] != 0 && $req['del'] == 1, function ($q) use ($req) {
            $q->where('influencers_groups.group_list_id', (int) $req['groupId'])->whereNotNull('influencers_groups.group_deleted_at');
        })->when(array_key_exists('country_taps', $req) && $req['country_taps'] != 0, function ($q) use ($req) {
            $q->where("influencers.country_id", $req['country_taps']);
        })->when(array_key_exists('visited_campaign', $req) && $req['visited_campaign'] == '1', function ($q) use ($req) {
            $q->whereRaw("influencers.id in (select campaign_influencers.influencer_id from  campaign_influencers  join campaigns where campaigns.id =campaign_influencers.campaign_id and campaigns.brand_id = {$req['brand_id']}  and campaign_influencers.status = 2)");
        })->when(array_key_exists('custom', $req) && $req['custom'] != null, function ($q) use ($req) {
            $q->where(function ($q2) use ($req) {
                $q2->where('name', 'like', "%" . $req['custom'] . "%")->orWhereHas('user', function ($q3) use ($req) {
                    $q3->where('users.user_name', 'like', "%" . $req['custom'] . "%");
                });
            });
        })->when(array_key_exists('visited_campaign', $req) && $req['visited_campaign'] == '0', function ($q) use ($req) {
            $q->whereRaw("influencers.id NOT in (select campaign_influencers.influencer_id from  campaign_influencers  join campaigns where campaigns.id =campaign_influencers.campaign_id and campaigns.brand_id = {$req['brand_id']} and  campaign_influencers.status = 2)");
        });
    }

    public function deprecated__scopeOfGroupFilter($query, $req)
    {
        $first_q = '';


        $query->when(array_key_exists('groupId', $req) && $req['groupId'] != 0 && $req['del'] == 0, function ($q) use ($req) {
            $q->where(function ($q2) use ($req) {
                $q2->whereJsonContains('brand_favorites.group_list_id', [['list_id' => (int) $req['groupId'], 'deleted_at' => null]]);
                $q2->orWhereJsonContains('brand_favorites.group_list_id', [['list_id' => (string) $req['groupId'], 'deleted_at' => null]]);
            });
        })->when(array_key_exists('groupId', $req) && $req['groupId'] != 0 && $req['del'] == 1, function ($q) use ($req) {
            $q->where(function ($q2) use ($req) {
                $q2->whereJsonContains('brand_favorites.group_list_id', [['list_id' => (int) $req['groupId'], 'deleted_at' => !null]]);
                $q2->orWhereJsonContains('brand_favorites.group_list_id', [['list_id' => (string) $req['groupId'], 'deleted_at' => !null]]);
            });
        })->when(array_key_exists('country_taps', $req) && $req['country_taps'] != 0, function ($q) use ($req) {
            $q->where("influencers.country_id", $req['country_taps']);
        })->when(array_key_exists('visited_campaign', $req) && $req['visited_campaign'] == '1', function ($q) use ($req) {
            $q->whereRaw("influencers.id in (select campaign_influencers.influencer_id from  campaign_influencers  join campaigns where campaigns.id =campaign_influencers.campaign_id and campaigns.brand_id = {$req['brand_id']}  and campaign_influencers.status = 2)");
        })->when(array_key_exists('custom', $req) && $req['custom'] != null, function ($q) use ($req) {
            $q->where(function ($q2) use ($req) {
                $q2->where('name', 'like', "%" . $req['custom'] . "%")->orWhereHas('user', function ($q3) use ($req) {
                    $q3->where('users.user_name', 'like', "%" . $req['custom'] . "%");
                });
            });
        })->when(array_key_exists('visited_campaign', $req) && $req['visited_campaign'] == '0', function ($q) use ($req) {
            $q->whereRaw("influencers.id NOT in (select campaign_influencers.influencer_id from  campaign_influencers  join campaigns where campaigns.id =campaign_influencers.campaign_id and campaigns.brand_id = {$req['brand_id']} and  campaign_influencers.status = 2)");
        });



        /*  if (isset($req['country_taps'])) {
            $first_q = $req['groupId'] == null || $req['country_taps'] == 0 || $req['country_taps'] == '' || (int)$req['groupId'] == 0;
        } else {
            $first_q = $req['groupId'] == null || (int)$req['groupId'] == 0;
        }
        return $query->when($first_q, function ($q) use ($req) {
            $country = '';

            if (array_key_exists('filter_country', $req) && ($req['filter_country'] != null && $req['filter_country'] != "null")) {
                $country = $req['filter_country'];
            } else {
                $country = $req['country_id'];
            }

            if (array_key_exists('country_id', $req)) {
                $q->WhereIn("country_id", array_map('intval', explode(',', $country)));
            }

            $q->with('groups')->whereHas('brands', function ($i) use ($req) {

                $i->where('brands.id', (int)$req['brand_id']);
            });
        })->when(array_key_exists('custom', $req) && $req['custom'] != null, function ($q) use ($req) {
            $q->where('name', 'like', "%" . $req['custom'] . "%");
        })->when((int)$req['groupId'] == -1, function ($q) use ($req) {
            $q->WhereIn("country_id", explode(',', $req['country_id']));
            $q->with('groups')->whereHas('brands_deleted', function ($i) use ($req) {
                $i->where('brands.id', (int)$req['brand_id']);
                // $i->whereRaw("JSON_SEARCH( `brand_favorites`.`group_list_id`, 'one','{$req['groupId']}', null, '$[*].list_id' ) IS NOT NULL And JSON_CONTAINS(`brand_favorites`.`group_list_id`, json_object('list_id','{$req['groupId']}','deleted_at',null))");
            });
        })->when($req['groupId'] != null && (int)$req['groupId'] != 0 && (int)$req['groupId'] != -1, function ($q) use ($req) {
            //            dd(array_map('intval',explode(',',$req['country_id'])));
            $country = '';

            if (array_key_exists('filter_country', $req) && ($req['filter_country'] != null && $req['filter_country'] != "null")) {
                $country = $req['filter_country'];
            } else {
                $country = $req['country_id'];
            }
            $q->whereIn('country_id', array_map('intval', explode(',', $country)));
            $q->whereHas('brands', function ($s) use ($req) {
                $s->where('brands.id', $req['brand_id']);
                $s->whereRaw("JSON_SEARCH( `brand_favorites`.`group_list_id`, 'one','{$req['groupId']}', null, '$[*].list_id' ) IS NOT NULL And JSON_CONTAINS(`brand_favorites`.`group_list_id`, json_object('list_id','{$req['groupId']}','deleted_at',null))");
                //JSON_EXTRACT(test.json_list, CONCAT('$.list[', ind.ind, ']'))
                //s->whereRaw("JSON_EXTRACT(`brand_favorites`.`group_list_id`,  CONCAT('$.deleted_at[', ind.ind, ']')");
            });
        })->when(array_key_exists('country_taps', $req) && $req['country_taps'] != null && $req['country_taps'] != 0, function ($q) use ($req) {
            //dd($req['country_taps']);
            $q->whereIn('country_id', array_map('intval', explode(',', $req['country_taps'])));
        })
            ->when(array_key_exists('name', $req) && $req['name'] != null, function ($q) use ($req) {
                $q->where('name', 'LIKE', '%' . $req['name'] . '%');
            });*/
    }


    // get influencer depend on global session country
    protected static function booted()
    {
        static::addGlobalScope('countries', function (Builder $builder) {
            if ($country = \session()->get('country')) {
                $builder->whereIn('country_id', $country);
            } elseif (\request()->hasHeader('cookieCountry') && \request()->header('cookieCountry') != -1) {
                $builder->where("country_id", \request()->header('cookieCountry'));
            } else {
                $builder;
            }
        });
    }

    public function getExpirationsDateAttribute()
    {
        return  $this->attributes['expirations_date'] ?? '..';
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_favorites', "influencer_id", 'brand_id')
            ->withPivot('date', 'deleted_at')->whereNull('brand_favorites.deleted_at');
    }

    public function brandsFavorites()
    {
        return $this->belongsToMany(Brand::class, 'influencers_groups', "influencer_id", 'brand_id')
            ->withPivot('date', 'deleted_at', 'group_list_id')->whereNull('influencers_groups.deleted_at');
    }

    public function influencerGroups()
    {
        return $this->hasMany(InfluencerGroup::class, "influencer_id");
    }

    public function influencerPivotGroups()
    {
        return $this->belongsToMany(GroupList::class, 'influencers_groups', "influencer_id", 'group_list_id')
            ->withPivot('date', 'deleted_at', 'group_deleted_at', 'group_list_id')->whereNull('influencers_groups.deleted_at')->whereNull('influencers_groups.group_deleted_at');
    }


    public function Rate()
    {
        return $this->belongsToMany(Brand::class, 'influencer_rates', "influencer_id", 'brand_id');
    }

    public function brands_deleted()
    {
        return $this->belongsToMany(Brand::class, 'brand_favorites', "influencer_id", 'brand_id')
            ->withPivot('date', 'deleted_at')->whereNotNull('brand_favorites.deleted_at');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


    public function tiktok()
    {
        return $this->hasOne('App\Models\ScrapeTiktok', 'influe_brand_id')->where('type', 1);
    }


    public function groups()
    {
        return $this->belongsToMany(GroupList::class, 'brand_favorites', 'influencer_id', 'group_list_id')->withPivot('brand_id')->withTimestamps();
    }

    public function groups_color()
    {
        return $this->hasMany(BrandFav::class, 'influencer_id', 'id')->withTrashed();
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_influencers');
    }

    public function campaignInfluencer()
    {
        return $this->hasMany(CampaignInfluencer::class, 'influencer_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function nationalityRelation()
    {
        return $this->belongsTo(Nationality::class, 'nationality', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function nationalities()
    {
        return $this->belongsTo(Nationality::class, 'nationality');
    }

    public function interests()
    {
        return  $this->belongsToJson(Interest::class, 'interest');
    }

    public function languages()
    {
        return $this->belongsToJson(Language::class, 'lang');
    }

    public function coverage_channels()
    {
        return  $this->belongsToJson(CoverageChannel::class, 'coverage_channel');
    }

    public function scopeInstaUname()
    {
        $scrapinsta =  $this->instagram()->first();
        if ($scrapinsta && $scrapinsta->insta_username != $this->insta_uname) {
            $this->instagram()->update(['insta_username' => $this->insta_uname]);
        }
        return null;
    }
    public function instagram()
    {
        return $this->hasOne(ScrapeInstagram::class, 'influe_brand_id')->where('type', 1);
    }
    public function snapchat()
    {
        return $this->hasone(ScrapeSnapchat::class, 'influe_brand_id')->where('type', 1);
    }
    public function facebook()
    {
        return $this->hasone(ScrapeFacebook::class, 'influe_brand_id')->where('type', 1);
    }
    public function twitter()
    {
        return $this->hasone(ScrapeTwitter::class, 'influe_brand_id')->where('type', 1);
    }

    public function dislikes()
    {
        return $this->hasMany(BrandDislike::class, 'influencer_id');
    }

    public function brand_favorites()
    {
        return $this->hasMany(BrandFav::class, 'influencer_id');
    }

    public function campaignBrandInfluencers()
    {
        return $this->hasMany(CampaignInfluencer::class, 'influencer_id');
    }
    // public function getAddress($lang){
    //     return @((array)json_decode($this->attributes['address']))[$lang];
    // }
    public function changeDetail()
    {
        return $this->hasOne(InfluencerChangeDetail::class, 'influencer_id');
    }
    public function getJob()
    {
        return $this->belongsTo(Job::class, 'job');
    }
    public function ChildrenInfluencer()
    {

        return $this->hasMany(InfluencerChild::class, 'influencer_id', 'id');
    }

    public function InfluencerPhones()
    {
        return $this->hasMany(InfluencerPhone::class, 'influencer_id', 'id');
    }

    public function InfluencerRate()
    {
        return $this->hasMany(InfluencerRate::class);
    }



    public function IsVIP()
    {
        return !empty($this->category_ids) && in_array('1', $this->category_ids)  ? true : false;
    }


    public function getJoinGroupsByBrandId($brand_id, $group_id = NULL)
    {
        //fixme::groupUpdates
        //$groupsData = GroupList::select('id', 'name', 'color');
        $groupsData = $this->influencerGroups()->where('brand_id', (int) $brand_id)->whereNULL('influencers_groups.group_deleted_at');
        //  if((int) $group_id){
        //      $groupsData = $groupsData->where('group_lists_id', (int) $group_id);
        //  }

        $groupsData = $groupsData->whereNotNull('group_list_id')->pluck('group_list_id')->toArray();
        $groups = GroupList::select('id', 'name', 'color')->whereIn('id', $groupsData)->get();


        $firstInfluencerGroups = $this->influencerGroups()->where('influencers_groups.deleted_at', null)->where('influencers_groups.group_deleted_at', null)->whereNotNull('group_list_id')->where('influencers_groups.brand_id', (int) $brand_id)->first();

        return ["groups" => $groups, 'main_added_date' => ($firstInfluencerGroups?$firstInfluencerGroups->created_at->format('Y-m-d H:i:s'):null), 'group_added_date' => ($firstInfluencerGroups?$firstInfluencerGroups->created_at->format('Y-m-d H:i:s'):null)];
    }

    // public function __getJoinGroupsByBrandId($brand_id, $group_id = NULL)
    // {
    //     $groupsIds = [];
    //     $groups = [];
    //     $influencerGroups = $this->groups_color()->where('brand_favorites.brand_id', $brand_id)->first();
    //     $main_added_date = ($influencerGroups) ? $influencerGroups->date : '';
    //     $group_added_date = '';
    //     if ($influencerGroups && !empty($influencerGroups->group_list_id))
    //         if ($influencerGroups->group_list_id)
    //             foreach ($influencerGroups->group_list_id as $groupVal) {
    //                 if ((int)$groupVal['list_id'] == (int)$group_id) {
    //                     $group_added_date = $groupVal['created_at'];
    //                     continue;
    //                 }
    //                 if (empty($groupVal['deleted_at']))
    //                     $groupsIds[] = $groupVal['list_id'];
    //             }
    //     if (!empty($groupsIds))
    //         $groups = GroupList::select('id', 'name', 'color')->whereIn('id', $groupsIds)->get();
    //     return ["groups" => $groups, 'main_added_date' => $main_added_date, 'group_added_date' => $group_added_date];
    // }

    public function campaignVisitedByBrandId($brand_id)
    {
        $campaignObj = Campaign::select('campaigns.id', 'campaigns.name', 'campaign_influencers.visit_or_delivery_date', 'campaign_influencers.campaign_type')->Join("campaign_influencers", 'campaigns.id', '=', 'campaign_influencers.campaign_id')
            ->where(['campaign_influencers.influencer_id' => $this->id, 'campaign_influencers.status' => 2])->where(['campaigns.brand_id' => $brand_id]);
        $campaignCount = (clone $campaignObj)->count();
        $campaign_type = '-1';
        if ((clone $campaignObj)->where(['campaigns.campaign_type' => 2])->count())
            $campaign_type = '2'; //visit and delivery
        elseif ((clone $campaignObj)->where('campaigns.campaign_type', 0)->count())
            $campaign_type = '0'; //visit
        elseif ((clone $campaignObj)->where('campaigns.campaign_type', 1)->count())
            $campaign_type = '1'; // delivery
        else
            $campaign_type = '-1';         //nothing
        return ["campaign_count" => $campaignCount, 'campaign_type' => $campaign_type];
    }

    public static function socailMediaInputs($socials)
    {
        $data = ['snapchat_uname' => '', 'twitter_uname' => '', 'facebook_uname' => '', 'tiktok_uname' => '', 'insta_uname' => ''];
        foreach ($socials as $key => $value) {
            foreach ($value as $k => $v) {
                if (isset($k) && !empty($k)) {
                    switch ($k) {
                        case 'snapchat':
                            $data['snapchat_uname'] = $v;
                            break;
                        case 'twitter':
                            $data['twitter_uname'] = $v;
                            break;
                        case 'facebook':
                            $data['facebook_uname'] = $v;
                            break;
                        case 'tiktok':
                            $data['tiktok_uname'] = $v;
                            break;
                        case 'instagram':
                            $data['insta_uname'] = $v;
                            break;
                    }
                }
            }
        }
        return $data;
    }
}
