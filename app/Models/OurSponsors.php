<?php

namespace App\Models;

use App\Http\Traits\FileAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurSponsors extends Model
{
    use HasFactory,FileAttributes;
    protected $imgFolder = 'photos/sponsors';

    protected $guarded=[];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function scopeOfFilter($query,$req){
        return $query->when(array_key_exists('status', $req) && $req['status'] != null, function ($q) use ($req) {
            
            $q->where('status', intval($req['status']));
        });
    }
}
