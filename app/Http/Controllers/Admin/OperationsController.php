<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OperaionExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OperationsRequest;
use App\Imports\OperationsImport;
use App\Models\Admin;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Role;

class OperationsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read operations|create operations|update operations|delete operations', ['only' => ['index','show','export']]);
        $this->middleware('permission:create operations', ['only' => ['create','store','import']]);
        $this->middleware('permission:update operations', ['only' => ['edit','update','statusToggle','edit_all']]);
        $this->middleware('permission:delete operations', ['only' => ['destroy','bulkDelete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics['totalOperations'] = ['title'=>'Total Operations','count'=>Admin::where('role','operations')->count(),'icon'=>'fab fa-bandcamp'];
        $statistics['activeOperations'] = ['title'=>'Active Operations','count'=>Admin::where('role','operations')->where('active',"1")->count(),'icon'=>'fas fa-toggle-on'];
        $statistics['inactiveOperations'] = ['title'=>'Inactive Operations','count'=>Admin::where('role','operations')->where('active',"0")->count(),'icon'=>'fas fa-toggle-off'];
        return view('admin.dashboard.operations.index',compact('statistics'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function getOperations(){
        if(\request()->hasHeader('auth-id') && \request()->header('auth-id') == auth()->id()){
            $operations = Admin::ofDashboardFilter(\request()->merge(['role'=>'operations']))
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
        return view('admin.dashboard.operations.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OperationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OperationsRequest $request)
    {
        $inputs = $request->except('_token');
        $inputs['role'] = 'operations';
        $operation = Admin::create($inputs);
        $role = Role::where('id',$request['role_id'])->first();
        if(!$role)
            return redirect()->route('dashboard.operations.index')->with(['error_message' => 'can not found role']);
        $permissions = $role->permissions;
        $operation->syncRoles($role);
        $operation->syncPermissions($permissions);
        return redirect()->route('dashboard.operations.index')->with(['successful_message' => 'User Stored successfully']);
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
     * @param  Admin $operation
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $operation)
    {
        if($operation->role!='operations'){
            return redirect()->route('dashboard.operations.index')->with(['error_message' => 'member not belong to this role']);
        }
        return view('admin.dashboard.operations.edit',compact('operation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OperationsRequest  $request
     * @param  Admin $operation
     * @return \Illuminate\Http\Response
     */
    public function update(OperationsRequest $request, Admin $operation)
    {
        if($operation->role!='operations'){
            return redirect()->route('dashboard.operations.index')->with(['error_message' => 'member not belong to this role']);
        }
        $inputs = $request->except(['_token','_method']);
        $isSuperAdmin = $operation->roles()->where('name','superOperations')->exists();
        if($operation->id == auth()->user()->id && $isSuperAdmin){
            $request['role_id'] = @auth()->user()->roles()->first()->id?:'';
        }
        $role = Role::where('id',$request['role_id'])->first();
        if(!$role)
            return redirect()->route('dashboard.operations.index')->with(['error_message' => 'can not found role']);
        $operation->syncRoles($role);
        $permissions = $role->permissions;
        $operation->syncPermissions($permissions);
        $operation->update($inputs);
        return redirect()->route('dashboard.operations.index')->with(['successful_message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Admin $operation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $operation)
    {
        if($operation->role!='operations'){
            return redirect()->route('dashboard.operations.index')->with(['error_message' => 'member not belong to this role']);
        }
        $operation->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request){
        Admin::where('role','operations')->whereIn('id',$request['id'])->where('id','!=',auth()->id())->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }
    public function edit_all(Request $request){
        edit_all($request,'operations');
        return response()->json(['status'=>true, 'data'=>'data', 'message'=>'Update successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        Excel::import(new OperationsImport(), $request->file);
        return redirect()->route('dashboard.operations.index')->with(['successful_message' => 'data inserted successfully']);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(){

        // get the query paramenter from url
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

            return Excel::download(new OperaionExport($selectedRows), 'operations.xlsx');

        } else {
            return Excel::download(new OperaionExport([]), 'operations.xlsx');
        }
    }
    

    /**
     * @param Admin $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusToggle(Admin $operation){
        if($operation->active){
            $operation->update(['active'=>0]);
            return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
        }
        else{
            $operation->update(['active'=>1]);
            return response()->json(['status'=>true,'active'=>true,'message'=>'change successfully']);
        }
    }
}
