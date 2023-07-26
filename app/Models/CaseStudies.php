<?php

namespace App\Models;

use App\Http\Traits\FileAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Translatable\HasTranslations;

use Carbon\Carbon;
class CaseStudies extends Model
{

    protected $imgFolder = 'photos/case_studies';
    protected $fillable = ['total_followers','total_influencers','created_posts','campaign_type','campaign_name','total_days','real','image','category_id','client_profile_link','channels','total_reals'];
   


    public function category()
    {
        return $this->belongsTo(CaseStudyCategory::class, 'category_id');
    }

	public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_name');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }



    

      public static function channels(){
			$arr[]=(object)["id"=>1,"name"=>"instagram"];
			$arr[]=(object)["id"=>2,"name"=>"facebook"];
			$arr[]=(object)["id"=>3,"name"=>"twitter"];
			$arr[]=(object)["id"=>3,"name"=>"snapchat"];
			$arr[]=(object)["id"=>3,"name"=>"tiktok"];
				  return $arr;
		}

   public function getChannels($channel_ids){
        $channel_ids = json_decode($channel_ids);
		$channel_name =[];
		if(!empty($channel_ids)){
			foreach($channel_ids as $item){
				$channel =array_column(self::channels(), null, 'id')[$item] ?? false;
				$channel_name[] = ($channel) ? $channel->name : ''; 
			}
		}
		return $channel_name;
   }		



}
