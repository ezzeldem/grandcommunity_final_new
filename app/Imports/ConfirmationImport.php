<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Campaign;
use App\Models\CampaignInfluencer;
use App\Models\CampaignInfluencerVisit;
use App\Models\Influencer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ConfirmationImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public $messages_success;
    protected $request;
    public function __construct($request,$messages_success)
    {
        $this->request = $request;
        $this->messages_success = $messages_success;
    }
    public function collection(Collection $collection)
    {
        $countRow=$collection->count()-1;
        foreach ($collection as $key=> $row)
        {
            $influencer= Influencer::where('insta_uname','like',"%".$row['insta_uname']."%")->first();
            $branch= Branch::where('name', 'like',"%".$row['branch']."%")->first();
            $camp=Campaign::where('id',$this->request->camp_id)->first();
            $branchesIds=$camp->branches->pluck('id')->toArray();
            if(in_array($branch->id,$branchesIds)){
                $influencer_camp = CampaignInfluencer::where(['campaign_id'=>$this->request->camp_id,'influencer_id'=>$influencer->id])->where('brand_id',$this->request->brand_id)->first();
                if($influencer_camp){
                    if($key+1 <= $camp->influencer_count){
                        $influencer_camp->update(['status'=>1,'campaign_type'=>0,'coverage_by'=>auth()->user()->id,'coverage_date'=>($row['coverage_date'])?date(json_decode($row['coverage_date'])):Null,'branch_id'=>$branch->id,'confirmation_date'=>date(json_decode($row['confirmation_date'])),'brief'=>(ucfirst($row['brief'])=='Yes')?1:0]);
                        $this->messages_success[]=["status"=>"success"];
                    }else{
                        $influencer_camp->update(['status'=>1,'campaign_type'=>0,'coverage_by'=>auth()->user()->id,'coverage_date'=>($row['coverage_date'])?date(json_decode($row['coverage_date'])):Null,'branch_id'=>$branch->id,'wait'=>1,'confirmation_date'=>date(json_decode($row['confirmation_date'])),'brief'=>($row['brief']=='Yes')?1:0]);
                        $this->messages_success[]=['message'=>"this is in waitList","Name"=>$row['insta_uname'], "status"=>"faild"];
                    }
                }else{
                    $this->messages_success[]=['message'=>'user Not Camp Influe',"Name"=>$row['insta_uname'],"status"=>"faild"];
                }
            }else{
                $this->messages_success[]=["Name"=>$row['insta_uname'],"status"=>"faild"];
            }
        }
    }
}
