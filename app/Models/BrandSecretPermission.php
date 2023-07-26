<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandSecretPermission extends Model
{
    use HasFactory;

    protected $fillable = ['brand_secret_id','secret_permission_id'];

}
