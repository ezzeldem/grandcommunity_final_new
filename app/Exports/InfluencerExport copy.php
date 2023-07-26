<?php

namespace App\Exports;

use App\Models\City;
use App\Models\Country;
use App\Models\Influencer;
use App\Models\InfluencerClassification;
use App\Models\InfluencerPhone;
use App\Models\Nationality;
use App\Models\State;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class InfluencerExport implements FromCollection,WithHeadings,WithEvents,WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $visibleColumns;
    protected $selected_ids;
    protected $request;

    public function columnFormats(): array
    {
        return [
            'N' => "###-###-####"
        ];
    }
    public function styles(Worksheet $sheet)
{
    return [

        1    => ['font' => ['bold' => true]],
    ];
}

    public function __construct($visibleColumns, $selected_ids,$request)
    {
        $this->visibleColumns = $visibleColumns;
        $this->selected_ids = $selected_ids;
        $this->request=$request;
    }


    public function collection()
    {
        if(count($this->request->all()) > 1 ) {
            $influencers = Influencer::when( ($this->selected_ids && !empty($this->selected_ids ))  , function ($q){
                return $q->whereIn('id', $this->selected_ids);
            })->when(($this->request->nationality_id_search && $this->request->nationality_id_search != 'null' && !empty($this->request->nationality_id_search )), function ($q){
                return $q->where('nationality', $this->request->nationality_id_search);
            })->when(($this->request->has('gender') && $this->request->gender!=null && !empty($this->request->has('gender'))), function ($q){
                return $q->where('gender', $this->request->gender);
            })->when(($this->request->children_num && $this->request->children_num!=null && !empty($this->request->children_num)), function($q){
                return $q->where('children_num', $this->request->children_num);
            })->when(($this->request->lang && $this->request->lang!=null && !empty($this->request->lang)), function($q){
                return $q->where('lang', $this->request->lang);
            })->when(($this->request->socialType_id_search && $this->request->socialType_id_search!=null && !empty($this->request->socialType_id_search)), function($q){
                return $q->where('marital_status', $this->request->socialType_id_search);
            })->when(($this->request->ethink_id_search && $this->request->ethink_id_search!=null && !empty($this->request->ethink_id_search)), function($q){
                return $q->where('ethink_category', $this->request->ethink_id_search);
            })->when(($this->request->citizen_status && $this->request->citizen_status!=null && !empty($this->request->citizen_status)), function($q){
                return $q->where('citizen_status', $this->request->citizen_status);
            })->when(($this->request->channel_id_search && $this->request->channel_id_search!=null && !empty($this->request->channel_id_search)), function($q){
                return $q->where('coverage_channel', $this->request->channel_id_search);
            })->when(($this->request->interests_id_search && $this->request->interests_id_search!=null && !empty($this->request->interests_id_search)), function($q){
                return $q->where('interest', $this->request->interests_id_search);
            })->when(($this->request->category && $this->request->category!=null && !empty($this->request->category)), function($q){
                return $q->where('category_ids', $this->request->category);
            })->when(($this->request->accountStatus_id_search && $this->request->accountStatus_id_search!=null && !empty($this->request->accountStatus_id_search)), function($q){
                return $q->where('account_type', $this->request->accountStatus_id_search);
            })->when(($this->request->chkveg && $this->request->chkveg!=null && !empty($this->request->chkveg)), function($q){
                return $q->where('classification_ids', $this->request->chkveg);
            })->when(($this->request->not_has_multi_classification && $this->request->not_has_multi_classification!=null && !empty($this->request->not_has_multi_classification)), function($q){
                return $q->where('classification_ids', $this->request->not_has_multi_classification);
            })->when(($this->request->min_voucher && $this->request->min_voucher!=null && !empty($this->request->min_voucher)), function($q){
                return $q->where('min_voucher', $this->request->min_voucher);
            })->when(($this->request->country_id_search && $this->request->country_id_search!=null && !empty($this->request->country_id_search)), function($q){
                return $q->where('country_id', $this->request->country_id_search);
            })->when(($this->request->state_id_search && $this->request->state_id_search!=null && !empty($this->request->state_id_search)), function($q){
                return $q->where('state_id', $this->request->state_id_search);
            })->when(($this->request->city_id_search && $this->request->city_id_search!=null && !empty($this->request->city_id_search)), function($q){
                return $q->where('city_id', $this->request->city_id_search);
            })
            ->orderBy('created_at', 'desc')->get();
        }else{
            // $influencers = Influencer::orderBy('created_at', 'desc')->take(10)->get();
            $influencers = Influencer::all();
        }


        $data = $influencers->transform(function ($q){

            $interests = [];
            $languages = [];
            $categories = [];

            $category_ids = implode(',',$q->category_ids);
            preg_match_all('/\d+/', $category_ids, $matches);
            $categories = $matches[0];
            $categories_ids = InfluencerClassification::select('name')->whereIn('id',$categories)->get()->map(function ($q){
                return $q->name;
            })->toArray();


            foreach($q->interests as $interest){
                $interests[] = $interest->interest;
            };

            foreach($q->languages as $language){
                $languages[] = $language->name;
            };

            $phone_type = InfluencerPhone::select('type')->where('influencer_id',$q->id)->get()->map(function ($q){
                if($q->type == 1)
                    return 'Call';
                else if($q->type == 2)
                    return 'Office';
                else if($q->type == 3)
                    return 'WhatsApp';
            })->toArray();


            $phone_code = InfluencerPhone::select('code')->where('influencer_id',$q->id)->get()->map(function ($q){
                return $q->code;
            })->toArray();

            $phone = InfluencerPhone::select('phone')->where('influencer_id',$q->id)->get()->map(function ($q){
                return $q->phone;
            })->toArray();

            $zip_phone = array_map(function($a, $b) {
                return $a . '-' . $b;
            }, $phone_code, $phone);


            $coverageChannels = Influencer::select('coverage_channel')->where('id',$q->id)->get();
            $coverageChannelsArray = $coverageChannels->toArray();
            $coverageChannelsString = '';
            if(count($coverageChannelsArray) > 0) {
                $coverageChannelsArray =  $coverageChannelsArray[0]['coverage_channel'];
                if ($coverageChannelsArray) {
                    $socialMedia = getCampaignCoverageChannels();
                    foreach($socialMedia as $socialMediaValue) {
                        if(in_array($socialMediaValue->id, $coverageChannelsArray)) {
                            $coverageChannelsString .= $socialMediaValue->title . '-';
                        }
                    }
                }
            }

            $coverageChannelsString = substr($coverageChannelsString, 0, -1);

            $has_children = Influencer::select('children_num')->where('id',$q->id)->get()->map(function ($q){
                if($q->children_num > 0)
                    return 'Yes';
                else
                    return 'No';
            })->toArray();

            $classificationNameObj = [];
            $classificationName = [];
            if($q->classification_ids) {
                $InfluencerClassificationsIDs = implode(',', $q->classification_ids);
                preg_match_all('/\d+/', $InfluencerClassificationsIDs, $matches);
                $classifications = $matches[0];
                $InfluencerClassifications = InfluencerClassification::whereIn('id', $classifications)->get();
                foreach ($InfluencerClassifications as $InfluencerClassification) {
                    if ($InfluencerClassification->status == 'classification') {
                        $classificationName[] = $InfluencerClassification->name;
                    }
                }
            }
            $influencerAllClassificationNames = InfluencerClassification::Where('status','classification')->pluck('name')->toArray();
            foreach($influencerAllClassificationNames as $influencerAllClassificationName){
                if(in_array($influencerAllClassificationName,$classificationName)){
                    $classificationNameObj[$influencerAllClassificationName] = "Yes";
                }else{
                    $classificationNameObj[$influencerAllClassificationName] = "No";
                }
            }

            $mainArr =    [
                'insta_uname'=>$q->insta_uname,
                'snapchat_uname'=>$q->snapchat_uname,
                'twitter_uname'=>$q->twitter_uname,
                'tiktok_uname'=>$q->tiktok_uname,
                'facebook_uname'=>$q->facebook_uname,
                'name'=>$q->name,
                'type_phone1'=>$phone_type[0] ?? '',
                'zip-phone1'=>$zip_phone[0] ?? '',
                'type_phone2'=>$phone_type[1] ?? '',
                'zip-phone2'=>$zip_phone[1] ?? '',
                'type_phone3'=>$q->phone[2] ?? '',
                'zip-phone3'=>$zip_phone[3] ?? '',
                'country'=>@Country::where('id',$q->country_id)->first()->name,
                'government'=>@State::where('id',$q->state_id)->first()->name,
                'city'=>@City::where('id',$q->city_id)->first()->name,
                'address'=>$q->address,
//                'address_en'=>$q->address,
//                'address_ar'=>$q->address_ar,
                'date_of_birth'=>date('Y-m-d', strtotime($q->date_of_birth)),
                'category_ids'=>implode("-",$categories_ids),
                'interest'=>implode("-", $interests),
                'gender'=>$q->gender ? 'Male' :'Female',
                'languages'=>implode("-", $languages),
                'ethink_category'=> $q->ethink_category == 1 ? 'Open-minded' : 'Conservative',
                'marital_status'=>($q->marital_status ==1) ? 'Single' : (($q->marital_status ==2) ? 'Married' : 'Divorced'),
                'account_type'=> $q->account_type == 1 ? 'Personal' : (($q->account_type == 2) ? 'Product-based' : 'General'),
                'coverage_platform'=> $coverageChannelsString,
                'has_children'=>$has_children[0],
                'email'=>$q->user?->email,
                'nationality'=> @Nationality::where('id', $q->nationality)->first()->name,
                'active_reels' => '',
                'notes'=>'',
            ];

           return array_merge($mainArr,$classificationNameObj);
        });
        return $data;
    }

    public function headings(): array
    {
        $influencerClassification = InfluencerClassification::Where('status','classification')->pluck('name')->toArray();

       return [
           'final_user_instagram',
           'user_snapchat',
           'user_twitter',
           'user_tiktok',
           'user_facebook',
           'Name',
           'Type_Phone1',
           'Zip-Phone1',
           'Type_Phone2',
           'Zip-Phone2',
           'Type_Phone3',
           'Zip-Phone3',
           'Country',
           'Government',
           'City',
           'Address En',
           'Address Ar',
           'Date Of Birth',
           'Categories',
           'Interests',
           'Gender',
           'Languages',
           'Ethink Category',
           'Marital Status',
           'Account Type',
           'Coverage Platform',
           'Has Children',
           'Email',
           'Nationality',
           'Active Reels',
           'Notes',
           ...$influencerClassification,
       ];
    }

    public function registerEvents(): array
    {
        $styleArray = ['font' => ['bold' => true]];

        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->getSheet()->getDelegate()->getStyle('A1:AK1')->getFont()->setName('Calibri')->setSize(15);
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(17);
                $event->sheet->getDelegate()->getStyle('A1:AK1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle('A1:AK1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF17a2b8');
                foreach ($this->coloumns() as $charachter) {
                    $event->sheet->getDelegate()->getColumnDimension($charachter)->setWidth(30);
                }
            },
            ];
    }


    public function coloumns()
    {
        return ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', 'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK'];
    }

    public function coloumnvisabilty()
    {
        $arrvisability = [];
        $columns = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        foreach($this->visibleColumns as $key => $elem){
           array_push($arrvisability,$columns[$key]);
        }
        return $arrvisability;
    }
}
