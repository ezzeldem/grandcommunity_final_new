<?php

namespace App\Models;

use App\Http\Traits\FileAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    use FileAttributes;
    protected $casts = [
        'country_id'=>'array'
    ];
    protected $imgFolder = 'photos/setting';
    protected $table = 'settings';
    protected $guarded =[];


}
