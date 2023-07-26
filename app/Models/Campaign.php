<?php

namespace App\Models;

use App\Http\Traits\AppendsTrait;
use App\Http\Traits\FileAttributes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory;
    use SoftDeletes, AppendsTrait, FileAttributes;

    protected $fillable = [
        "name", "gender", "has_guest", "brand_id", "country_id", "sub_brand_id", "min_story",
        "influencers_price", "total_price", "company_msg", "influencer_per_day",
        "influencers_script", "status", "visit_start_date",
        "visit_end_date", "deliver_start_date", "deliver_end_date", 'delivery_to', 'delivery_from', 'visit_to', 'visit_from', 'delivery_coverage', 'visit_coverage', 'confirmation_link',
        'note', 'brief', 'invitation', 'visit_to', 'visit_from', 'delivery_to', 'delivery_from',
        'campaign_type', 'guest_numbers', "has_voucher", 'count_of_delivery', 'count_of_visit', 'camp_id', 'step', 'camp_brief', 'camp_note',
        'list_ids', 'target', 'daily_influencer', 'daily_confirmation', 'camp_invetation', 'objective_id', 'campaign_check_list', 'folderId', 'reason', 'request_to_cancle', 'branch_ids', 'attached_files', 'compliment_type',
    ];
    protected $imgFolder = 'photos/campaign';

    protected $casts = [
        // 'social_channels' => 'array',
        'camp_brief' => 'array',
        'list_ids' => 'array',
        'camp_note' => 'array',
        'camp_invetation' => 'array',
        'voucher_list' => 'array',
        'campaign_check_list' => 'array',
        'branch_ids' => 'array',
        'attached_files' => 'array',
        'report_pdf' => 'string',
    ];

    protected $appends = ['country_id', 'city_id', 'branch_ids', 'voucher_list'];

    public function createCampId()
    {
        return self::generateRandomCode();
    }

    public static function generateRandomCode()
    {
        $number_char = '0123456789';
        $length = 7;
        $number_shuffled = substr(str_shuffle(str_repeat($number_char, ceil($length / strlen($number_char)))), 1, $length);
        $shuffled = $number_shuffled;
        $checkIfExist = Campaign::where('camp_id', $number_shuffled)->count();
        if ($checkIfExist > 0) {
            $shuffled = Self::generateRandomCode();
        }

        return $shuffled;
    }

    protected static function booted()
    {
        parent::boot();
        static::creating(function($model)
        {
			if($model)
		        dispatch(new \App\Jobs\CampaignTransfer(["campaign_id"=>$model->id,"action_type"=>"create"]));
        });

       static::updating(function($model)
        {
		 if($model)
		    dispatch(new \App\Jobs\CampaignTransfer(["campaign_id"=>$model->id,"action_type"=>"update"]));
        });
        static::deleting(function($model)
        {
		       dispatch(new \App\Jobs\CampaignTransfer(["campaign_id"=>$model->id,"action_type"=>"delete"]));
        });

            // static::addGlobalScope('countries', function (Builder $builder) {
            //     if($country=\session()->get('country')){
            //         $builder->whereHas('campaignCountries',function ($q)use($country){
            //             $q->whereIn('country_id',array_map('intval', $country));
            //         });
            //     }else{
            //         $builder;
            //     }
            // });
        }

    public function scopeFilter($query, $req)
    {
        return $query->when((array_key_exists('status_val', $req) && $req['status_val'] != null), function ($q) use ($req) {
            if (gettype($req['status_val']) != "array") {
                $req['status_val'] = explode(',', $req['status_val']);
            }
            $q->whereIn('status', $req['status_val']);
        })->when(array_key_exists('status_type', $req) && $req['status_type'] != null, function ($q) use ($req) {
            $q->where('status', $req['status_type']);
        })->when(array_key_exists('search_name', $req) && $req['search_name'] != null, function ($q) use ($req) {
            $q->where('name', 'LIKE', '%' . $req['search_name'] . '%');
        })->when(array_key_exists('sort', $req) && $req['sort'] != null, function ($q) use ($req) {
            if ($req['sort'] == 1) {
                $q->orderBy('target', 'desc');
            } else {
                $q->orderBy('target', 'asc');
            }

        })->when(array_key_exists('country_val', $req) && $req['country_val'] != null, function ($q) use ($req) {
            if (gettype($req['country_val']) != "array") {
                $req['country_val'] = explode(',', $req['country_val']);
            }
            $q->whereHas('campaignCountries', function ($q) use ($req) {
                $q->whereIn('country_id', array_map('intval', $req['country_val']));
            });
        })->when(array_key_exists('campaign_type_val', $req) && $req['campaign_type_val'] != null && $req['campaign_type_val'] != -1, function ($q) use ($req) {
            if (gettype($req['campaign_type_val']) != "array") {
                $req['campaign_type_val'] = explode(',', $req['campaign_type_val']);
            }
            $q->whereIn('campaign_type', $req['campaign_type_val']);
        })->when((array_key_exists('start_date', $req) && $req['start_date'] != null) && (array_key_exists('end_date', $req) && $req['end_date'] != null && strtotime($req['start_date']) == true && strtotime($req['end_date'])), function ($q) use ($req) {
            $q->where(function ($i) use ($req) {
                $i->where(function ($query) use ($req) {
                    $query->whereDate('deliver_start_date', '>=', Carbon::parse($req['start_date']))
                        ->whereDate('deliver_end_date', '<=', Carbon::parse($req['end_date']));
                })->orWhere(function ($query) use ($req) {
                    $query->whereDate('visit_start_date', '>=', Carbon::parse($req['start_date']))
                        ->whereDate('visit_end_date', '<=', Carbon::parse($req['end_date']));
                });
            });
        })->when((array_key_exists('start_date', $req) && strtotime($req['start_date']) == true), function ($q) use ($req) {
            $q->where(function ($i) use ($req) {
                $i->WhereDate('deliver_start_date', '>=', Carbon::parse($req['start_date']))
                    ->orWhereDate('visit_start_date', '>=', Carbon::parse($req['start_date']));
            });
        })->when((array_key_exists('end_date', $req) && strtotime($req['end_date']) == true), function ($q) use ($req) {
            $q->where(function ($i) use ($req) {
                $i->WhereDate('deliver_end_date', '<=', Carbon::parse($req['end_date']))
                    ->orWhereDate('visit_end_date', '<=', Carbon::parse($req['end_date']));
            });
        })->when((array_key_exists('max', $req) && $req['max'] != null), function ($q) use ($req) {
            $q->where('target', '<=', $req['max']);
        })->when((array_key_exists('min', $req) && $req['min'] != null), function ($q) use ($req) {
            $q->where('target', '>=', $req['min']);
        })->when((array_key_exists('min', $req) && $req['min'] != null) && (array_key_exists('max', $req) && $req['max'] != null), function ($q) use ($req) {
            $q->whereBetween('target', [$req['min'], $req['max']]);
        })->when((array_key_exists('status', $req) && $req['status'] != null), function ($q) use ($req) {
            $q->where('status', $req['status']);
        });

        // $sql = \Str::replaceArray('?', $query->getBindings(), $query->toSql());
        // dd($sql);
    }

    public function scopeOfFilterCamp($query, $req)
    {
        return $query->when(isset($req['status_val']) && !is_null($req['status_val']), function ($q) use ($req) {
            $q->where('status', $req['status_val']);
        })->when(isset($req['country_val']) && !is_null($req['country_val']), function ($q) use ($req) {
            $q->whereHas('campaignCountries', function ($q) use ($req) {
                $q->whereIn('country_id', array_map('intval', $req['country_val']));
            });
        })->when((isset($req['start_date']) && $req['start_date'] != null) && (!is_null($req['end_date'])), function ($q) use ($req) {
                $q->whereBetween('created_at', [$req['start_date'], $req['end_date']]);
        })->when((isset($req['searchTerm']) && !is_null($req['searchTerm'])), function ($q) use ($req) {
            $q->where('name', 'LIKE', '%' . $req['searchTerm'] . '%');
        })->when((isset($req['campaign_type_val']) && !is_null($req['campaign_type_val'])), function ($q) use ($req) {
            $q->where('campaign_type', $req['campaign_type_val']);
        });
    }

    public function campaignCountries()
    {
        return $this->hasMany(CampaignCountryFavourite::class, 'campaign_id', 'id');
    }

    public function getVoucherListAttribute()
    {
        return $this->campaign_branches()->where('has_compliment', 1)->pluck('branche_id')->toArray();
    }

    public function getComplimentsBranchesListAttribute()
    {
        return $this->campaign_branches()->where('has_compliment', 1)->pluck('branche_id')->toArray();
    }

    public function getCountryIdAttribute()
    {
        return $this->campaignCountries->pluck('country_id')->toArray();
    }

    public function getCityIdAttribute()
    {
        return $this->campaignCountries->pluck('city_id')->toArray();
    }

    // public function getListIdsAttribute()
    // {
    //     return $this->campaignCountries->pluck('list_id')->toArray();
    // }

    public function getBranchIdsAttribute()
    {
        return $this->campaign_branches->pluck('branche_id')->toArray();
    }

    public function campaign_branches()
    {
        return $this->hasMany(BrancheCampaign::class, 'campaign_id');
    }

    public function campaignInfluencers()
    {
        return $this->hasMany(CampaignInfluencer::class, 'campaign_id');
    }

    public function campaignVisitInfluencers()
    {
        return $this->hasManyThrough(CampaignInfluencerVisit::class, CampaignInfluencer::class);
    }

    public function campCountryFavourite()
    {
        return $this->hasMany(CampaignCountryFavourite::class, 'campaign_id');
    }

    public function campLogs()
    {
        return $this->hasMany(LogCamp::class, 'campaign_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function subBrand()
    {
        return $this->belongsTo(Subbrand::class, 'sub_brand_id');
    }

    public function getStatus()
    {
        return $this->belongsTo(Status::class, 'status', 'value')->where('type', 'campaign');
    }

    public function getType()
    {
        if ($this->attributes['campaign_type'] == 2) {
            return __('api.mix');
        } elseif ($this->attributes['campaign_type'] == 1) {
            return __('api.delivery');
        } elseif ($this->attributes['campaign_type'] == 3) {
            return __('api.share');
        } elseif ($this->attributes['campaign_type'] == 4) {
            return __('api.post_creation');
        } elseif ($this->attributes['campaign_type'] === null) {
            return null;
        } else {
            return __('api.visit');
        }
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branche_campaigns', 'campaign_id', 'branche_id', 'id', 'id')->withPivot('brand_id', 'has_compliment');
    }

    public function secrets()
    {
        return $this->hasManyThrough(CampaignSecret::class, CampaignCountryFavourite::class, 'campaign_id', 'campaign_country_id');
    }

    public function scopeOfCampaginStatus()
    {
        $status = Status::where('id', $this->status)->first();
        if ($status) {
            return ["id" => $status->id, "name" => $status->name, "value" => $status->value];
        } else {
            return [];
        }
    }

    // public function coverageChannel()
    // {
    //     return $this->hasMany(CampaignCoverageChannel::class);
    // }

    // public function getChannelIdAttribute()
    // {
    //     return $this->coverageChannel
    //         ->pluck('channel_id')
    //         ->toArray();
    // }

    // public function getCampaignTypeChannelAttribute()
    // {
    //     return $this->coverageChannel->pluck('campaign_type')->toArray();
    // }

    public function influencer_complain()
    {
        return $this->hasMany(InfluencerComplain::class, 'campaign_id');
    }

    public function compliment()
    {
        return $this->hasOne(ComplimentCampaign::class);
    }

    public function getAttachedFilesAttribute($value)
    {
        $attachedFiles = $value ? json_decode($value, true) : [];
        if (is_array($attachedFiles) && count($attachedFiles) > 0) {
            foreach ($attachedFiles as &$file) {
                $fileName = $file['name'];
                $file['url'] = url('photos/campaign/' . $fileName);
                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'tiff', 'webp'])) {
                    $file['type'] = 'image';
                } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm'])) {
                    $file['type'] = 'video';
                } else {
                    $file['type'] = null;
                }
            }
            return $attachedFiles;
        }
    }

    public function getReportPdfAttribute($value)
    {
        if ($value) {
            return url('uploads/pdfs/' . $value);
        }
    }

}
