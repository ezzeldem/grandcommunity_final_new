<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CampaignInfluencer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['influencer_id', 'list_id','notes', 'brand_id','test_qr_code', 'qr_code','test_influ_code', 'influ_code', 'campaign_type',
        'campaign_id','country_id','status','take_campaign','qrcode_valid_times','visit_or_delivery_date','reason','coverage','coverage_date','rate','comment_rate','branch_id','brief','confirmation_date','wait','created_by','coverage_status', 'confirmation_start_time', 'confirmation_end_time', 'reason_to_cancel', 'feedback'];

    protected $appends = ['visit_date','campaing_coverage_status','campaign_influencer_status'];
//    protected $casts=['coverage_status'=>'array'];
public function getCampaingCoverageStatusAttribute(){
    $status = '';
    if($this->coverage_date > Carbon::today() && $this->status == 2){
        $status = 'pending';
    }elseif($this->coverage_date < Carbon::today() && $this->status == 2){
        $status = 'overDue';
    }elseif($this->status == 7){
        $status = 'Done';
    }
    return $status;
}

public function campaignComplaint(){
    return $this->hasMany(campaignComplaint::class,'camp_id','id');
}
    public function scopeFilter($query, $request){
        if(is_object($request)){
            $request =   $request->toArray();
        }

        return $query->when(array_key_exists('country_val',$request)&& $request['country_val'] != 0, function ($q) use($request){
            $q->where('country_id', (int)$request['country_val']);

        })->when(array_key_exists('campaign_type_val',$request), function ($q) use($request){
            $q->where('campaign_type', (int)$request['campaign_type_val']);

        })->when(array_key_exists('branch_id',$request ) && $request['branch_id'] != null , function ($q) use($request){
            $q->where('branch_id', (int)$request['branch_id']);

        })->when(array_key_exists('complaint',$request ) && $request['complaint'] != null , function ($q) use($request){
            $q->whereHas('campaignComplaint',function ($campaign) use($request){
                return $campaign;
            });

        })->when(array_key_exists('country_id',$request) && $request['country_id'] != null, function ($q) use($request){
            $q->where('country_id', (int)$request['country_id']);

        })->when(array_key_exists('influencer_name',$request) && $request['influencer_name'] != null, function ($q) use($request){
            $q->whereHas('influencer',function ($e) use($request){
                return $e->where('insta_uname', 'like',"%".$request['influencer_name']."%");
            });

        })->when((array_key_exists('searchTerm', $request) && $request['searchTerm'] != null), function ($q) use ($request) {
            $q->whereHas('influencer', function ($e) use ($request) {
                return $e->where('insta_uname', 'LIKE', '%' . $request['searchTerm'] . '%');
            });

        })->when(array_key_exists('search',$request) && $request['search'] !=null,function ($q)use($request){
            $q->whereHas('influencer',function ($e) use($request){
                return $e->where('insta_uname', 'like',"%".$request['search']."%");
            });

        })->when(array_key_exists('camp_sub_type',$request) && $request['camp_sub_type'] != 0, function ($q) use($request){
            $q->where('status', (int)$request['camp_sub_type']);

        })->when(array_key_exists('rateCheck',$request) && $request['rateCheck'] != 0, function ($q) use($request) {
            $q->where('rate', (int)$request['rateCheck']);

        })->when(array_key_exists('qrCheck',$request) && $request['qrCheck'] != 0, function ($q) use($request) {
            ((int)$request['qrCheck']==1)? $q->whereNotNull('qr_code'):$q->whereNull('qr_code');

        })->when(array_key_exists('qrcode_search_form_input',$request) && $request['qrcode_search_form_input'] != 0, function ($q) use($request) {
             $q->where('influ_code', 'like',"%".$request['qrcode_search_form_input']."%");

        })->when(array_key_exists('brief',$request) && $request['brief'] != 0, function ($q) use($request) {
            ((int)$request['brief']==1)?$q->whereBrief(1):$q->whereBrief(0);

        })->when(array_key_exists('coverage_status',$request) && $request['coverage_status'] != 0, function ($q) use($request) {
            ((int)$request['coverage_status']==1)?$q->whereNotNull('coverage_date'):$q->whereNull('coverage_date');

        })->when( array_key_exists('status',$request) && $request['status'] !=null , function ($q) use($request) {
            $q->where('status', (int)$request['status']);

        })->when(array_key_exists('custom',$request) && $request['custom'] != 0, function ($q) use($request) {
            $q->whereHas('influencer',function ($e) use($request){
                return $e->where('name', 'like',"%".$request['custom']."%");
            });
        })->when(array_key_exists('visit_or_delivery_date',$request) && $request['visit_or_delivery_date'] != null, function ($q) use($request){
            $q->whereDate('visit_or_delivery_date', Carbon::parse($request['visit_or_delivery_date'])->format('Y-m-d'));

        })->when(array_key_exists('confirmed_date', $request) && $request['confirmed_date'] != null, function ($q) use ($request) {
           $q->whereDate('confirmation_date', "{$request['confirmed_date']}");
        });

        //  $sql = \Str::replaceArray('?', $query->getBindings(), $query->toSql());
        //  dd($sql);
    }

    public function scopeFilterStatus($query, $status){
        return  $query->when($status, function ($q) use($status){
            $q->where('status', (int)$status);
        });
    }

    public function influencer(){
        return $this->belongsTo(Influencer::class, 'influencer_id','id');
    }



    public function influencer_complain(){
        return $this->hasMany(InfluencerComplain::class, 'influencer_id' , 'influencer_id');
    }


    public function campaign(){
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function CampaignInfluencerVisit(){
        return $this->hasMany(CampaignInfluencerVisit::class, 'campaign_influencer_id');
    }

    public function getVisitDateAttribute(){
        if($this->visit_or_delivery_date){
            $date =  Carbon::parse($this->attributes['visit_or_delivery_date'])->format('Y-m-d');
            return $date ;
        }

    }
    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    // public function getCreatedAtAttribute($date)
    // {
    //     return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    // }

    public function CoverageStatus(){
        return [

            ["id"=>1,"title"=>"Done"],
            ["id"=>2,"title"=>"Need Brief"],
            ["id"=>3,"title"=>"Need Mention"],
            ["id"=>4,"title"=>"Need Snapchat"],
            ["id"=>5,"title"=>"Need Swip"],
            ["id"=>6,"title"=>"Need Tiktok"],
            ["id"=>7,"title"=>"Wrong Mention"],
         ];
    }


    public function getCampaignInfluencerStatusAttribute(){

        if($this->coverage_date <= Carbon::today() && $this->status == 2){

          // done
        }elseif($this->coverage_date > Carbon::today() && $this->status == 3 ||$this->status == 0){
        // overdue
        }elseif($this->coverage_date < Carbon::today() &&$this->status == 0){
            $this->status = 7;
         //pending
        }


    }


    public function getCoverageStatusAttribute($val)
    {
         $data = [];
         $coveragestatus = [];
         foreach($this->CoverageStatus() as $model)
        {array_push($coveragestatus,$model['id']);}
        $arryModel = explode(',',$val) ?? '';
        foreach($arryModel as  $element){
            if(in_array($element,$coveragestatus))
                array_push($data,$this->CoverageStatus()[--$element]['title']);
                     else
                        continue;
        }
        return $data;
    }

    public function getConfirmationDateAttribute($date)
    {
        return $date ? Carbon::parse($date)->format('Y-m-d') : null;
    }

}
