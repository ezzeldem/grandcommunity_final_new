<?php

namespace App\Http\Resources\API;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {

        $user = auth()->user();
        if ($this->type == 0) {

            $otherData = $this->brands;
            $otherData->active = $otherData->status;
            //    $c = array_map('strtolower',$this->brands->countries->pluck('code')->toArray());
            $otherData->step = $otherData->step;
            $otherData->subbrands = $this->brands->subbrands;

        } else {
            $otherData = $this->influencers;
            $otherData->whatsapp = @$otherData->whats_number;
            // $otherData->lang = @array_map('intval',$otherData->lang??[]);
            // $otherData->interest = @array_map('intval', $otherData->interest??[]);
            $otherData->gender = (string) $otherData->gender ?? null;
            //$c = array_map('strtolower',$this->influencers->countries->pluck('code')->toArray());
            $c = '';
        }
        if ($this->type == 0) {

            $data = [
                'id' => $this->id,
                'gender' => $user->brands->gender ?? '',
                'status' => $user->brands->status ?? '',
                'step' => $user->brands->step ?? 1,
                'type' => $user->type,
                'token' => @$this->token ?? '',
                'email' => $user->email,
                'phone' => $user->phone,
                'code' => (int) $user->code,
                'username' => $user->user_name,
                'address' => $user->brands->address ?? '',
                'created_at' => date('d-m-Y', strtotime($user->created_at)),
                'updated_at' => date('d-m-Y', strtotime($user->updated_at)),
                'name' => $user->brands->name,
                'whatsapp_code' => (int) $user->brands->whatsapp_code,
                'whatsapp' => $user->brands->whatsapp,
                'social' => @$user->brands->social_media,
                'website_uname' => $user->brands->website_uname,
                'country_id' => $user->brands->country_id ?? [],
                'image' => $user->brands->image,
                'subbrand' => $user->brands->skipped == 1 ? (object) [] : ($user->brands->subbrands()->first(['id', 'name', 'preferred_gender', 'image', 'country_id', 'phone', 'code_whats', 'code_phone', 'whats_number', 'status', 'link_website']) ?? (object) []),
                'branches' => $user->brands->branchs ?? [],
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
                'status' => $user->influencers->active ?? '',
                'step' => $user->influencers->step ?? 1,
                'type' => $user->type,
                'token' => @$this->token ?? '',
                'social' => @$user->influencers->social_media,
                'website_uname' => $user->influencers->website_uname,
                'address' => $user->influencers->address ?? '',
                'jobs' => $user->influencers->job ?? (object) [],
                'image' => $user->influencers->image,
                'children' => $user->influencers->ChildrenInfluencer()->get(['id', 'child_name', 'child_gender', 'child_dob']) ?? (object) [],
                'phones' => $user->influencers->InfluencerPhones()->get(['code', 'phone']) ?? (object) [],
                'classification_ids' => (array) $user->influencers->classification_ids ?? [],
                'coverage_channel' => (array) $user->influencers->coverage_channel ?? [],
            ];

        }

        return $data;
    }
}
