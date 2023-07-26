<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'name', 'website', 'status', 'article_id', 'user_id', 'email'];
    

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function active_replies(){
        return $this->hasMany(Reply::class)->where('status',1);
    }
}
