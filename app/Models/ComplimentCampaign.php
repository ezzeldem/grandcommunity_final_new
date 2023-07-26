<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ComplimentCampaign extends Model
{
    protected $table = 'compliments_campaigns';
    protected $guarded = ['id'];
    protected $casts = [
        'gift_image' => 'array',
    ];

    public function getVoucherExpiredTimeAttribute($value)
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function getGiftImageAttribute($value)
    {
        $giftImages = $value ? json_decode($value, true) : [];
        if (is_array($giftImages) && count($giftImages) > 0) {
            foreach ($giftImages as &$file) {
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
            return $giftImages;
        }
    }

}
