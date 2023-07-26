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
use Maatwebsite\Excel\Concerns\WithValidation;
class ChickInListImport implements ToCollection,WithHeadingRow
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

        foreach ($collection as $row)
        {
            $influencer= Influencer::where('insta_uname','like',"%".$row['insta_uname']."%")->first();
            $branch= Branch::where('name', 'like',"%".$row['branch']."%")->first();
            $camp=Campaign::where('id',$this->request->camp_id)->first();
            $branchesIds=$camp->branches->pluck('id')->toArray();
            if(in_array($branch->id,$branchesIds)){

                $influencer_camp = CampaignInfluencer::where(['campaign_id'=>$this->request->camp_id,'influencer_id'=>$influencer->id])->where('brand_id',$this->request->brand_id)->first();
                if($influencer_camp){

                    $influencer_camp->update(['status'=>2,'campaign_type'=>0,'coverage_by'=>auth()->user()->id,'coverage_date'=>($row['coverage_date'])?date(json_decode($row['coverage_date'])):Null,'branch_id'=>$branch->id]);
                    CampaignInfluencerVisit::create([
                        'campaign_influencer_id'=>$influencer_camp->id,
                        'actual_date'=>date(json_decode($row['visit_date'])),
                        'status'=>2,
                        'no_of_companions'=>$row['no_of_companions'],
                        'branch_id'=>$branch->id
                    ]);
                    $this->messages_success[]=["status"=>"success"];
                }else{
                    $this->messages_success[]=['message'=>'user Not Camp Influe',"Name"=>$row['insta_uname'],"status"=>"faild"];
                }
            }else{
                $this->messages_success[]=["Name"=>$row['insta_uname'],"status"=>"faild"];
            }

        }
        return $this->messages_success;

    }

}
