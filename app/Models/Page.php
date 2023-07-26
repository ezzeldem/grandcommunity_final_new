<?php

namespace App\Models;

use App\Http\Traits\FileAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;


class Page  extends Model
{
    use HasFactory, HasTranslations, FileAttributes, SoftDeletes;

  
    public function scopeOfFilter($query, $req){
        return $query->when(array_key_exists('status_val',$req)&&$req['status_val']!=null,function ($q)use($req){
            $status=($req['status_val']==2)?0:$req['status_val'];
            $q->where('status', intval($status));
        });

    }
    public $translatable = ['title', 'description'];
    protected $fillable = ['title', 'description', 'slug', 'position', 'image', 'status', 'page_type','created_by'];
    protected $imgFolder = 'photos/pages';

    public function admin(){
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function sections()
    {
        return $this->morphMany(Section::class, 'sectionable');
    }


}
