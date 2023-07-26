<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = [
        'created_at',
    ];

    public function getCreatedAtAttribute($value)
    {
        if(!is_null($value))
        $value = Carbon::parse($value);
        $diff = $value->diffForHumans(null, true, true, 2);
        return str_replace(['h', 'm'], ['hrs', 'mins'], $diff);

    }
    public function notifable()
    {
        return $this->morphTo();
    }
}
