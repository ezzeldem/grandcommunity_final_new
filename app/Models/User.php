<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_name',
        'email',
        'phone',
        'code',
        'password',
        'type',
        'forget_type',
        'forget_code',
        'forget_at',
        'facebook_id'
    ];
    public function notification()
    {
        return $this->morphMany('App\Models\Notification', 'notifable');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];


    public function setPasswordAttribute($val){
        if($val){
            $this->attributes['password'] = bcrypt($val);
        }
    }
    /**brand
     * @return BelongsTo
     */
    public function brands(){

        return $this->hasOne(Brand::class, 'user_id');
    }

    /**influencer
     * @return BelongsTo
     */
    public function influencers(){
        return $this->hasOne(Influencer::class, 'user_id');
    }

    public static function getInfluencerSocialType()
    {
        $data = [
            ['id' => 1, 'name' => 'single'],
            ['id' => 2, 'name' => 'married'],
            ['id' => 3, 'name' => 'divorced'],

        ];
        return $data;
    }

    public static function getInfluencerStatus()
    {
        $data = [
            ['id' => 0, 'name' => 'Pending'],
            ['id' => 1, 'name' => 'Active'],
            ['id' => 2, 'name' => 'Inactive'],
            ['id' => 3, 'name' => 'Reject'],
            ['id' => 4, 'name' => 'Block'],
            ['id' => 5, 'name' => 'No Response'],
            ['id' => 7, 'name' => 'Out Of Country'],

        ];
        return $data;
    }
    public function scopeOfDashboardFilter($query, $req)
    {
        return $query->where(function ($q){
            $q->whereHas('brands',function ($q){
                $q->where('status',2);
            })->orWhereHas('influencers',function ($q){
                $q->where('active',2);
            });
        })->when(($req->has('start_date') && $req['start_date'] != null) &&
            ($req->has('end_date') && $req['end_date'] != null), function ($q) use ($req) {
            $q->where(function ($q)use($req){
                   $q->whereBetween('created_at', [Carbon::parse($req['start_date']), Carbon::parse($req['end_date'])])
                     ->orWhereRaw('DATE(created_at) = ?', [Carbon::parse($req['start_date'])])
                     ->orWhereRaw('DATE(created_at) = ?', [Carbon::parse($req['end_date'])]);
               });
        });
    }

    public function socialProviders(){
        return $this->hasMany(SocialProvider::class,'user_id');
    }

    public function likes(){
        return $this->belongsToMany(Article::class, 'likes')->withPivot('is_dislike')->withTimestamps();
    }
}
