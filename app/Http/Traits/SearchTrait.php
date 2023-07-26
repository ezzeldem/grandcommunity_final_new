<?php

namespace App\Http\Traits;

use App\Models\BrandFav;
use App\Models\InfluencerGroup;
use Carbon\Carbon;
use Illuminate\Support\Str;

trait SearchTrait
{


    public function scopeSeach($query, $request)
    {
        $filters = $request->only([
            'platform', 'searchWord', 'followers_min_value', 'search_country_id', 'followers_max_value', 'engagement_min_value', 'engagement_max_value', 'is_verified', 'sort_by', 'sort_by_type', 'search_input', 'gender', 'interest_ids', 'classification_ids', 'not_multi_classification', 'category_ids', 'nationality_ids', 'martial_status', 'job', 'multi_language', 'language', 'governorate_id', 'city_id', 'have_child', 'citizen_ship', 'life_style', 'min_voucher', 'account_type', 'rating', 'last_added', 'age_min_value', 'age_max_value', 'campaign_id', 'status_val', 'channels', 'created_at'
        ]);

        $channelKey =  isset($filters['platform']) && !empty($filters['platform']) ? $filters['platform'] : "instagram";
        $columnAndTableName = self::getColumnBySoicalKey($channelKey);
        $column_name = $columnAndTableName['columnName'];
        $table_name = $columnAndTableName['tableName'];
        $scrap_column_user = $columnAndTableName['scrap_column_user'];

        $query->leftjoin($table_name, $table_name . '.influe_brand_id', '=', 'influencers.id');

        $query = $query->when(array_key_exists('followers_min_value', $filters) && $filters['followers_min_value'] != NULL, function ($query) use ($table_name, $filters) {
            $query->where($table_name . ".followers", '>=', $filters['followers_min_value']);
        })
            ->when(array_key_exists('searchWord', $filters) && $filters['searchWord'], function ($query) use ($table_name, $filters) {
                $query->whereHas('user', function ($subQ) use ($filters) {
                    $subQ->where('users.user_name', 'like', '%' . $filters['searchWord'] . '%')
                    ->orWhere("influencers.name", 'like', '%' . $filters['searchWord'] . '%');
                });
            })
            ->when(array_key_exists('search_country_id', $filters) && $filters['search_country_id'], function ($query) use ($filters) {
                $query = $query->where('influencers.country_id', $filters['search_country_id']);
            })
            ->when(array_key_exists('followers_max_value', $filters) && $filters['followers_max_value'] != NULL, function ($query) use ($table_name, $filters) {
                $query->where($table_name . ".followers", '<=', $filters['followers_max_value']);
            })
            ->when(array_key_exists('custom', $filters) && $filters['custom'] != NULL, function ($query) use ($table_name, $filters) {
                $query->where($table_name . ".name", 'like', "%" . $filters['custom'] . "%");
            })

            ->when(array_key_exists('engagement_min_value', $filters) && $filters['engagement_max_value'] != NULL, function ($query) use ($table_name, $filters) {
                $query->where($table_name . ".engagement_average_rate", '>=', $filters['engagement_min_value']);
            })
            ->when(array_key_exists('engagement_max_value', $filters) && $filters['engagement_max_value'] != NULL, function ($query) use ($table_name, $filters) {
                $query->where($table_name . ".engagement_average_rate", '<=', $filters['engagement_max_value']);
            })
            ->when(array_key_exists('is_verified', $filters) && $filters['is_verified'] != NULL, function ($query) use ($table_name, $filters) {
                $query->where($table_name . ".is_verified", $filters['is_verified']);
            })
            ->when(array_key_exists('sort_by', $filters) && in_array($filters['sort_by'], ['name', "username", "followers", "social_media", "following", "uploads", "engagement_average_rate"]), function ($query) use ($table_name, $scrap_column_user, $filters) {
                if($filters['sort_by'] == "social_media"){
                    $filters['sort_by'] = "followers";
                }
                $sortBy = (isset($filters['sort_by_type']) && in_array($filters['sort_by_type'], ["desc", "asc"])) ?   $filters['sort_by_type'] : 'desc';
                if ($filters["sort_by"] == "username")
                    $query->orderBy("{$table_name}.{$scrap_column_user}", $sortBy);
                elseif ($filters["sort_by"] == "name")
                    $query->orderBy("influencers.name", $sortBy);
                else
                    $query->orderByRaw("CONVERT(" . $table_name . "." . $filters['sort_by'] . ", SIGNED) " . $sortBy);
            })
            ->when(array_key_exists('search_input', $filters) && !empty($filters['search_input'][0]), function ($query) use ($table_name, $scrap_column_user, $filters, $column_name) {
                $search_input = isset($filters['search_input']) ? $filters['search_input'] : '';
                $query->where(function ($query) use ($search_input, $table_name, $column_name, $scrap_column_user) {
                    for ($w = 0; $w < count($search_input); $w++) {
                        $query->orWhere($table_name . "." . $scrap_column_user, 'like', "%{$search_input[$w]}%")/*->orWhere($table_name . ".bio", 'like', "%{$search_input[$w]}%")*/
                            ->orWhere('influencers.name', 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.insta_uname', 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.facebook_uname', 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.tiktok_uname', 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.snapchat_uname', 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.twitter_uname', 'like', "%{$search_input[$w]}%");
                    }
                });
            })->when(array_key_exists('gender', $filters) && $filters['gender'] != NULL, function ($query) use ($filters) {
                $query = $query->where('influencers.gender', $filters['gender']);
            })
            ->when(array_key_exists('interest_ids', $filters) && $filters['interest_ids'], function ($query) use ($filters) {
                $query->where(function ($query) use ($filters) {
                    for ($i = 0; $i < count($filters['interest_ids']); $i++) {
                        $query->orWhereJsonContains('interest', "{$filters['interest_ids'][$i]}");
                    }
                });
            })->when(array_key_exists('classification_ids', $filters) && $filters['classification_ids'], function ($query) use ($filters) {
                $query->where(function ($query) use ($filters) {
                        for ($j = 0; $j < count($filters['classification_ids']); $j++) {
                            $query->orWhereJsonContains('classification_ids', "{$filters['classification_ids'][$j]}");
                        }
                });
            })->when(array_key_exists('not_multi_classification', $filters) && $filters['not_multi_classification'] != null, function ($query) use ($filters) {
                for ($j = 0; $j < count($filters['not_multi_classification']); $j++) {
                    $query->orWhereNotJsonContains('classification_ids', "{$filters['not_multi_classification'][$j]}");
                }
            })->when(array_key_exists('category_ids', $filters) && $filters['category_ids'], function ($query) use ($filters) {
                $query->where(function ($query) use ($filters) {
                    for ($j = 0; $j < count($filters['category_ids']); $j++) {
                        $query->orWhereJsonContains('category_ids', "{$filters['category_ids'][$j]}");
                    }
                });
            })->when(array_key_exists('nationality_ids', $filters) && $filters['nationality_ids'], function ($query) use ($filters) {
                $query->whereIn('nationality', $filters['nationality_ids']);
            })->when(array_key_exists('martial_status', $filters) && $filters['martial_status'], function ($query) use ($filters) {
                $query = $query->where('influencers.marital_status', $filters['martial_status']);
            })->when(array_key_exists('job', $filters) && $filters['job'], function ($query) use ($filters) {
                $query = $query->where('influencers.job', $filters['job']);
            })->when(array_key_exists('language', $filters) && $filters['language'], function ($query) use ($filters) {
                $query->WhereJsonContains("lang", "{$filters['language']}");
            })->when(array_key_exists('multi_language', $filters) && $filters['multi_language'], function ($query) use ($filters) {
                for ($n = 0; $n < count($filters['multi_language']); $n++) {
                    $query->WhereJsonContains("lang", "{$filters['multi_language'][$n]}");
                }
            })->when(array_key_exists('governorate_id', $filters) && $filters['governorate_id'], function ($query) use ($filters) {
                $query->where("state_id", $filters['governorate_id']);
            })->when(array_key_exists('city_id', $filters) && $filters['city_id'], function ($query) use ($filters) {
                $query->where("city_id", $filters['city_id']);
            })->when(array_key_exists('have_child', $filters) && $filters['have_child'] != NULL, function ($query) use ($filters) {
                ($filters['have_child'] > 0) ? $query->where("influencers.children_num", '>', 0) :  $query->where(function ($q){
                    $q->where("influencers.children_num", 0)
                        ->orWhere("influencers.children_num", "")
                        ->orWhere("influencers.children_num", null);
                });
            })->when(array_key_exists('life_style', $filters) && $filters['life_style'], function ($query) use ($filters) {
                $query->where("ethink_category", $filters['life_style']);
            })
            ->when(array_key_exists('citizen_ship', $filters) && $filters['citizen_ship'], function ($query) use ($filters) {
                $query->where("citizen_status", $filters['citizen_ship']);
            })
            ->when(array_key_exists('account_type', $filters) && $filters['account_type'], function ($query) use ($filters) {
                $query->where("account_type", $filters['account_type']);
            })->when(array_key_exists('min_voucher', $filters) && $filters['min_voucher'], function ($query) use ($filters) {
                $query->where("has_voucher", $filters['min_voucher']);
            })->when(array_key_exists('channels', $filters) && $filters['channels'], function ($query) use ($filters) {
                $query->where(function ($query) use ($filters) {
                    for ($k = 0; $k < count($filters['channels']); $k++) {
                        $columns = self::getColumnBySoicalKey($filters['channels'][$k]);
                        $query->where($columns['columnName'],'!=', '');
                    }
                });
            })->when(array_key_exists('last_added', $filters) && $filters['last_added'], function ($query) use ($filters) {
                $query->orderBy("influencers.created_at", "desc");
            })->when(array_key_exists('age_min_value', $filters) && $filters['age_min_value'], function ($query) use ($filters) {
                $query->where('date_of_birth', '>=', Carbon::now()->subYear($filters['age_min_value'])->format('Y-m-d'));
            })->when(array_key_exists('age_max_value', $filters) && $filters['age_max_value'], function ($query) use ($filters) {
                $query->where('date_of_birth', '<=', Carbon::now()->subYear($filters['age_max_value'])->format('Y-m-d'));
            })->when(array_key_exists('campaign_id', $filters) && $filters['campaign_id'] != null, function ($query) use ($filters) {
                $query->WhereDoesntHave('campaigns', function ($x) use ($filters) {
                    $x->where('campaign_id', $filters['campaign_id']);
                });
            })->when(array_key_exists('status_val', $filters) && !empty($filters['status_val']) && $filters['status_val'] != '-1', function ($query) use ($filters) {
                $query->where('active', $filters['status_val']);
            })->when(array_key_exists('created_at', $filters) && !empty($filters['created_at']), function ($query) use ($filters) {
                $query->whereDate('influencers.created_at',"{$filters['created_at']}");
            })->when(array_key_exists('platform', $filters) && $filters['platform'], function ($query) use ($filters) {
                $columns = self::getColumnBySoicalKey($filters['platform']);
                $query->where($columns['columnName'], '!=', '');
            });

    //    $sql = \Str::replaceArray('?', $query->getBindings(), $query->toSql());
    //     dd($sql);
        return $query;
    }

    public function scopeDtFilter($query, $request)
    {
        if(is_array($request)){
            $filters = $request;
        }else{
            $filters = $request->only([
                'platform', 'searchWord', 'followers_min_value', 'search_country_id', 'followers_max_value', 'engagement_min_value', 'engagement_max_value', 'is_verified', 'sort_by', 'sort_by_type', 'search_input', 'gender', 'interest_ids', 'classification_ids', 'not_multi_classification', 'category_ids', 'nationality_ids', 'martial_status', 'job_id', 'multi_language', 'language', 'governorate_id', 'city_id', 'have_child', 'citizen_ship', 'life_style', 'min_voucher', 'account_type', 'rating', 'last_added', 'age_min_value', 'age_max_value', 'campaign_id', 'status_val', 'channels', 'sorted_by', 'sorted_type'
            ]);

            session()->put('filter_datatables_values', $request->all());
        }
        $channelKey =  isset($filters['platform']) && !empty($filters['platform']) ? $filters['platform'] : "instagram";
        $columnAndTableName = self::getColumnBySoicalKey($channelKey);
        $column_name = $columnAndTableName['columnName'];
        $table_name = $columnAndTableName['tableName'];
        $scrap_column_user = $columnAndTableName['scrap_column_user'];

        $query->leftjoin($table_name, $table_name . '.influe_brand_id', '=', 'influencers.id');

        $query = $query->when(array_key_exists('followers_min_value', $filters) && $filters['followers_min_value'] != NULL, function ($query) use ($table_name, $filters) {
            $query->where($table_name . ".followers", '>=', $filters['followers_min_value']);
        })
            ->when(array_key_exists('followers_max_value', $filters) && $filters['followers_max_value'] != NULL, function ($query) use ($table_name, $filters) {
                $query->where($table_name . ".followers", '<=', $filters['followers_max_value']);
            })
            ->when(array_key_exists('is_verified', $filters) && $filters['is_verified'] != NULL, function ($query) use ($table_name, $filters) {
                $query->where($table_name . ".is_verified", $filters['is_verified']);
            })
            ->when(array_key_exists('engagement_min_value', $filters) && $filters['engagement_min_value'] != NULL, function ($query) use ($table_name, $filters) {
                $query->where($table_name . ".engagement_average_rate", '>=', $filters['engagement_min_value']);
            })
            ->when(array_key_exists('engagement_max_value', $filters) && $filters['engagement_max_value'] != NULL, function ($query) use ($table_name, $filters) {
                $query->where($table_name . ".engagement_average_rate", '<=', $filters['engagement_max_value']);
            })
            ->when(array_key_exists('searchWord', $filters) && $filters['searchWord'], function ($query) use ($table_name, $filters) {
                $query->whereHas('user', function ($subQ) use ($filters) {
                    $subQ->where('users.user_name', 'like', '%' . $filters['searchWord'] . '%')
                    ->orWhere("influencers.name", 'like', '%' . $filters['searchWord'] . '%');
                });
            })
            ->when(array_key_exists('search_country_id', $filters) && $filters['search_country_id'], function ($query) use ($filters) {
                $query = $query->where('influencers.country_id', $filters['search_country_id']);
            })
            ->when(array_key_exists('custom', $filters) && $filters['custom'] != NULL, function ($query) use ($table_name, $filters) {
                $query->where($table_name . ".name", 'like', "%" . $filters['custom'] . "%");
            })
            ->when(array_key_exists('sort_by', $filters) && in_array($filters['sort_by'], ["username", "followers", "following", "uploads", "engagement_average_rate"]), function ($query) use ($table_name, $scrap_column_user, $filters) {
                $sortBy = (isset($filters['sort_by_type']) && in_array($filters['sort_by_type'], ["desc", "asc"])) ?   $filters['sort_by_type'] : 'desc';
                if ($filters["sort_by"] == "username")
                    $query->orderBy("{$table_name}.{$scrap_column_user}", $sortBy);
                elseif ($filters["sort_by"] == "name")
                    $query->orderBy("influencers.name", $sortBy);
                else
                    $query->orderByRaw("CONVERT(" . $table_name . "." . $filters['sort_by'] . ", SIGNED) " . $sortBy);
            })
            ->when(array_key_exists('search_input', $filters) && $filters['search_input'], function ($query) use ($table_name, $scrap_column_user, $filters, $column_name) {
                $search_input = isset($filters['search_input']) ? $filters['search_input'] : '';
                $query->where(function ($query) use ($search_input, $table_name, $column_name, $scrap_column_user) {
                    for ($w = 0; $w < count($search_input); $w++) {
                        $query->orWhere($table_name . "." . $scrap_column_user, 'like', "%{$search_input[$w]}%")->orWhere($table_name . ".bio", 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.name', 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.insta_uname', 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.facebook_uname', 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.tiktok_uname', 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.snapchat_uname', 'like', "%{$search_input[$w]}%")
                            ->orWhere('influencers.twitter_uname', 'like', "%{$search_input[$w]}%");
                    }
                });
            })->when(array_key_exists('gender', $filters) && $filters['gender'] != NULL, function ($query) use ($filters) {
                $query = $query->where('influencers.gender', $filters['gender']);
            })
            ->when(array_key_exists('interest_ids', $filters) && $filters['interest_ids'], function ($query) use ($filters) {
                $query->whereRaw('json_valid(interest)')->where(function ($query) use ($filters) {
                    for ($i = 0; $i < count($filters['interest_ids']); $i++) {
                        $query->orWhereJsonContains('interest', "{$filters['interest_ids'][$i]}");
                    }
                });
            })->when(array_key_exists('classification_ids', $filters) && $filters['classification_ids'], function ($query) use ($filters) {
                $query->whereRaw('json_valid(classification_ids)')->where(function ($query) use ($filters) {
                    for ($j = 0; $j < count($filters['classification_ids']); $j++) {
                        $query->orWhereJsonContains('classification_ids', (int) $filters['classification_ids'][$j]);
                        $query->orWhereJsonContains('classification_ids', "{$filters['classification_ids'][$j]}");
                        // $query->orWhereRaw('FIND_IN_SET("' . $filters['classification_ids'][$j] . '",classification_ids)');
                    }
                });
            })->when(array_key_exists('not_multi_classification', $filters) && $filters['not_multi_classification'] != null, function ($query) use ($filters) {
                $query->where(function ($q) use ($filters) {
                    $q->whereNull('classification_ids')->orWhereRaw('json_valid(classification_ids)')->where(function ($q) use ($filters) {
                        for ($i = 0; $i < count($filters['not_multi_classification']); $i++) {
                            $q->orWhereJsonDoesntContain('classification_ids', (int) $filters['not_multi_classification'][$i]);
                            $q->orWhereJsonDoesntContain('classification_ids', "{$filters['not_multi_classification'][$i]}");
                        }
                    });
                });

            })->when(array_key_exists('category_ids', $filters) && $filters['category_ids'], function ($query) use ($filters) {
                $query->whereRaw('json_valid(category_ids)')->where(function ($query) use ($filters) {
                    for ($j = 0; $j < count($filters['category_ids']); $j++) {
                        $query->orWhereJsonContains('category_ids', "{$filters['category_ids'][$j]}");
                    }
                });
            })->when(array_key_exists('nationality_ids', $filters) && $filters['nationality_ids'], function ($query) use ($filters) {
                $query->whereIn('nationality', $filters['nationality_ids']);
            })->when(array_key_exists('martial_status', $filters) && $filters['martial_status'], function ($query) use ($filters) {
                $query = $query->where('influencers.marital_status', $filters['martial_status']);
            })->when(array_key_exists('job_id', $filters) && $filters['job_id'], function ($query) use ($filters) {
                $query = $query->where('influencers.job', $filters['job_id']);
            })->when(array_key_exists('language', $filters) && $filters['language'], function ($query) use ($filters) {
                $query->whereJsonContains("lang", "{$filters['language']}");
            })->when(array_key_exists('multi_language', $filters) && $filters['multi_language'], function ($query) use ($filters) {
                $query->whereRaw('json_valid(lang)')->where(function ($query) use ($filters) {
                    for ($n = 0; $n < count($filters['multi_language']); $n++) {
                        $query->orWhereJsonContains("lang", "{$filters['multi_language'][$n]}");
                    }
                });
            })->when(array_key_exists('governorate_id', $filters) && $filters['governorate_id'], function ($query) use ($filters) {
                $query->where("state_id", $filters['governorate_id']);
            })->when(array_key_exists('city_id', $filters) && $filters['city_id'], function ($query) use ($filters) {
                $query->where("city_id", $filters['city_id']);
            })->when(array_key_exists('have_child', $filters) && $filters['have_child'] != NULL, function ($query) use ($filters) {
                ($filters['have_child'] > 0) ? $query->where("influencers.children_num", '>', 0) :  $query->where(function ($q){
                    $q->where("influencers.children_num", 0)
                        ->orWhere("influencers.children_num", "")
                        ->orWhere("influencers.children_num", null);
                });
            })->when(array_key_exists('life_style', $filters) && $filters['life_style'], function ($query) use ($filters) {
                $query->where("ethink_category", $filters['life_style']);
            })

            ->when(array_key_exists('citizen_ship', $filters) && $filters['citizen_ship'], function ($query) use ($filters) {
                $query->where("citizen_status", $filters['citizen_ship']);
            })

            ->when(array_key_exists('account_type', $filters) && $filters['account_type'], function ($query) use ($filters) {
                $query->where("account_type", $filters['account_type']);
            })->when(array_key_exists('min_voucher', $filters) && !is_null($filters['min_voucher']), function ($query) use ($filters) {
                if($filters['min_voucher'] > 0){
                    $query->where("has_voucher", 1);
                }else{
                    $query->where(function ($q){
                        $q->where("has_voucher", 0)->orWhere("has_voucher", null);
                    });
                }
            })->when(array_key_exists('channels', $filters) && $filters['channels'], function ($query) use ($filters) {
                $query->where(function ($query) use ($filters) {
                    for ($k = 0; $k < count($filters['channels']); $k++) {
                        $columns = self::getColumnBySoicalKey($filters['channels'][$k]);
                        $query->where($columns['columnName'],'!=', '');
                    }
                });
            })->when(array_key_exists('last_added', $filters) && $filters['last_added'], function ($query) use ($filters) {
                $query->orderBy("influencers.created_at", "desc");
            })->when(array_key_exists('age_min_value', $filters) && $filters['age_min_value'], function ($query) use ($filters) {
                $query->where('date_of_birth', '>=', Carbon::now()->subYear($filters['age_min_value'])->format('Y-m-d'));
            })->when(array_key_exists('age_max_value', $filters) && $filters['age_max_value'], function ($query) use ($filters) {
                $query->where('date_of_birth', '<=', Carbon::now()->subYear($filters['age_max_value'])->format('Y-m-d'));
            })->when(array_key_exists('campaign_id', $filters) && $filters['campaign_id'] != null, function ($query) use ($filters) {
                $query->WhereDoesntHave('campaigns', function ($x) use ($filters) {
                    $x->where('campaign_id', $filters['campaign_id']);
                });
            })->when(array_key_exists('status_val', $filters) && !is_null($filters['status_val']) && $filters['status_val'] != '-1', function ($query) use ($filters) {
                $query->where('active', $filters['status_val']);
            })->when(array_key_exists('platform', $filters) && $filters['platform'], function ($query) use ($filters) {
                $columns = self::getColumnBySoicalKey($filters['platform']);
                $query->where($columns['columnName'], '!=', '');
            });

        $orderBy = $filters['sorted_by']??"id";
        $orderType = $filters['sorted_type']??"desc";

        switch ($orderBy){
            case "name":
                $query->orderBy('influencers.name', $orderType);
                break;
            case "created_at":
                $query->orderBy('influencers.created_at', $orderType);
                break;
            case "user_name":
                $query = $query->orderBy('users.user_name', $orderType);
                break;
            default:
                $query->orderBy('influencers.id', "desc");
        }

        // $sql = \Str::replaceArray('?', $query->getBindings(), $query->toSql());
        //  dd($sql);
        return $query;
    }

    public function scopeBrandFilter($query, $request)
    {
        $request = $request->all();
        $query->where(function ($query) use ($request) {
            if (isset($request['dislike']) && $request['dislike'])
                $query->whereraw('influencers.id in (select influencer_id from `brand_dislikes` where `brand_id` = '.@auth()->user()->brands->id.')');
            elseif(!isset($request['dislike']) && !isset($request['search_by']))
                $query->whereraw('influencers.id not in (select influencer_id from `brand_dislikes` where `brand_id` = '.@auth()->user()->brands->id.')');
        })->when(array_key_exists('favorite', $request) && $request['favorite'] != null, function ($query) use ($request) {
            $brand_id =@auth()->user()->brands->id;

                $requestFav = is_array($request['favorite']) ? $request['favorite'] : [$request['favorite']];
                $brandFavouritesIds = InfluencerGroup::where('brand_id', $brand_id)->where('deleted_at', null)
                    ->where(function ($q) use ($requestFav) {
                        if(!in_array(-1, $requestFav)) {
                            $q->where(function ($q2) use ($requestFav) {
                        foreach ($requestFav as $group_id) {
                            $q2->orWhere(function ($q3) use ($group_id) {
                                $q3->where('group_deleted_at', null)->where('group_list_id', (int)$group_id);
                            });
                        }
                            });
                       }
                    })
                    ->pluck('influencer_id')->toArray();
                    $query->leftJoin('influencers_groups', function($join) use ($brand_id) {
                        $join->on('influencers_groups.influencer_id', '=', 'influencers.id')
                            ->where('influencers_groups.brand_id', $brand_id)
                            ->whereNull('influencers_groups.deleted_at');
                    })
                    ->whereIn('influencers.id', $brandFavouritesIds)
                    ->orderBy('influencers_groups.created_at', 'desc');

        })->when(array_key_exists('unfavorite', $request) && $request['unfavorite'] != null, function ($query) use ($request) {
            $query->WhereDoesntHave('brands', function ($x) {
                $x->where('brands.id', @auth()->user()->brands->id);
            });
        })->when(array_key_exists('rating', $request) && $request['rating'], function ($query) use ($request) {
            $query->WhereHas('Rate', function ($x) use ($request) {
                $x->where('brands.id', @auth()->user()->brands->id)->where('influencer_rates.rate', $request['rating']);
            });
        })->when(array_key_exists('visited_campaigns', $request) && !empty($request['visited_campaigns']), function ($query) use ($request) {
            if($request['visited_campaigns'] == 1)
                $query->whereRaw('influencers.id in (select campaign_influencers.influencer_id from campaign_influencers join campaigns on campaigns.id = campaign_influencers.campaign_id and campaign_influencers.status = 2 and campaign_influencers.brand_id = '.@auth()->user()->brands->id.') ');
            else
                $query->whereRaw('influencers.id NOT in (select campaign_influencers.influencer_id from campaign_influencers join campaigns on campaigns.id = campaign_influencers.campaign_id and campaign_influencers.status = 2 and campaign_influencers.brand_id = '.@auth()->user()->brands->id.') ');

        });
    }

    public function scopeNewBrandFavFilter($query, $request)
    { //fixme:updates
        $request = $request->all();
        $brand_id =@auth()->user()->brands->id;
        $query->where(function ($query) use ($brand_id, $request) {
            if (isset($request['dislike']) && $request['dislike'])
                $query->whereraw('influencers.id in (select influencer_id from `brand_dislikes` where `brand_id` = '.$brand_id.')');
            elseif(!isset($request['dislike']) && !isset($request['search_by']))
                $query->whereraw('influencers.id not in (select influencer_id from `brand_dislikes` where `brand_id` = '.$brand_id.')');
        })->when(array_key_exists('favorite', $request) && $request['favorite'] != null , function ($query) use ($brand_id, $request) {
            $requestFav = is_array($request['favorite']) ? $request['favorite'] : [$request['favorite']];
            $query->Join('influencers_groups', function($join) use ($requestFav, $brand_id) {
                $join->on('influencers_groups.influencer_id', '=', 'influencers.id')
                    ->where('influencers_groups.brand_id', $brand_id)
                    ->whereNull('influencers_groups.deleted_at');
                    if(in_array(-2, $requestFav)){
                        $join->where('influencers_groups.brand_id', $brand_id)->where('influencers_groups.deleted_at', null)->whereNull('influencers_groups.group_list_id');
                        $join->whereraw('influencers.id not in (select influencer_id from `influencers_groups` where `brand_id` = '.$brand_id.' AND `group_list_id` IS NOT NULL AND `group_deleted_at` IS NULL AND `deleted_at` IS NULL)');
                    }else{
                        if(!in_array(-1, $requestFav)) {
                            $join->whereIn('influencers_groups.group_list_id', $requestFav)->where('influencers_groups.group_deleted_at', null);
                        }
                    }
            });

            $query->addSelect('influencers_groups.created_at as influencers_groups_created_at');


            $updateSortBy = (isset($request['sort_by']) && $request['sort_by'])?$request['sort_by']:"added_date";
            $updateSortByType = (isset($request['sort_by_type']) && $request['sort_by_type'])?$request['sort_by_type']:"DESC";
            if($updateSortBy == "added_date")
            {
                $query
                ->orderBy('influencers_groups.id', $updateSortByType)
                ->orderBy('influencers_groups.created_at', $updateSortByType);
            }
        })->when(array_key_exists('unfavorite', $request) && $request['unfavorite'] != null, function ($query) use ($brand_id, $request) {
            $query->WhereDoesntHave('influencerGroups', function ($x) use ($brand_id) {
                $x->whereNull('influencers_groups.deleted_at');
                $x->where('influencers_groups.brand_id',$brand_id);
            });
            $query->whereraw('influencers.id not in (select influencer_id from `brand_dislikes` where `brand_id` = '.$brand_id.')');
        })->when(array_key_exists('rating', $request) && $request['rating'], function ($query) use ($brand_id, $request) {
            $query->WhereHas('Rate', function ($x) use ($brand_id, $request) {
                $x->where('brands.id', $brand_id)->where('influencer_rates.rate', $request['rating']);
            });
        })->when(array_key_exists('visited_campaigns', $request) && !empty($request['visited_campaigns']), function ($query) use ($request) {
            if($request['visited_campaigns'] == 1)
                $query->whereRaw('influencers.id in (select campaign_influencers.influencer_id from campaign_influencers join campaigns on campaigns.id = campaign_influencers.campaign_id and campaign_influencers.status = 2 and campaign_influencers.brand_id = '.@auth()->user()->brands->id.') ');
            else
                $query->whereRaw('influencers.id NOT in (select campaign_influencers.influencer_id from campaign_influencers join campaigns on campaigns.id = campaign_influencers.campaign_id and campaign_influencers.status = 2 and campaign_influencers.brand_id = '.@auth()->user()->brands->id.') ');

        });
    }

    protected static function getColumnBySoicalKey($key)
    {
        $columnName = "insta_uname";
        switch ($key) {
            case 'instagram':
                $columnName = "insta_uname";
                $tableName = "scrape_instagrams";
                $scrap_column_user = "insta_username";
                break;
            case "snapchat":
                $columnName = "snapchat_uname";
                $tableName = "scrape_snapchats";
                $scrap_column_user = "snap_username";
                break;
            case "facebook":
                $columnName = "facebook_uname";
                $tableName = "scrape_facebooks";
                $scrap_column_user = "face_username";
                break;
            case "twitter":
                $columnName = "twitter_uname";
                $tableName = "scrape_twitters";
                $scrap_column_user = "tiktok_username";
                break;
            case "tiktok":
                $columnName = "tiktok_uname";
                $tableName = "scrape_tiktoks";
                $scrap_column_user = "tiktok_username";
                break;
        }
        return ["columnName" => $columnName, "tableName" => $tableName, "scrap_column_user" => $scrap_column_user];
    }

    public function SocialMedia()
    {

        $social_media = [];
        if (!empty($this->attributes['insta_uname'])) :
            $followers = $this->instagram ? (float)$this->instagram->followers  : 0;
            $verified = $this->instagram && $this->instagram->is_verified == 1 ? true  : false;
            $engagement_average_rate = $this->instagram ? nr($this->instagram->engagement_average_rate, 2) : 0;
            $social_media[] = (object)['icon' => 'instagram', 'verified' => $verified, 'followers' => $followers, 'engagement_average_rate' => $engagement_average_rate, 'user_name' => $this->attributes['insta_uname'], 'base_url' => 'https://www.instagram.com/' . $this->attributes['insta_uname']];
        endif;
        if (!empty($this->attributes['snapchat_uname'])) :
            $followers = $this->snapchat ? (float)$this->snapchat->followers  : 0;
            $verified = $this->snapchat && $this->snapchat->is_verified == 1 ? true  : false;
            $engagement_average_rate = $this->snapchat ? nr($this->snapchat->engagement_average_rate, 2) : 0;
            $social_media[] = (object)['icon' => 'snapchat', 'verified' => $verified, 'followers' => $followers, 'engagement_average_rate' => $engagement_average_rate, 'user_name' => $this->attributes['snapchat_uname'], 'base_url' => 'https://www.snapchat.com/add/' . $this->attributes['snapchat_uname']];
        endif;
        if (!empty($this->attributes['twitter_uname'])) :
            $followers = $this->twitter ? (float)$this->twitter->followers  : 0;
            $verified = $this->twitter && $this->twitter->is_verified == 1 ? true  : false;
            $engagement_average_rate = $this->twitter ? nr($this->twitter->engagement_average_rate, 2) : 0;
            $social_media[] = (object)['icon' => 'twitter', 'verified' => $verified, 'followers' => $followers, 'engagement_average_rate' => $engagement_average_rate, 'user_name' => $this->attributes['twitter_uname'], 'base_url' => 'https://www.twitter.com/' . $this->attributes['twitter_uname']];
        endif;
        if (!empty($this->attributes['facebook_uname'])) :
            $followers = $this->facebook ? (float)$this->facebook->followers  : 0;
            $verified = $this->facebook && $this->facebook->is_verified == 1 ? true  : false;
            $engagement_average_rate = $this->facebook ? nr($this->facebook->engagement_average_rate, 2) : 0;
            $social_media[] = (object)['icon' => 'facebook', 'verified' => $verified, 'followers' => $followers, 'engagement_average_rate' => $engagement_average_rate, 'user_name' => $this->attributes['facebook_uname'], 'base_url' => 'https://www.facebook.com/' . $this->attributes['facebook_uname']];
        endif;
        if (!empty($this->attributes['tiktok_uname'])) :
            $followers = $this->tiktok ? (float)$this->tiktok->followers  : 0;
            $verified = $this->tiktok && $this->tiktok->is_verified == 1 ? true  : false;
            $engagement_average_rate = $this->tiktok ? nr($this->tiktok->engagement_average_rate, 2) : 0;
            $social_media[] = (object)['icon' => 'tiktok', 'verified' => $verified, 'followers' => $followers, 'engagement_average_rate' => $engagement_average_rate, 'user_name' => $this->attributes['tiktok_uname'], 'base_url' => 'https://www.tiktok.com/@' . $this->attributes['tiktok_uname']];
        endif;

        return  $social_media;
    }
}
