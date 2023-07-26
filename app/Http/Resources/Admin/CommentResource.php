<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' =>['id'=>$this->id, 'slug'=>$this->slug],
            'comment' =>$this->comment,
            'username'=>optional($this->user)->user_name,
            'website' =>$this->website,
            'status'  => ['status'=>$this->status, 'id'=>$this->id],
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
        ];
    }
}
