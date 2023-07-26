<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OperaionExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommunityRequest;
use App\Imports\OperationsImport;
use App\Models\Admin;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Role;
use App\Models\Task;

class CommunityController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read community|create community|update community|delete community', ['only' => ['index','show','export']]);
        $this->middleware('permission:create community', ['only' => ['create','store','import']]);
        $this->middleware('permission:update community', ['only' => ['edit','update','statusToggle','edit_all']]);
        $this->middleware('permission:delete community', ['only' => ['destroy','bulkDelete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics['totalCommunity'] = ['title'=>'Total Community','count'=>Admin::where('role','Community')->orWhere('role','superCommunity')->count(),'icon'=>'fab fa-bandcamp'];
        $statistics['activeCommunity'] = ['title'=>'Active Community','count'=>Admin::where('role','Community')->orWhere('role','superCommunity')->where('active',"1")->count(),'icon'=>'fas fa-toggle-on'];
        $statistics['inactiveCommunity'] = ['title'=>'Inactive Community','count'=>Admin::where('role','Community')->orWhere('role','superCommunity')->where('active',"0")->count(),'icon'=>'fas fa-toggle-off'];
        return view('admin.dashboard.communities.index',compact('statistics'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function getCommunities(){
        if(\request()->hasHeader('auth-id') && \request()->header('auth-id') == auth()->id()){
            $communities = Admin::ofDashboardFilter(\request()->merge(['role'=>'community']))
                ->orderBy('updated_at','desc')->get();
            $communities->map(function($communities){
                $communities['active_data'] = ['id'=>$communities->id,'active'=>$communities->active];
            });
            return datatables($communities)->make(true);
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
        return view('admin.dashboard.communities.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CommunityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommunityRequest $request)
    {
        $inputs = $request->except('_token');
        $inputs['role'] = 'community';
        $community = Admin::create($inputs);
        $role = Role::where('id',$request['role_id'])->first();
        if(!$role)
            return redirect()->route('dashboard.community.index')->with(['error_message' => 'can not found role']);
        $permissions = $role->permissions;
        $community->syncRoles($role);
        $community->syncPermissions($permissions);
        return redirect()->route('dashboard.community.index')->with(['successful_message' => 'User Stored successfully']);
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
     * @param  Admin $community
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $community)
    {
        if($community->role!='community'){
            return redirect()->route('dashboard.community.index')->with(['error_message' => 'member not belong to this role']);
        }
        return view('admin.dashboard.communities.edit',compact('community'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CommunityRequest  $request
     * @param  Admin $community
     * @return \Illuminate\Http\Response
     */
    public function update(CommunityRequest $request, Admin $community)
    {
        if($community->role!='community'){
            return redirect()->route('dashboard.community.index')->with(['error_message' => 'member not belong to this role']);
        }
        $inputs = $request->except(['_token','_method']);
        $isSuperAdmin = $community->roles()->where('name','superCommunity')->exists();
        if($community->id == auth()->user()->id && $isSuperAdmin){
            $request['role_id'] = @auth()->user()->roles()->first()->id?:'';
        }
        $role = Role::where('id',$request['role_id'])->first();
        if(!$role)
            return redirect()->route('dashboard.community.index')->with(['error_message' => 'can not found role']);
        $community->syncRoles($role);
        $permissions = $role->permissions;
        $community->syncPermissions($permissions);
        $community->update($inputs);
        return redirect()->route('dashboard.community.index')->with(['successful_message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Admin $community
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $community)
    {
        if($community->role!='community'){
            return redirect()->route('dashboard.community.index')->with(['error_message' => 'member not belong to this role']);
        }
        $community->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request){
        Admin::where('role','community')->whereIn('id',$request['id'])->where('id','!=',auth()->id())->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }
    public function edit_all(Request $request){
        edit_all($request,'community');
        return response()->json(['status'=>true, 'data'=>'data', 'message'=>'Update successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        Excel::import(new OperationsImport(), $request->file);
        return redirect()->route('dashboard.community.index')->with(['successful_message' => 'data inserted successfully']);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(){
        return Excel::download(new OperaionExport(), 'communities.xlsx');
    }

    /**
     * @param Admin $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusToggle(Admin $community){
        if($community->active){
            $community->update(['active'=>0]);
            return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
        }
        else{
            $community->update(['active'=>1]);
            return response()->json(['status'=>true,'active'=>true,'message'=>'change successfully']);
        }
    }
}
