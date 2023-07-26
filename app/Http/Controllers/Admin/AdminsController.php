<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Imports\AdminsImport;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class AdminsController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:read admins|create admins|update admins|delete admins', ['only' => ['index','show','export']]);
        $this->middleware('permission:create admins', ['only' => ['create','store','import']]);
        $this->middleware('permission:update admins', ['only' => ['edit','update','statusToggle','edit_all']]);
        $this->middleware('permission:delete admins', ['only' => ['destroy','bulkDelete']]);
    }
    /**
     * Display a listing of the Users.
     *
     * @return View
     */
    public function index()
    {
        $statistics['totalAdmins'] = [ 'id' =>'total_button','title'=>'Total Admins','count'=>Admin::where('role','admin')->count(),'icon'=>'fab fa-bandcamp'];
        $statistics['activeAdmins'] =  ['id'=>'active_button','title'=>'Active Admins',  'count'=>Admin::where('role','admin')->where('active',"1")->count(),'icon'=>'fas fa-toggle-on'];
        $statistics['inactiveAdmins'] = ['value'=>0,'id'=>'Inactive_button','title'=>'Inactive Admins','count'=>Admin::where('role','admin')->where('active',"0")->count(),'icon'=>'fas fa-toggle-off'];
        return view('admin.dashboard.admins.index',compact('statistics'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function getAdmins(){
        if(\request()->hasHeader('auth-id') && \request()->header('auth-id') == auth()->id()){
            $admins = Admin::ofDashboardFilter(\request()->merge(['role'=>'admin']))
                ->orderBy('updated_at','desc')->get();
            $admins->map(function($admin){
                $admin['active_data'] = ['id'=>$admin->id,'active'=>$admin->active];
            });
            return datatables($admins)->make(true);
        }else{
            return \response()->json(['status'=>false,'message'=>'unauthenticated'],401);
        }

    }
    /**
     * Show the form for creating a new User.
     *
     * @return View
     */
    public function create()
    {
        $roles = Role::get();

        return view('admin.dashboard.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdminRequest  $request
     * @return Response
     */
    public function store(AdminRequest $request)
    { 
        $inputs = $request->except('_token');
        $inputs['role'] = 'admin';
        $admin = Admin::create($inputs);
        $role = Role::where('id',$request['role_id'])->first();
        if(!$role)
            return redirect()->route('dashboard.operations.index')->with(['error_message' => 'can not found role']);
        $permissions = $role->permissions;
        $admin->syncRoles($role);
        $admin->syncPermissions($permissions);
        return redirect()->route('dashboard.admins.index')->with(['successful_message' => 'User Stored successfully']);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::where('id',$id)->first();
        return view('admin.dashboard.admins.edit',compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        if($admin->role!='admin'){
            return redirect()->route('dashboard.admins.index')->with(['error_message' => 'member not belong to this role']);
        }
        $inputs = $request->except(['_token','_method']);
        $isSuperAdmin = $admin->roles()->where('name','superAdmin')->exists();

        if($admin->id == auth()->user()->id && $isSuperAdmin){
            $request['role_id'] = @auth()->user()->roles()->first()->id?:'';
        }

        $role = Role::where('id',$request['role_id'])->first();
        if(!$role)
            return redirect()->route('dashboard.admins.index')->with(['error_message' => 'can not found role']);

        $admin->syncRoles($role);
        $permissions = $role->permissions;
        $admin->syncPermissions($permissions);
        $admin->update($inputs);
        return redirect()->route('dashboard.admins.index')->with(['successful_message' => 'Admin updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::where('id',$id)->where('role','admin')->first();

        if($admin)
            $admin->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request){
        Admin::where('role','admin')->whereIn('id',$request['id'])->where('id','!=',auth()->id())->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    public function edit_all(Request $request){
        edit_all($request,'admin');
        return response()->json(['status'=>true, 'data'=>'data', 'message'=>'Update successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        Excel::import(new AdminsImport(), $request->file);
        return redirect()->route('dashboard.admins.index')->with(['successful_message' => 'data inserted successfully']);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request){

        // get the query paramenter from url
        $query = request()->query();
    
        if (isset($query['selectedids'])) {
            $query = $query['selectedids'];
            // convert query to array of int split by ,
            $query = explode(',', $query);
            // convert array of string to array of int
            $ids = array_map('intval', $query);
            $admins = Admin::whereIn('id', $ids)->get();

            $selectedRows = [];

            foreach($admins as $row)
            {
                $selectedRows[] = $row->id;   
            }

            return Excel::download(new AdminExport($selectedRows), 'admins.xlsx');

        } else {
            return Excel::download(new AdminExport([]), 'admins.xlsx');
        }
    }
    
    /**
     * @param Admin $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusToggle(Admin $admin){
        if($admin->active){
            $admin->update(['active'=>0]);
            return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
        }
        else{
            $admin->update(['active'=>1]);
            return response()->json(['status'=>true,'active'=>true,'message'=>'change successfully']);
        }
    }
}
