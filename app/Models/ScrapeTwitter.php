<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FileAttributes;

class ScrapeTwitter extends Model
{
    use HasFactory,FileAttributes;
    protected $imgFolder = 'photos/influencers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type', 'influe_brand_id', 'twitter_username', 'twitter_id', 'name', 'twitter_image',
        'followers', 'following', 'uploads', 'engagement_average_rate', 'bio','is_verified',
        'total_likes', 'total_comments', 'last_check_date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function influencer(){
        return $this->belongsTo(Influencer::class,'influe_brand_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(){
        return $this->belongsTo(Brand::class, 'influe_brand_id');
    }

	public function twittermedias(){
        return $this->hasMany(MediaTwitter::class,'twitter_id','id');
    }

    public function twitterlogs(){
        return $this->hasMany('App\Models\LogTwitter','twitter_id','id');
    }

	public function setTwitterImageAttribute($value){
		if (!empty($value)){
			$country_code = isset($this->influencer->country) ? $this->influencer->country->code : 'kw';
			$folder_name = $this->imgFolder.'/'.$country_code.'/twitter';
			$image_path = url('/') . '/storage/'.$folder_name.'/'. $this->insta_image;
			if(!file_exists(realpath(storage_path('app/public/'.$folder_name))))
			    \Storage::makeDirectory('app/public/'.$folder_name, 0755, true, true);

			if (file_exists($image_path))
					@unlink($image_path);

			if (!filter_var($value, FILTER_VALIDATE_URL) === false) {
				$this->attributes['twitter_image'] = self::uploadfileFromURL($value,$folder_name,$this->insta_username);
			} else {
				$values = $value->storeAs($folder_name,generateImageName($value),"public");
				$arrVal =explode('/',$values);
				$this->attributes['twitter_image']=Str::snake($arrVal[count($arrVal)-1]);
			}
		}
}


public function getTwitterImageAttribute(){
	$country_code = ($this->influencer->country) ? $this->influencer->country->code : 'kw';
	$folder_name = $this->imgFolder.'/'.$country_code.'/twitter';
	return isset($this->imgFolder) && !empty($this->attributes['twitter_image']) && file_exists(public_path('storage/'.$folder_name.'/'.$this->attributes['twitter_image']))
	   ? getImg($this->attributes['twitter_image'],$folder_name) : asset('/assets/img/avatar_logo.png');

 }

}
