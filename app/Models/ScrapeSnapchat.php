<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FileAttributes;
use Carbon\Carbon;
/**
 *
 */
class ScrapeSnapchat extends Model
{
    use HasFactory,FileAttributes;
	protected $imgFolder = 'photos/influencers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type', 'influe_brand_id', 'snap_username', 'name', 'snap_image',
        'followers', 'uploads', 'engagement_average_rate', 'bio',
        'total_view', 'total_share', 'last_check_date',
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
    public function snapmedias(){
        return $this->hasMany(MediaSnapchat::class,'snapchat_id','id');
    }


    public function snaplogs(){
        return $this->hasMany('App\Models\LogSnapchat','snapchat_id','id');
    }


	 public function setSnapImageAttribute($value){
			if (!empty($value)){
				$country_code = isset($this->influencer->country) ? $this->influencer->country->code : 'kw';
				$folder_name = $this->imgFolder.'/'.$country_code.'/snapchat';
				if(!file_exists(realpath(storage_path('app/public/'.$folder_name))))
				     \Storage::makeDirectory('app/public/'.$folder_name, 0755, true, true);

				$image_path = url('/') . '/storage/'.$folder_name.'/'. $this->snap_image;
				if (file_exists($image_path))
					    @unlink($image_path);

				if (!filter_var($value, FILTER_VALIDATE_URL) === false) {
					$this->attributes['snap_image'] = self::uploadfileFromURL($value,$folder_name,$this->snap_username);
				} else {
					$values = $value->storeAs($folder_name,generateImageName($value),"public");
					$arrVal =explode('/',$values);
					$this->attributes['snap_image']=Str::snake($arrVal[count($arrVal)-1]);
				}
			}
	}


	public function getSnapImageAttribute(){
		$country_code = ($this->influencer->country) ? $this->influencer->country->code : 'kw';
        $folder_name = $this->imgFolder.'/'.$country_code.'/snapchat';
		return isset($this->imgFolder) && !empty($this->attributes['snap_image']) && file_exists(public_path('storage/'.$folder_name.'/'.$this->attributes['snap_image']))
		   ? getImg($this->attributes['snap_image'],$folder_name) : asset('/assets/img/avatar_logo.png');

	 }


}
