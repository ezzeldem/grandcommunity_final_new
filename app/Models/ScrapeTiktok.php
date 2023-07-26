<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Http\Traits\FileAttributes;

/**
 *
 */
class ScrapeTiktok extends Model
{
    use HasFactory,FileAttributes;
    /**
     * @var string
     */
    protected $imgFolder = 'photos/influencers';
    /**
     * @var string[]
     */
    protected $fillable = [
        'type', 'influe_brand_id', 'tiktok_username', 'tiktok_id', 'name',
        'followers', 'following', 'uploads', 'engagement_average_rate', 'bio',
        'total_likes', 'last_check_date','tiktok_image','isPrivate'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function influencer(){
        return $this->belongsTo(Influencer::class, 'influe_brand_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(){
        return $this->belongsTo(Brand::class, 'influe_brand_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiktokmedias(){
        return $this->hasMany('App\Models\MediaTiktok','tiktok_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiktoklogs(){
        return $this->hasMany('App\Models\LogTiktok','tiktok_id','id');
    }

	
	public function setTiktokImageAttribute($value){
		if (!empty($value)){
			$country_code = isset($this->influencer->country) ? $this->influencer->country->code : 'kw';
			$folder_name = $this->imgFolder.'/'.$country_code.'/tiktok';
			$image_path = url('/') . '/storage/'.$folder_name.'/'. $this->tiktok_image;
			if(!file_exists(realpath(storage_path('app/public/'.$folder_name))))
			    \Storage::makeDirectory('app/public/'.$folder_name, 0755, true, true);
		   
			if (file_exists($image_path)) 
					@unlink($image_path);

			if (!filter_var($value, FILTER_VALIDATE_URL) === false) {
				$this->attributes['tiktok_image'] = self::uploadfileFromURL($value,$folder_name,$this->tiktok_username);
			} else {
				$values = $value->storeAs($folder_name,generateImageName($value),"public");
				$arrVal =explode('/',$values);
				$this->attributes['tiktok_image']=Str::snake($arrVal[count($arrVal)-1]);
			}
		}
}


		public function getTiktokImageAttribute(){
			$country_code = ($this->influencer->country) ? $this->influencer->country->code : 'kw';
			$folder_name = $this->imgFolder.'/'.$country_code.'/tiktok';
			return isset($this->imgFolder) && !empty($this->attributes['tiktok_image']) && file_exists(public_path('storage/'.$folder_name.'/'.$this->attributes['tiktok_image'])) 
			? getImg($this->attributes['tiktok_image'],$folder_name) : asset('/assets/img/avatar_logo.png');

		}

}
