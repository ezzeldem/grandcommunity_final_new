<?php

namespace App\Http\Resources\Admin;

use App\Models\Country;
use App\Models\GroupList;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InfluencerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userData = $this->user?:new User;

        $phonesList = ["1" => [], "2" => [], "3" => []];
        foreach ($this->InfluencerPhones as $phoneRow){
            $phonesList[$phoneRow->type][] = $phoneRow->code."-".$phoneRow->phone;
        }

        $marital_status = '';
        if($this->marital_status==1)  $marital_status ="Single";
        elseif($this->marital_status==2) $marital_status ="Married";
        elseif($this->marital_status==3) $marital_status ="divocred";

        $lang = [];
        foreach ((array)$this->lang as $sta) {
            if ($sta == "1") array_push($lang, 'Arabic');
            elseif ($sta == "2") array_push($lang, 'English');
            elseif ($sta == "3") array_push($lang, 'French');
        }

        $childrenInfo = [];

        $status = '';
        if($this->active==0) $status="pending";
        elseif($this->active==1) $status="Active";
        elseif($this->active==2) $status="inactive";
        elseif($this->active==3) $status="reject";
        elseif($this->active==4) $status="Block";
        elseif($this->active==5) $status="No Respone";
        elseif($this->active==7) $status="Out Of Country";

        foreach ($this->ChildrenInfluencer as $childRow){
            $childrenInfo[] = "(".$childRow->child_name.",".$childRow->child_dob.",".$childRow->child_gender.")";
        }

        $account_type = "";
        foreach ([["id"=>1,"title"=>"Personal"],["id"=>2,"title"=>"Product-based"],["id"=>3,"title"=>"General"]] as $rowType){
            if($rowType['id'] == $this->account_type){
                $account_type = $rowType['title'];
            }
        }

        $coveredPlatform = [];
        foreach (['insta_uname', 'snapchat_uname', 'tiktok_uname', 'facebook_uname', 'twitter_uname'] as $rowPlatform){
            $coveredPlatform[] = $this->{$rowPlatform};
        }

        $interests = $this->interests->pluck('interest')->toArray();

//user, InfluencerPhones, nationalityRelation, country, state, city, ChildrenInfluencer
        return [
            'status' => $status,
            'user_name'=> (string)$userData->user_name,
            'name'=> (string)$this->name,
            'email'=> (string)$userData->email,

            'primary_phone' => $userData->code.$userData->phone,
            'primary_whatsapp' => $userData->code_whats.$userData->whats_number,

            'call_phones' => implode(",",$phonesList["1"]),
            'whatsapp_phones' => implode(",",$phonesList["3"]),
            'office_phones' => implode(",",$phonesList["2"]),

            'nationality'=>$this->nationalityRelation ? (string) $this->nationalityRelation->name : '',
            'gender'=> $this->gender == 0?"female":"male",
            'date_of_birth'=>(!empty($this->date_of_birth)) ?Carbon::parse($this->date_of_birth)->format("Y-m-d") : '',
            'marital_status'=>$marital_status,
            'language' => implode(',',$lang),
            'country'=>($this->country) ? $this->country->name : '',
            'governorate'=> ($this->state) ? $this->state->name : '',
            'city'=>($this->city) ? $this->city->name : '',
            'address_ar'=>(string)$this->adress_ar,
            'address_en'=>(string)$this->address,

            'children_number' => (int) $this->children_num,
            'children_info' => implode(',',$childrenInfo),

			'instagram_username'=>(string)$this->insta_uname,
			'snapchat_username'=>(string)$this->snapchat_uname,
			'tiktok_username'=>(string)$this->tiktok_uname,
			'facebook_username'=>(string)$this->facebook_uname,
			'twitter_username'=>(string)$this->twitter_uname,

            'account_type'=> $account_type,
            'categories'=>($this->Categories()) ? implode(',',$this->Categories()) : '',
            'classification' => implode(',', $this->InfluencerClassification),
            'coverage_platform'=> implode(',',$coveredPlatform),
            'interests' => implode(',', $interests),
            'image_path' => $this->image,

        ];
    }
}
