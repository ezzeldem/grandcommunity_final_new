<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class BrandSecret extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id','secret','is_active'];

    public function setSecretAttribute($value){
        if($value){
//            $this->attributes['secret'] = Crypt::encryptString($value);
        }
    }

 

    // secret_permission_id brand_secret_id
    public function permissions(){
        return $this->belongsToMany(SecretPermission::class,'brand_secret_permissions');
    }
}
