<?php

namespace App\Http\Traits;

use App\Models\Influencer;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Image;

trait FileAttributes
{
    /**
     * @return null|string
     */
    public function getImageAttribute(){

        if(isset($this->attributes['image'])){

            if(strpos($this->attributes['image'],'https') !== false ||strpos($this->attributes['image'],'http') !== false ){

                if(file_exists(public_path('storage/'.$this->imgFolder.'/'.$this->attributes['image']))){
                    return $this->imgFolder.'/'.$this->attributes['image'];
                }else{
                    return  $this->attributes['image'];
                }
            }else{
                if(file_exists(public_path('storage/'.$this->imgFolder.'/'.Str::snake($this->attributes['image'])))){
                    return getImg(Str::snake($this->attributes['image']),$this->imgFolder);
                }else if(file_exists(public_path('storage/'.$this->imgFolder.'/'.$this->attributes['image']))){
                    return getImg($this->attributes['image'],$this->imgFolder);
                }
            }
        }

        if ($this instanceof Influencer) {
            $instagram = $this->instagram()->first();
            if ($instagram) {
                return $instagram->insta_image;
            }

            $gender = $this->attributes['gender'] ?? null;
            if ($gender === 0) {
                return asset('/assets/img/female_avatar.png');
            } else if ($gender === 1) {
                return asset('/assets/img/avatar_logo.png');
            }
        }

        if($this->getMorphClass() !== 'App\Models\Page')
            return asset('/assets/img/avatar_logo.png');

        return null;
    }
    /**
     * @return null|string
     */
    public function getFileAttribute(){
        if($this->imgFolder == 'files/tasks')
            return asset('/files/tasks/'.$this->attributes['file']);

        if(isset($this->attributes['file'])){
            if(strpos($this->attributes['file'],'https') !== false ||strpos($this->attributes['file'],'http') !== false ){
                if(file_exists(public_path('storage/'.$this->imgFolder.'/'.$this->attributes['file']))){
                    return $this->imgFolder.'/'.$this->attributes['file'];
                }else{
                    return  $this->attributes['file'];
                }
            }else{
                if(file_exists(public_path('storage/'.$this->imgFolder.'/'.Str::snake($this->attributes['file'])))){
                    return getImg(Str::snake($this->attributes['file']),$this->imgFolder);
                }
            }
        }
    }

    /**
     * @return null|string
     */
    public function getBannerAttribute(){
        if(isset($this->attributes['banner'])){
            if(strpos($this->attributes['banner'],'https') !== false ||strpos($this->attributes['banner'],'http') !== false ){
                if(file_exists(public_path('storage/'.$this->imgFolder.'/'.$this->attributes['banner']))){
                    return $this->imgFolder.'/'.$this->attributes['banner'];
                }else{
                    return  $this->attributes['banner'];
                }
            }else{
                if(file_exists(public_path('storage/'.$this->imgFolder.'/'.Str::snake($this->attributes['banner'])))){
                    return getImg(Str::snake($this->attributes['banner']),$this->imgFolder);
                }else{
                    if($this->getMorphClass() !== 'App\Models\Page')
                        return asset('/assets/img/logo.png');
                }
            }
        }else{
            if($this->getMorphClass() !== 'App\Models\Page')
                return asset('/assets/img/logo.png');
        }
    }


	public function getQrcodeAttribute(){

		if(isset($this->attributes['qrcode'])){
			$folder_name = '/photos/influencers/qrcode';
			  if(file_exists(public_path('storage/'.$folder_name.'/'.$this->attributes['qrcode'])))
				  return getImg($this->attributes['qrcode'],$folder_name);
		}
    }

    /**
     * @param $value
     */
    public function setImageAttribute($value){
        if (!empty($value)){
            if (is_string($value) && !$this->is_base64($value)) {
                $this->attributes['image'] = $value;
            }else if (is_string($value) && $this->is_base64($value)) {
                $this->attributes['image'] = self::uploadBase64File($value,$this->imgFolder);
            } else {
                $values = $value->storeAs($this->imgFolder,generateImageName($value),"public");
                $arrVal =explode('/',$values);
                $this->attributes['image']=Str::snake($arrVal[count($arrVal)-1]);
            }
        }
    }

    /**
     * @param $value
     */
    public function setFileAttribute($value){
        if (!empty($value)){
            if (is_string($value)) {
                $this->attributes['file'] = $value;
            } else {
                $values = $value->storeAs($this->imgFolder,generateImageName($value),"public");
                $arrVal =explode('/',$values);
                $this->attributes['file']=Str::snake($arrVal[count($arrVal)-1]);
            }
        }
    }

    /**
     * @param $value
     */
    public function setBannerAttribute($value){
        if (!empty($value)){
            if (is_string($value)) {
                $this->attributes['banner'] = $value;
            } else {
               $values = $value->storeAs($this->imgFolder,generateImageName($value),"public");
                $arrVal =explode('/',$values);
                $this->attributes['banner']=Str::snake($arrVal[count($arrVal)-1]);
            }
        }
    }

    public function setHomepagePicAttribute($value){
        if (!empty($value)){
            if (is_string($value)) {
                $this->attributes['homepage_pic'] = $value;
            } else {
                $values= $value->storeAs($this->imgFolder,generateImageName($value),"public");
                $arrVal =explode('/',$values);
                $this->attributes['homepage_pic']=Str::snake($arrVal[count($arrVal)-1]);
            }
        }
    }

    public function getHomepagePicAttribute(){
        if(isset($this->attributes['homepage_pic'])){
            if(strpos($this->attributes['homepage_pic'],'https') !== false){
                if(file_exists(public_path('storage/'.$this->imgFolder.'/'.Str::snake($this->attributes['homepage_pic'])))){
                    return $this->imgFolder.'/'.$this->attributes['homepage_pic'];
                }else{
                    return asset('/assets/img/home.png');
                }
            }else{
                if(file_exists(public_path('storage/'.$this->imgFolder.'/'.Str::snake($this->attributes['homepage_pic'])))){
                    return getImg($this->attributes['homepage_pic'],$this->imgFolder);
                }else{
                    return asset('/assets/img/home.png');
                }
            }
        }else{
            return asset('/assets/img/home.png');
        }
    }


	public static function uploadfileFromURL($url,$folder_name,$username){

	//	dd($folder_name .'__________'.$username);
		$contents = file_get_contents($url);
		$name =  $username.'_'.rand(1, 100000000).'.jpeg';;
        $folder_name = 'public/'.$folder_name.'/'.$name;
		\Storage::put($folder_name, $contents);
	              return $name;
    }


	public function getSocialMediaAttribute(){

		$social_media = [];
		if(!empty($this->attributes['insta_uname'])):
			$social_media[]= (object)['key'=>'instagram','instagram_value'=>$this->attributes['insta_uname']];
		endif;
		if(!empty($this->attributes['snapchat_uname'])):
			$social_media[]= (object)['key'=>'snapchat','snapchat_value'=>$this->attributes['snapchat_uname']];
		endif;
		if(!empty($this->attributes['twitter_uname'])):
			$social_media[]= (object)['key'=>'twitter','twitter_value'=>$this->attributes['twitter_uname']];
		endif;
		if(!empty($this->attributes['facebook_uname'])):
				$social_media[]= (object)['key'=>'facebook','facebook_value'=>$this->attributes['facebook_uname']];
			endif;
		if(!empty($this->attributes['tiktok_uname'])):
			$social_media[]= (object)['key'=>'tiktok','tiktok_value'=>$this->attributes['tiktok_uname']];
		endif;

		return  $social_media;
	}

	public static function uploadBase64File($photo,$save_path){
			$manager = new ImageManager();
			$filename = "photos_".time().".png";
			$save_path = public_path().'/storage/'.$save_path.'/';
				$image = $manager->make( base64_decode($photo))->resize(400, null, function ($constraint) {
					$constraint->aspectRatio();
				})->save( $save_path  . $filename );
			return $filename;
	}

	function is_base64($s)
	{
		return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
	}


}
