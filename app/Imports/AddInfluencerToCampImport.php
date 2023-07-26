<?php

namespace App\Imports;

use App\Models\CampaignInfluencer;
use App\Models\Country;
use App\Models\Influencer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AddInfluencerToCampImport implements ToCollection,WithHeadingRow
{
    public $messages_success;
    protected $request;
    public function __construct($request,$messages_success)
    {
        $this->request = $request;
        $this->messages_success = $messages_success;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            try {
                $influencer = Influencer::whereHas('user', function ($q) use ($row) {
                    $q->where('user_name', $row['user_name']);
                })->orderBy('id', 'desc')->first();

                if ($influencer && in_array((string)$influencer->country_id, explode(',', $this->request->country_id))) {
                    CampaignInfluencer::updateOrCreate([
                        'influencer_id' => $influencer->id,
                        'campaign_id' =>  $this->request->camp_id,
                        'country_id' =>  $influencer->country_id,
                        //'status' => 0,
                        // 'brand_id' =>  $this->request->brand_id,
                        // 'campaign_type' =>  $this->request->campaign_type,
                    ],['influencer_id'=>$influencer->id,'campaign_id'=>$this->request->camp_id,'country_id'=>$influencer->country_id]);
                    $this->messages_success[]=["status"=>"success"];

                }else{
                    $this->messages_success[]=['message'=>'Influencer Not Camp Country',"Name"=>$row['user_name'],"status"=>"faild"];
                }
            }catch (\Exception $exception){
                $this->messages_success[]=['message'=> "Something went wrong.","Name"=>$row['user_name']??"none","status"=>"faild"];
            }

        }
        return $this->messages_success;

    }

}
