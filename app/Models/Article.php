<?php

namespace App\Models;

use App\Http\Traits\FileAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasFactory, HasTranslations, FileAttributes, SoftDeletes;

    public $translatable = ['title', 'description','tags'];
    protected $fillable = ['title', 'description', 'slug', 'tags', 'image', 'status', 'page_type', 'created_by'];
    protected $imgFolder = 'photos/pages';

    public function admin(){
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function sections()
    {
        return $this->morphMany(Section::class, 'sectionable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approved_comments()
    {
        return $this->hasMany(Comment::class)->where('status',1);
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'likes')->withPivot('is_dislike')->withTimestamps();
    }
    public function getTitleAttribute(){
        return  @((array)json_decode($this->attributes['title']))[app()->getLocale()];
    }
    public static function Related($id){
     return Article::where('id','!=',$id)
     ->inRandomOrder()
     ->limit(4)
     ->get(['title','image','created_at']);
    }

}
