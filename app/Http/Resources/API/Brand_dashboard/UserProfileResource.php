<?php

namespace App\Http\Resources\API\Brand_dashboard;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {

        $user = auth()->user();

        if ($this->type == 0) {

            $data = [
                'id' => $this->id,
                'gender' => $user->brands->gender ?? '',
                'type' => $user->type,
                'email' => $user->email,
                'phone' => $user->phone,
                'code' => (int) $user->code,
                'username' => $user->user_name,
                'created_at' => date('d-m-Y', strtotime($user->created_at)),
                'updated_at' => date('d-m-Y', strtotime($user->updated_at)),
                'name' => $user->brands->name,
                'whatsapp_code' => (int) $user->brands->whatsapp_code,
                'whatsapp' => $user->brands->whatsapp,
                'social' => @$user->brands->social_media,
                'website_uname' => $user->brands->website_uname,
                'country_id' => $user->brands->country_id ?? [],
                'image' => $user->brands->image,
                'countries' => $user->brands->countries ?? [],
            ];

        } else {

            $data = [
                'id' => $this->id,
                'username' => $user->user_name,
                'name' => $user->influencers->name,
                'email' => $user->email,
                'country_id' => $user->influencers->country_id ?? '',
                'code' => $user->code,
                'phone' => $user->phone,
                'whatsapp_code' => $user->influencers->code_whats,
                'whatsapp' => $user->influencers->whatsapp,
                'date_of_birth' => $user->influencers->date_of_birth ? date('d-m-Y', strtotime($user->influencers->date_of_birth)) : '',
                'gender' => $user->influencers->gender ?? '',
                'interests' => (array) $user->influencers->interest ?? [],
                'lang' => (array) $user->influencers->lang ?? [],
                'state_id' => $user->influencers->state_id ?? '',
                'city_id' => $user->influencers->city_id ?? '',
                'nationalty' => $user->influencers->nationality,
                'social' => @$user->influencers->social_media,
                'website_uname' => $user->influencers->website_uname,
                'address' => $user->influencers->address ?? '',
                'jobs' => $user->influencers->job ?? (object) [],
                'image' => $user->influencers->image,
                'children' => $user->influencers->ChildrenInfluencer()->get(['id', 'child_name', 'child_gender', 'child_dob']) ?? (object) [],
            ];

        }

        return $data;
    }
}
