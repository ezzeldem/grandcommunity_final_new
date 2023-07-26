<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SalesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalesRequest;
use App\Imports\SalesImport;
use App\Models\Admin;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Role;

class SalesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read sales|create sales|update sales|delete sales', ['only' => ['index','show','export']]);
        $this->middleware('permission:create sales', ['only' => ['create','store','import']]);
        $this->middleware('permission:update sales', ['only' => ['edit','update','statusToggle','edit_all']]);
        $this->middleware('permission:delete sales', ['only' => ['destroy','bulkDelete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics['totalSales'] = ['title'=>'Total Sales','id' => 'Total_Sales','count'=>Admin::where('role','sales')->count(),'icon'=>'fab fa-bandcamp'];
        $statistics['activeSales'] = ['title'=>'Active Sales','id' => 'Active_Sales','count'=>Admin::where('role','sales')->where('active',"1")->count(),'icon'=>'fas fa-toggle-on'];
        $statistics['inactiveSales'] = ['title'=>'Inactive Sales','id' => 'Inactive_Sales','count'=>Admin::where('role','sales')->where('active',"0")->count(),'icon'=>'fas fa-toggle-off'];
        return view('admin.dashboard.sales.index',compact('statistics'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function getSales(){
        if(\request()->hasHeader('auth-id') && \request()->header('auth-id') == auth()->id()){
            $operations = Admin::ofDashboardFilter(\request()->merge(['role'=>'sales']))
                ->orderBy('updated_at','desc')->get();
            $operations->map(function($operation){
                $operation['active_data'] = ['id'=>$operation->id,'active'=>$operation->active];
            });
            return datatables($operations)->make(true);
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
        return view('admin.dashboard.sales.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SalesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesRequest $request)
    {
        $inputs = $request->validated();
        $inputs['role'] = 'sales';
        $inputs['office_id'] = $request->office_id;
        $sales = Admin::create($inputs);
        $role = Role::where('id',$request['role_id'])->first();
        if(!$role)
            return redirect()->route('dashboard.sales.index')->with(['error_message' => 'can not found role']);
        $permissions = $role->permissions;
        $sales->syncRoles($role);
        $sales->syncPermissions($permissions);
        return redirect()->route('dashboard.sales.index')->with(['successful_message' => 'User Stored successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Admin $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $sale)
    {
        if($sale->role!='sales'){
            return redirect()->route('dashboard.sales.index')->with(['error_message' => 'member not belong to this role']);
        }
        return view('admin.dashboard.sales.edit',compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SalesRequest  $request
     * @param  Admin $sale
     * @return \Illuminate\Http\Response
     */
    public function update(SalesRequest $request, Admin $sale)
    {
        if($sale->role!='sales'){
            return redirect()->route('dashboard.sales.index')->with(['error_message' => 'member not belong to this role']);
        }
        $inputs = $request->except(['_token','_method']);
        $isSuperAdmin = $sale->roles()->where('name','superSales')->exists();
        if($sale->id == auth()->user()->id && $isSuperAdmin){
            $request['role_id'] = @auth()->user()->roles()->first()->id?:'';
        }
        $role = Role::where('id',$request['role_id'])->first();
        if(!$role)
            return redirect()->route('dashboard.sales.index')->with(['error_message' => 'can not found role']);
        $sale->syncRoles($role);
        $permissions = $role->permissions;
        $sale->syncPermissions($permissions);
        $sale->update($inputs);
        return redirect()->route('dashboard.sales.index')->with(['successful_message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Admin $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $sale)
    {
        if($sale->role!='sales'){
            return redirect()->route('dashboard.sales.index')->with(['error_message' => 'member not belong to this role']);
        }
        $sale->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request){
        Admin::where('role','sales')->whereIn('id',$request['id'])->where('id','!=',auth()->id())->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }
    public function edit_all(Request $request){
        edit_all($request,'sales');
        return response()->json(['status'=>true, 'data'=>'data', 'message'=>'Update successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
       
        Excel::import(new SalesImport(), $request->file);
        return redirect()->route('dashboard.sales.index')->with(['successful_message' => 'data inserted successfully']);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(){
        $query = request()->query();
    
        if (isset($query['selectedids'])) {
            $query = $query['selectedids'];
            $query = explode(',', $query);
            $ids = array_map('intval', $query);
            $admins = Admin::whereIn('id', $ids)->get();

            $selectedRows = [];

            foreach($admins as $row)
            {
                $selectedRows[] = $row->id;   
            }

            return Excel::download(new SalesExport($selectedRows), 'sales.xlsx');

        } else {
            return Excel::download(new SalesExport([]), 'sales.xlsx');
        }
        
    }

    /**
     * @param Admin $sales
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusToggle(Admin $sales){
        if($sales->active){
            $sales->update(['active'=>0]);
            return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
        }
        else{
            $sales->update(['active'=>1]);
            return response()->json(['status'=>true,'active'=>true,'message'=>'change successfully']);
        }
    }
}
