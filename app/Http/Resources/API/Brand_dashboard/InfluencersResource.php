<?php

namespace App\Http\Resources\API\Brand_dashboard;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InfluencersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

		$added_date = Carbon::parse($this->influencers_groups_created_at)->format("Y-m-d");
        $user = auth()->user();
		$wishlist = $this->getJoinGroupsByBrandId(@$user->brands->id);
//		if($request->has('favorite') && $request->favorite =="-1")
//		    $added_date=($wishlist) ? Carbon::parse($wishlist['main_added_date'])->format("Y-m-d") : Carbon::parse($this->created_at)->format("Y-m-d");
//		elseif($request->has('favorite') && $request->favorite > 0)
//		  $added_date=($this->getJoinGroupsByBrandId(@$user->brands->id,$request->favorite)) ? Carbon::parse($this->getJoinGroupsByBrandId(@$user->brands->id,$request->favorite)['group_added_date'])->format("Y-m-d") : Carbon::parse($this->created_at)->format("Y-m-d") ;

        $campaignVisited = $this->campaignVisitedByBrandId(@$user->brands->id);

        return [
            'id' => (int) $this->id,
            'insta_uname' => (string) $this->insta_uname,
            'name' => (!empty($this->name) ? $this->name : ($this->instagram ? $this->insta_uname : '')),
            'user_name' => (!empty($this->user->user_name) ? $this->user->user_name : ''),
            'image' => (!empty($this->instagram) ? $this->instagram->insta_image : (!empty($this->twitter) ? $this->twitter->twitter_image : (!empty($this->snapchat) ? $this->snapchat->snap_image : (!empty($this->tiktok) ? $this->tiktok->tiktok_image : $this->image)))),
            'gender' => (int) $this->gender,
            'age' => Carbon::parse($this->date_of_birth)->age,
            'interest' => $this->interests->pluck('interest') ?? [],
            'country_code' => ($this->country) ? $this->country->code : '',
            'country_name' => ($this->country) ? $this->country->name : '',
            'rating' => $this->InfluencerRate()->where('brand_id', $user->brands->id)->first() ? $this->InfluencerRate()->where('brand_id', $user->brands->id)->first()->rate : 0,
            'nationality' => ($this->nationalityRelation) ? $this->nationalityRelation->code : '',
            'nationality_flag' => ($this->nationalityRelation) ? "https://hatscripts.github.io/circle-flags/flags/" . \Str::lower($this->nationalityRelation->code) . '.svg' : '',
            'social_media' => $this->SocialMedia(),
            "is_favorite" => (boolean) $this->brandsFavorites()->where('brands.id', @$user->brands->id)->exists(),
            'is_dislike' => (boolean) $this->dislikes()->where('brand_id', @$user->brands->id)->exists(),
            'fav_groups' => ($wishlist) ? $wishlist['groups'] : [],
            'added_date' => $added_date,
            'marital_status' => !empty($this->marital_status) && array_column(User::getInfluencerSocialType(), null, 'id')[$this->marital_status] ? (array_column(User::getInfluencerSocialType(), null, 'id')[$this->marital_status])['name'] : '',
            'all_campaign_count' => $campaignVisited ? $campaignVisited['campaign_count'] : 0,
            'campaign_type' => $campaignVisited ? $campaignVisited['campaign_type'] : '-1',
            'is_vip' => $this->IsVIP(),
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->format("Y-m-d") : '',
            'is_new' => ($this->created_at !== null && (Carbon::parse($this->created_at)->isToday() || Carbon::parse($this->created_at)->isYesterday())) ? 'yes' : 'no',
        ];
    }
}
