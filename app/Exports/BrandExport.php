<?php

namespace App\Exports;

use App\Models\Brand;
use App\Models\Country;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BrandExport implements FromCollection,WithHeadings
{
    protected $visibleColumns;
    protected $selectedRows;
    protected $requestFilter;

    public function __construct($selectedRows, $visibleColumns, $requestFilter = null)
    {
        $this->selectedRows = $selectedRows;
        $this->visibleColumns = $visibleColumns;
        $this->requestFilter = $requestFilter;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $brands = Brand::select('brands.id','brands.expirations_date','brands.status','brands.insta_uname','brands.created_at','brands.user_id','brands.country_id','brands.step','users.user_name')->join('users', 'brands.user_id', '=', 'users.id')->when( ($this->selectedRows && !empty($this->selectedRows ))  , function ($q){return $q->whereIn('brands.id', $this->selectedRows);})->ofFilter($this->requestFilter)->get();
        $data = $brands->transform(function ($q){
            $countriesIds = [];
            if(is_array($q->country_id) && count($q->country_id) == count($q->country_id, COUNT_RECURSIVE)){
                $countriesIds = $q->country_id;
            }

            return[
            'user_name'=>$q->user?->user_name,
            'email'=>$q->user?->email,
            'image'=>$q->image,
            'whatsapp'=>$q->code_whats.$q->whatsapp,
            'address'=>$q->address,
            'completed'=>(($q->whatsapp)&&($q->insta_uname))?'completed':'Not Completed',
            'expirations_date'=>$q->expirations_date,
            'countries'=>implode(', ',Country::whereIn('id', $countriesIds)->pluck('name')->toArray()),
            'insta_uname'=>$q->insta_uname,
            'facebook_uname'=>$q->facebook_uname,
            'tiktok_uname'=>$q->tiktok_uname,
            'snapchat_uname'=>$q->snapchat_uname,
            'twitter_uname'=>$q->twitter_uname,
            'website_uname'=>$q->website_uname,
            'status'=> ( $q->active == 0)? 'InActive' : (( $q->active == 1)? 'Active' : (( $q->active == 2) ? 'pending' : 'rejected' ) ),
            'expiration_date'=> $q->expirations_date,
            'created_at'=> $q->created_at
            ];
        });
        return $data;
    }

    public function headings(): array
    {
        array_push($this->visibleColumns,'user_name', 'email', 'image','whatsapp','address','completed','expirations_date','countries','insta_uname','facebook_uname','tiktok_uname','snapchat_uname','twitter_uname','website_uname','status','expiration_date','created_at');
        return $this->visibleColumns;
    }
}
