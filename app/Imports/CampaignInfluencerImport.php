<?php

namespace App\Imports;
use App\Models\CampaignInfluencer;
use App\Models\Country;
use App\Models\Influencer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CampaignInfluencerImport implements ToCollection,WithHeadingRow
{
    public $messages_success;
    protected $request;
    public  $id;
    public function __construct($request,$messages_success,$id)
    {
        
        $this->request = $request;
        $this->id = $id;
        $this->messages_success = $messages_success;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $influencer = Influencer::where('insta_uname',  $row['insta_uname'])->first();
                CampaignInfluencer::updateOrCreate([
                    'influencer_id' => $influencer->id,
                    'campaign_id' =>$this->id,
                    'status' => 0,
                ],['influencer_id'=>$influencer->id,'campaign_id'=>$this->id]);
                $this->messages_success[]=["status"=>"data Imported Successfully"];
            }
        return $this->messages_success;

    }


}
