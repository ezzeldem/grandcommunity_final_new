<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupListsFavourits extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =['brand_favourite_id', 'group_list_id'];
}
