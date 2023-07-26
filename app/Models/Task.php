<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FileAttributes;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory, FileAttributes;
    protected $casts = [
        'user_id'=>'array',
        'status_id'=>'array',
    ];
    protected $dates = [
        'start_date',
        'end_date'
    ];
    
    protected $fillable = ['description', 'start_date', 'end_date', 'priority', 'status', 'file', 'assign_status', 'user_id', 'status_id'];

    public function user(){
        return $this->belongsTo('App\Models\Admin');
    }

    public function status(){
        return $this->belongsTo('App\Models\Status');
    }

    /**
     * Get the Start Date Row.
     *
     * @param  string  $value
     * @return string
     */
    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-y D');
    }

    /**
     * Get the End Date Row.
     *
     * @param  string  $value
     * @return string
     */
    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-y D');
    }
}
