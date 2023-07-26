<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
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
            'name' => $this->name,
            'status' => ['id' => $this->id, 'status' => $this->status],
            'country' => ['id' => $this->country->id ?? '', 'name' => $this->country->name ?? ''],
            'offices_count' => $this->country->offices->count() ?? 0,
        ];
    }
}
