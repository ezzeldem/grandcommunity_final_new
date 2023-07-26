<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FileAttributes;

class ScrapeFacebook extends Model
{
    use HasFactory,FileAttributes;
    protected $imgFolder = 'photos/influencers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type', 'influe_brand_id', 'insta_username', 'insta_id', 'name', 'insta_image',
        'followers', 'following', 'uploads', 'engagement_average_rate', 'bio',
        'total_likes', 'total_comments', 'last_check_date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function influencer(){
        return $this->belongsTo(Influencer::class,'influe_brand_id')->where('type',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(){
        return $this->belongsTo(Brand::class, 'influe_brand_id')->where('type',2);
    }

}
