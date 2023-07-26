<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StatisticsRequest;
use App\Http\Resources\Admin\StatisticResource;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    function __construct()
    {
//        $this->middleware('permission:read statistics|create statistics|update statistics|delete statistics', ['only' => ['index','show','export']]);
//        $this->middleware('permission:create statistics', ['only' => ['create','store','import']]);
//        $this->middleware('permission:update statistics', ['only' => ['edit','update','statusToggle','edit_all']]);
//        $this->middleware('permission:delete statistics', ['only' => ['destroy','bulkDelete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.setting.statistics.index');
    }

    public function getStatistics(){
        if(\request()->hasHeader('auth-id') && \request()->header('auth-id') == auth()->id()){
            $filter = \request()->only(['status_val','country_val','start_date','end_date','brand_val','subbrand_val','city_val']);
            $statistics = StatisticResource::collection(Statistic::ofFilter($filter)->get());
            return datatables($statistics)->make(true);
        }else{
            return \response()->json(['status'=>false,'message'=>'unauthenticated'],401);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.setting.statistics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StatisticsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatisticsRequest $request)
    {
        $inputs = $request->except(['_token']);
        Statistic::create($inputs);
        return redirect()->route('dashboard.statistics.index')->with(['successful_message' => 'User Stored successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Statistic $statistic
     * @return \Illuminate\Http\Response
     */
    public function show(Statistic $statistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Statistic $statistic
     * @return \Illuminate\Http\Response
     */
    public function edit(Statistic $statistic)
    {
        return view('admin.dashboard.setting.statistics.edit',compact('statistic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StatisticsRequest  $request
     * @param  Statistic $statistic
     * @return \Illuminate\Http\Response
     */
    public function update(StatisticsRequest $request, Statistic $statistic)
    {
        $inputs = $request->except(['_token','_method']);
        $statistic->update($inputs);
        return redirect()->route('dashboard.statistics.index')->with(['successful_message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Statistic $statistic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statistic $statistic)
    {
        $statistic->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    public function statusToggle(Statistic $statistic){
        if($statistic->active==1){
            $statistic->update(['active'=>0]);
            return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
        }
        else{
            $statistic->update(['active'=>1]);
            return response()->json(['status'=>true,'active'=>true,'message'=>'change successfully']);
        }
    }

}
