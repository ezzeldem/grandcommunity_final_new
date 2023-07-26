<?php

namespace App\Models;

use App\Http\Traits\FileAttributes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;


class Admin extends Authenticatable
{
    use HasFactory, Notifiable,FileAttributes,SoftDeletes,HasRoles;

    protected $imgFolder = 'photos/admins';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'image', 'active','role','country_id','office_id'
    ];
    protected $appends = ['role_id'];
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
        'active'=> 'string'
    ];
    /**
     * @var string[]
     */
    protected $dates = ['deleted_at'];
    protected $softDelete = true;



    public function scopeOfDashboardFilter($query, $req)
    {

        return $query->when(($req->get('status_val') == 0 || $req->get('status_val')) && $req['status_val'] != null, function ($q) use ($req) {
            $status=($req['status_val']==2)?0:$req['status_val'];
                $q->where('active', $status);
            })->when($req->get('country_val')&&$req['country_val']!=null,function ($q)use($req){
                $q->whereIn('country_id', $req['country_val']);
            })->when($req->get('role')&&$req['role']!=null,function ($q)use($req){
                $q->where('role', $req['role']);
            })->when(($req->has('start_date') && $req['start_date'] != null) &&
                ($req->has('end_date') && $req['end_date'] != null), function ($q) use ($req) {
                $q->whereBetween('created_at', [Carbon::parse($req['start_date']), Carbon::parse($req['end_date'])]);
        });
    }
    public function scopeFilter($query, $req)
    {
        return $query->when(array_key_exists('country_val',$req) &&$req['country_val']!=null,function ($q)use($req){
            $q->where("country_id",$req['country_val']);
        })->when(array_key_exists('role',$req) &&$req['role']!=null, function ($q) use ($req) {
            $q->where('role', $req['role']);
        })->when((array_key_exists('start_date',$req) && $req['start_date'] != null) &&
                (array_key_exists('end_date',$req) && $req['end_date'] != null), function ($q) use ($req) {
            $q->whereBetween('created_at', [Carbon::parse($req['start_date']), Carbon::parse($req['end_date'])]);
            });
    }



//    protected static function booted()
//    {
//        dd(\request()->hasHeader('cookieCountry'));
//        static::addGlobalScope('countries', function (Builder $builder) {
//            if($country=\session()->get('country')){
//                $builder->whereIn('country_id', $country);
//            }elseif(\request()->hasHeader('cookieCountry') && \request()->header('cookieCountry') != -1){
//                $builder->where("country_id", \request()->header('cookieCountry'));
//            }else{
//                $builder;
//            }
//        });
//    }

    public function SetPasswordAttribute($value){
        if($value){
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function getRoleIdAttribute(){
        return @$this->roles()->first()->id?:0;
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function campLog(){
        return $this->hasMany(LogCamp::class,'campaign_id');
    }

    public function office(){
        return $this->hasOne(Office::class,'sales_id');
    }

}
