<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function getTypeAttribute(){
        return  $this->attributes['type']==1 ? 'Influencer':'Brand';
    }

    public function getCreatedAtAttribute(){
        return  Carbon::parse( $this->attributes['created_at'] )->format('Y-m-d');
    }
}
