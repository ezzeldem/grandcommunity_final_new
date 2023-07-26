<?php

namespace App\Exports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminExport implements FromCollection,WithHeadings

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
        $admins =  Admin::where('role','admin')->get();

        if (count($this->selectedRows) > 0) {
            $admins = $admins->whereIn('id',$this->selectedRows);
        }
        $data = $admins->transform(function ($q){
            return[
                'name'=>$q->name,
                'email'=>$q->email,
                'username'=>$q->username,
                'image'=>$q->image,
                'status'=>$q->active?'active':'inactive',
//                'country'=>@$q->country->name??'not found'
            ];
        });
        return $data;
    }

    public function headings(): array
    {
        return ['name', 'email', 'username', 'image', 'status',/*'country'*/];
    }
}
