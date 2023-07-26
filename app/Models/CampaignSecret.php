<?php

namespace App\Models;

use App\Http\Traits\CustomCrypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
// use Illuminate\Support\Facades\Crypt;

class CampaignSecret extends Model
{
    use HasFactory,CustomCrypt;

    /**
     * @var string[]
     */
    protected $fillable = [
        'campaign_country_id','secret','is_active'
    ];

    /**
     * @param $value
     */
    public function setSecretAttribute($value){

        if($value){
            try {
                $this->attributes['secret'] = $this->encrypt($value);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                \Illuminate\Support\Facades\Artisan::call('cache:clear');
            }
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function getSecretAttribute($value){
//        return $value;
        try {
            return $this->decrypt($value);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
        }
    }

    // secret_permission_id campaign_secret_id

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(){
        return $this->belongsToMany(SecretPermission::class,'campaign_secret_permissions');
    }

    public function campaignCountry(){
        return $this->belongsTo(CampaignCountryFavourite::class,'campaign_country_id');
    }

}
//(`user_id`, `username`, `password`, `email`,
//`country_code`, `phone`, `name`, `facebook_id`, `token_code`,
//`email_activation_code`, `lost_password_code`, `type`, `active`, `expire_date`, `date`,
//`last_activity`, `points`, `no_ads`, `instagram_id`, `api_key`,
//`email_reports`, `user_permissions`, `otherDetails`, `countries`, `is_brand`)

//(4, 'Whiskers', '$2y$10$jgH0Ts4R42gBQr9oQ3yE3OuELLyyRe94.DIbznKFLhOHJ9SNM27cu',
//'Whiskers@grand-community.com', '+20', '1007961325', 'Whiskers', NULL,
//'d4e58006eb28384d85349ed30de6ef36', '0d754078627b27f3c466720fecc4f5da', '', 0, 0, '',
//'2021-01-03 18:38:50', NULL, 0, 0, NULL, '5466aed9205af480965aa48f03970f87', 0, '[1]',
//'{\"instagram\":\"\",\"tiktok\":\"\",\"facebook\":\"\",\"snapchat\":\"\",\"twitter\":\"\",\"website\":\"\",\"whatsapp\":\"\",\"address\":\"\",\"birth\":\"\",\"gender\":\"\",\"nationality\":\"\"}',
//'[\"Egypt\"]', 1),
