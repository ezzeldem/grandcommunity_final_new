<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignSecretPermission extends Model
{
    use HasFactory;

    protected $fillable = [
      'campaign_secret_id','secret_permission_id'
    ];
}
