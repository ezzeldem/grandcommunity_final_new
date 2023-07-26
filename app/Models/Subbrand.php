<?php

namespace App\Models;

use App\Http\Traits\FileAttributes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AppendsTrait;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Subbrand extends Model
{
    use HasFactory;
    use SoftDeletes,FileAttributes ,AppendsTrait, HasJsonRelationships;

    protected $imgFolder = 'photos/sub_brand';

    protected $fillable =[
        'name', 'preferred_gender', 'image', 'country_id', 'phone', 'whats_number','brand_id','status',
        'link_insta', 'link_facebook', 'link_tiktok', 'link_snapchat', 'link_twitter', 'link_website','code_whats','code_phone','created_at'
    ];

    protected $casts = [
        'status'=> 'string',
        'country_id'=>'array',
        'phone'=>'array',
    ];

    protected $appends = ['brand_name','branches_name','brand_social_media'];


    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }

    public function branches(){
        return $this->hasMany('App\Models\Branch','subbrand_id');
    }
    public function groupLists(){
        return $this->hasMany('App\Models\GroupList','sub_brand_id');
    }

    public function getBrandNameAttribute(){
        return @$this->brand->name??'not found';
    }

    public function getCreatedAtAttribute($val){
        return $val ? Carbon::parse($val)->format('Y-m-d') : '..';
    }

    public function getExpirationsDateAttribute(){
        return  $this->attributes['expirations_date'] ??'..';
    }

    public function countries()
    {
        return $this->belongsToJson(Country::class, 'country_id');
    }

    public function getPreferredGenderAttribute($val){
        return str_replace('"', '', $val);
    }

    // get sub_brands depend on global session country
    protected static function booted()
    {
        static::addGlobalScope('countries', function (Builder $builder) {
            if($country=\session()->get('country')){
                $builder->whereJsonContains('subbrands.country_id', $country);
            }elseif(\request()->hasHeader('cookieCountry') && \request()->header('cookieCountry') != -1){
                $builder->whereJsonContains('subbrands.country_id',\request()->header('cookieCountry'));
            }
        });
    }

    public function getBranchesNameAttribute(){
        return $this->branches->implode('name',',');
    }

    public function scopeOfFilter($query, $req){
        return $query->when(array_key_exists('status_val',$req)&&$req['status_val']!=null &&$req['status_val']!=-1,function ($q)use($req){
            if (gettype($req['status_val']) != "array") {
                $req['status_val'] = explode(',', $req['status_val']);
            }
            $q->whereIn('subbrands.status', $req['status_val']);

        })->when(array_key_exists('country_val',$req)&&$req['country_val']!=null,function ($q)use($req){
            if(gettype( $req['country_val'])!="array"){
                $req['country_val']=explode(',',$req['country_val']);
            }
            $q->whereJsonContains('subbrands.country_id', $req['country_val'][0]);
            for($i = 1; $i < count($req['country_val']); $i++) {
                $q->orWhereJsonContains('subbrands.country_id', $req['country_val'][$i]);
            }

        })->when(array_key_exists('brands_status',$req)&&$req['brands_status']!=null,function ($q)use($req){
            $q->where('brand_id',$req['brands_status']);

        })->when((array_key_exists('start_date',$req)&&$req['start_date']!=null),function ($q)use($req){
            $q->whereDate('subbrands.created_at','>=',Carbon::parse($req['start_date']));

        })->when((array_key_exists('end_date',$req)&&$req['end_date']!=null),function ($q)use($req){
            $q->whereDate('subbrands.created_at','<=',Carbon::parse($req['end_date']));

        })->when((array_key_exists('searchTerm',$req)&&$req['searchTerm']!=null),function ($q)use($req){
            $q->where('subbrands.name', 'LIKE', '%'.$req['searchTerm'].'%');

        })->when((array_key_exists('brand_id',$req)&&$req['brand_id']!=null),function ($q)use($req){
            $q->where('brand_id',$req['brand_id']);

        })->when((array_key_exists('group_of_brand_val',$req)&&$req['group_of_brand_val']!=null),function ($q)use($req){
            // dd($q->campaigns);

        })->when(array_key_exists('campaign_status',$req)&&$req['campaign_status']!=null,function ($q)use($req){
            if(gettype( $req['campaign_status'])!="array"){
                $req['campaign_status']=explode(',',$req['campaign_status']);
            }
            $q->whereHas('campaigns',function ($i)use($req){
                $i->whereIn('status',$req['campaign_status']);
            });
        });
    }

    public function campaigns(){
        return $this->hasMany(Campaign::class,'sub_brand_id');
    }

	public static function subBrandSocailMediaInputs($socials){
		$data=[];
        foreach ($socials as $single){
            if(isset($single['key']) && !empty($single['key'])){

                 switch ($single['key']){
                    case 'snapchat':
                        $data['link_snapchat']=$single[$single['key'].'_value'];
                        break;
                    case 'twitter':
                        $data['link_twitter']=$single[$single['key'].'_value'];
                        break;
                    case 'facebook':
                        $data['link_facebook']=$single[$single['key'].'_value'];
                        break;
                    case 'tiktok':
                        $data['link_tiktok']=$single[$single['key'].'_value'];
                        break;
					case 'instagram':
							$data['link_insta']=$single[$single['key'].'_value'];
					break;

                }
            }

        }
        return $data;
    }


    public function getBrandSocialMediaAttribute(){

       $result =Subbrand::find($this->attributes['id']);

		$social_media = [];
		if(!empty($result->link_insta)):
			$social_media[]= (object)['key'=>'instagram','instagram_value'=>$result->link_insta];
		endif;
		if(!empty($result->link_snapchat)):
			$social_media[]= (object)['key'=>'snapchat','snapchat_value'=>$result->link_snapchat];
		endif;
		if(!empty($result->link_twitter)):
			$social_media[]= (object)['key'=>'twitter','twitter_value'=>$result->link_twitter];
		endif;
		if(!empty($result->link_facebook)):
				$social_media[]= (object)['key'=>'facebook','facebook_value'=>$result->link_facebook];
			endif;
		if(!empty($result->link_tiktok)):
			$social_media[]= (object)['key'=>'tiktok','tiktok_value'=>$result->link_tiktok];
		endif;

		return  $social_media;
	}


}
