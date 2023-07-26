<?php

namespace App\Imports;

use App\Http\Requests\Admin\ImportSubBrandsRequest;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Country;
use App\Models\Status;
use App\Models\Subbrand;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TaskImport implements ToCollection,WithHeadingRow
{

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row)
        {
            
          
       if($row['assign_status']  == 0){
        $assign_user = [];
        $assign_status = [];
        $array = explode(',', $row['user_id']);
        $assigning_to = Admin::where('role','operations')->whereIn('name',$array)->select('id')->get();
        foreach($assigning_to as $item){
            array_push($assign_user,$item->id);
        }
        
    }else{
        $array = explode(',', $row['status_id']);
        $assigning_to = Status::where('type','operation')->whereIn('name',$array)->select('id','name')->get();
        foreach($assigning_to as $item){
            array_push($assign_status,$item->id);
        }
        

       }
                Task::create([
                'description'=>$row['description'],
                'start_date'=>$row['start_date'],
                'end_date'=>$row['end_date'],
                'priority'=>$row['priority'],
                'status'=>$row['status'],
                'file'=>$row['file'],
                'status_id'=>($row['assign_status'] == 1 && count($assign_status) > 0 ) ? $assign_status :null,
                'user_id'=>($row['assign_status'] == 0 && count($assign_user) > 0 )? $assign_user :null,
                'assign_status'=>$row['assign_status'],
                ]);

        }

    }
 

  
}





