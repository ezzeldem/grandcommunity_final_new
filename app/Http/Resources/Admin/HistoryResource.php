<?php

namespace App\Http\Resources\Admin;

use App\Models\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
            'id' => $this->id,
            'file' => $this->file,
            'description' =>  substr($this->description, 0, 100),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'priority' => taskPriority($this->priority),
            'status' => $this->status == 0 ? 'Resolved' : 'Unresolved',
            'assign_to' => $this->assign_status == 0 ? $this->user->name ?? '__' : Status::find($this->status_id)->name,
        ];
    }
}
