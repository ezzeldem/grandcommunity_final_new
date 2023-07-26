<?php

namespace App\Exports;

use App\Models\Admin;
use App\Models\Office;
use Maatwebsite\Excel\Concerns\FromCollection;

class OfficesExport implements FromCollection
{

    public function __construct($selectedRows)
    {
        $this->selectedRows = $selectedRows;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $offices =  Office::all();

        if (count($this->selectedRows) > 0) {
            $offices = $offices->whereIn('id',$this->selectedRows);
        }
        
        $data = $offices->transform(function ($q){
            return[
                'name'=>$q->name,
                'country'=>@$q->country->name??'not found',
                'status'=>$q->status?'active':'inactive',
            ];
        });
        return $data;
    }

    public function headings(): array
    {
        return ['name', 'country', 'status'];
    }
}
