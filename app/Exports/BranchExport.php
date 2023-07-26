<?php

namespace App\Exports;

use App\Models\Branch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BranchExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;
    protected $visibleColumns;
    protected $selected_ids;


    function __construct($id,$visibleColumns,$selected_ids) {
        $this->id = $id;
        $this->visibleColumns=$visibleColumns;
        $this->selected_ids=$selected_ids;
    }
    public function collection()
    {
        if($this->id != -1){
            $branches =  Branch::when(($this->selected_ids && !empty($this->selected_ids ))  , function ($q){return $q->whereIn('id', $this->selected_ids);})->where('brand_id',$this->id)->orderBy('created_at', 'desc')->get();
        }else{
            $branches =  Branch::when(($this->selected_ids && !empty($this->selected_ids ))  , function ($q){return $q->whereIn('id', $this->selected_ids);})->orderBy('created_at', 'desc')->get();
        }


        $data = $branches->transform(function ($q){
            return [
                'name'=>$q->name,
                'subbrand'=>@$q->subbrand->name??'not found',
                'country'=>@$q->country->name??'not found',
                'state'=>@$q->states->name??'..',
                'city'=>@$q->cities->name??'..',
                'status'=>$q->status?'active':'inactive',
                'created_at'=> $q->created_at,
                // 'brand_name'=>@$q->brand->name??'..',
            ];
        });
            return $data;
    }

    public function headings(): array
    {
        // if(!array_search('group_of_brand',$this->visibleColumns) && !array_search('brand_name',$this->visibleColumns) ){
        //     array_push($this->visibleColumns,'group_of_brand','brand_name');
        // }
        return $this->visibleColumns;

    }
}
