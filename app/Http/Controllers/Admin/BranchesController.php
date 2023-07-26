<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BranchExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BranchesRequest;
use App\Http\Resources\Admin\BranchResource;
use App\Imports\BranchsImport;
use App\Models\Branch;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BranchesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read branches|create branches|update branches|delete branches', ['only' => ['index','show','export']]);
        $this->middleware('permission:create branches', ['only' => ['create','store','import']]);
        $this->middleware('permission:update branches', ['only' => ['edit','update','statusToggle','edit_all']]);
        $this->middleware('permission:delete branches', ['only' => ['destroy','bulkDelete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics['totalBranches'] = ['id'=>'totalBranches','title'=>'Total Branches','count'=>Branch::count(),'icon'=>'fab fa-bandcamp'];
        $statistics['activeBranches'] = ['id'=>'activeBranches','title'=>'Active Branches','count'=>Branch::where('status',"1")->count(),'icon'=>'fas fa-toggle-on'];
        $statistics['inactiveBranches'] = ['id'=>'inactiveBranches','title'=>'Inactive Branches','count'=>Branch::where('status',"0")->count(),'icon'=>'fas fa-toggle-off'];
        return view('admin.dashboard.branches.index',compact('statistics'));
    }

    public function getBranches(){
        if(\request()->hasHeader('auth-id') && \request()->header('auth-id') == auth()->id()){
            $filter = \request()->only(['status_val','country_val','start_date','end_date','brand_val','subbrand_val','city_val']);
            $branches = BranchResource::collection(Branch::ofFilter($filter)->orderBy('created_at','desc')->get());
            return datatables($branches)->make(true);
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
        return view('admin.dashboard.branches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BranchesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchesRequest $request)
    {
        $inputs = $request->except(['_token']);
        Branch::create($inputs);
        return redirect()->route('dashboard.branches.index')->with(['successful_message' => 'User Stored successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        return view('admin.dashboard.branches.edit',compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BranchesRequest  $request
     * @param  Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function update(BranchesRequest $request, Branch $branch)
    {
        $inputs = $request->except(['_token','_method']);
        $branch->update($inputs);
        return redirect()->route('dashboard.branches.index')->with(['successful_message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request){
        if(!$request->has('ids')){
            return response()->json(['status'=>false,'message'=>'ids are required'],400);
        }
        Branch::whereIn('id',$request['ids'])->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        Excel::import(new BranchsImport(), $request->file);
        return redirect()->route('dashboard.branches.index')->with(['successful_message' => 'data inserted successfully']);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $id= -1;
        $visibleColumns =  ($request->get('visibleColumns') !== null ) ? array_map('strVal', explode(',', $request->get('visibleColumns'))) : [];
        $selected_ids = ($request->get('selected_ids') !== null) ? array_map('intval', explode(',', $request->get('selected_ids'))) :[];
        return Excel::download(new BranchExport($id,$visibleColumns,$selected_ids), 'branches.xlsx');
    }
    /**
     * @param Branch $branch
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusToggle(Branch $branch){
        if($branch->status){
            $branch->update(['status'=>0]);
            return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
        }
        else{
            $branch->update(['status'=>1]);
            return response()->json(['status'=>true,'active'=>true,'message'=>'change successfully']);
        }
    }

    public function edit_all(Request $request){

        $selected_ids_new = explode(',',$request->selected_ids);
        if ($request->input('bulk_active')){
            Branch::whereIn('id',$selected_ids_new)->update([
                'status'=>($request->bulk_active==1)?'1':'0',
            ]);
        }if($request->input('bulk_country_id')){
            Branch::whereIn('id',$selected_ids_new)->update([
                'country_id'=>$request->bulk_country_id,
            ]);
        }
        return response()->json(['status'=>true,'data'=>'done','message'=>'Update successfully'],200);
    }
}
