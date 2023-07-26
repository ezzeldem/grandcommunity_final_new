<?php

namespace App\Exports;

use App\Models\Branch;
use App\Models\Campaign;
use App\Models\Status;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CampaignExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $campaign =  Campaign::all();
        $data = $campaign->transform(function ($q){
            return[
                "name" => $q->name,
                "preferred_gender"=>$q->gender,
                "has_guest"=>$q->has_guest?'true':'false',
                "brand"=>@$q->brand->name??'not found',
                "countries"=> implode(', ',$q->campaignCountries->load('country')->pluck('country.name')->toArray()),
                "sub_brand"=>@$q->subBrand->name??'not found',
                "branches" => implode(', ',Branch::whereIn('id',$q->branch_ids)->get()->pluck('name')->toArray()),
                "influencers_price"=>$q->influencers_price ,
                "influencer_count"=>$q->influencer_count ,
                "total_price"=>$q->total_price,
                "company_msg"=>$q->company_msg,
                "influencer_per_day"=>$q->influencer_per_day ,
                "influencers_script"=>$q->influencers_script ,
                "status"=> Status::where('type','campaign')->where('value',$q->status)->first()->name ,
                "campaign_type"=> @(campaignType()[$q->campaign_type])??'not found',
                "visit_start_date"=>$q->visit_start_date,
                "visit_end_date"=>$q->visit_end_date,
                "deliver_start_date"=>$q->deliver_start_date,
                "deliver_end_date"=>$q->deliver_end_date,
                'delivery_coverage'=>$q->delivery_coverage,
                'visit_coverage'=>$q->visit_coverage,
                'confirmation_link'=>$q->confirmation_link
            ];
        });
        return $data;
    }

    public function headings(): array
    {
        return [
            "name" , "preferred_gender", "has_guest", "brand","countries", "sub_brand", "branches" ,
            "influencers_price" , "influencer_count" , "total_price", "company_msg", "influencer_per_day" ,
            "influencers_script" , "status" , "campaign_type" ,"visit_start_date",
            "visit_end_date","deliver_start_date","deliver_end_date",'delivery_coverage','visit_coverage','confirmation_link'
        ];
    }

}
