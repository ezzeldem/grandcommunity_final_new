<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FileAttributes;
use Carbon\Carbon;
/**
 *
 */
class ScrapeInstagram extends Model
{
    use HasFactory,FileAttributes;
	protected $imgFolder = 'photos/influencers';
    /**
     * @var string[]
     */
    protected $fillable = [
        'type', 'influe_brand_id', 'insta_username', 'insta_id', 'name', 'insta_image',
        'followers', 'following', 'uploads', 'engagement_average_rate', 'bio','details','is_verified','is_private',
        'total_likes', 'total_comments', 'last_check_date','avg_likes','avg_comments',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instamedias(){
        return $this->hasMany(MediaInstagram::class,'instagram_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instalogs(){
        return $this->hasMany('App\Models\LogInstagram','instagram_id','id');
    }


	public function setInstaImageAttribute($value){
		if (!empty($value)){
			$country_code = isset($this->influencer->country) ? $this->influencer->country->code : 'kw';
			$folder_name = $this->imgFolder.'/'.$country_code.'/instagram';
			$image_path = url('/') . '/storage/'.$folder_name.'/'. $this->insta_image;
			if(!file_exists(realpath(storage_path('app/public/'.$folder_name))))
			    \Storage::makeDirectory('app/public/'.$folder_name, 0755, true, true);

			$old_Image = (!empty($this->insta_image)) ? substr(strrchr($this->insta_image, '/'), 1) : '' ;
				if (!empty($old_Image) && file_exists(public_path('storage/photos/influencers/'.$country_code.'/instagram/'.$old_Image)))
						 @unlink(public_path('storage/photos/influencers/'.$country_code.'/instagram/'.$old_Image));

			if (file_exists($image_path))
					@unlink($image_path);

			if (!filter_var($value, FILTER_VALIDATE_URL) === false) {
				$this->attributes['insta_image'] = self::uploadfileFromURL($value,$folder_name,$this->insta_username);
			} else {
				$values = $value->storeAs($folder_name,generateImageName($value),"public");
				$arrVal =explode('/',$values);
				$this->attributes['insta_image']=Str::snake($arrVal[count($arrVal)-1]);
			}
		}
}


public function getInstaImageAttribute(){
	$country_code = ($this->influencer->country) ? $this->influencer->country->code : 'kw';
	$folder_name = $this->imgFolder.'/'.$country_code.'/instagram';
	return isset($this->imgFolder) && !empty($this->attributes['insta_image']) && file_exists(public_path('storage/'.$folder_name.'/'.$this->attributes['insta_image']))
	   ? getImg($this->attributes['insta_image'],$folder_name) : asset('/assets/img/avatar_logo.png');

 }


}
