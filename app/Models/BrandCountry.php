<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandCountry extends Model
{
    use HasFactory;
    protected $fillable = ['brand_id', 'country_id', 'created_by', 'status'];
}
