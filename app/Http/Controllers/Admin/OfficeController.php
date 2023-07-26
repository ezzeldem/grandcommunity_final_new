<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OfficesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OfficeRequest;
use App\Http\Resources\Admin\OfficeResource;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Office;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $input = [
            'countries' => Country::where('active', 1)->pluck('name','id')->toArray(),
        ];
        return view('admin.dashboard.offices.index', $input);
    }

    /**datatable
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function getOffices(){
        $Offices = OfficeResource::collection(Office::all());
        return datatables($Offices)->make(true);
    }

    public function getOffice(Request $request){
        $office = new OfficeResource(Office::find($request->id));
        return response()->json(['name'=>$office->name, 'country'=>$office->country_id, 'status'=> $office->status],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfficeRequest $request)
    {
        Office::create($request->validated());
        return response()->json(['status'=>true,'message'=>__('added successfully')],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(OfficeRequest $request, Office $office)
    {
        $office->update($request->validated());
        return response()->json(['status'=>true,'message'=>__('Updated successfully')],200);
    }

    public function statusToggle(Office $office){
        if($office->status == 1){
            $office->update(['status'=>0]);
            return response()->json(['status'=>true,'active'=>false,'message'=>'Change successfully']);
        }else{
            $office->update(['status'=>1]);
            return response()->json(['status'=>true,'active'=>true,'message'=>'Change successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        $office->delete();
    }

    public function export(){
        $query = request()->query();

        if (isset($query['selectedids'])) {
            $query = $query['selectedids'];
            $query = explode(',', $query);
            $ids = array_map('intval', $query);
            $offices = Office::whereIn('id', $ids)->get();

            $selectedRows = [];

            foreach($offices as $row)
            {
                $selectedRows[] = $row->id;
            }

            return Excel::download(new OfficesExport($selectedRows), 'offices.xlsx');

        } else {
            return Excel::download(new OfficesExport([]), 'offices.xlsx');
        }
    }

    public function editAll(Request $request){
        $selected_ids_new = explode(',',$request->selected_ids);
        if($request->input('bulk_active')){
            Office::whereIn('id',$selected_ids_new)->update([
                'status'=>($request->bulk_active==1)?'1':'0',
            ]);
        }

        return response()->json(['status'=>true,'data'=>'done','message'=>'Update successfully'],200);
     }
}
