<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RolesRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class RolesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read roles|create roles|update roles|delete roles', ['only' => ['index','show']]);
        $this->middleware('permission:create roles', ['only' => ['create','store']]);
        $this->middleware('permission:update roles', ['only' => ['edit','update']]);
        $this->middleware('permission:delete roles', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role == 'sales') {
            $statistics['totalRoles'] = ['title' => 'Total Roles', 'count' => Role::where('type', 'sales')->count(), 'icon' => 'fab fa-bandcamp'];
        }elseif ($user->role == 'operations'){
            $statistics['totalRoles'] = ['title' => 'Total Roles', 'count' => Role::where('type', 'operations')->count(), 'icon' => 'fab fa-bandcamp'];
        }else{
            $statistics['totalRoles'] = ['title' => 'Total Roles', 'count' => Role::count(), 'icon' => 'fab fa-bandcamp'];
        }

        return  view('admin.dashboard.roles.index',compact('statistics'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function getRoles(){
        $user = auth()->user();
        $roles = Role::query();
        if(\request()->hasHeader('auth-id') && \request()->header('auth-id') == auth()->id()){
            if ($user->role == 'sales'){
                $roles = $roles->where('type','sales')->get();

            }elseif ($user->role == 'operations'){
                $roles = $roles->where('type','operations')->get();
                foreach($roles as $role){
                    if($role->user != null){
                        $role->user_name = $role->user->username;
                    }else{
                        $role->user_name = '--';
                    }
                }
            }else{
                if(in_array('superAdmin', $user->getRoleNames()->toArray())){

                    $roles =  $roles->with('user','parentRole:name,id')->get();
                    foreach($roles as $role){
                        ($role->user != null)?$role->user_name = $role->user->username:$role->user_name = '--';
                        ($role->parentRole != null)?$role->parent_roles = $role->parentRole->name:$role->parent_roles = 'Main';
                    }
                }else{
                    $roles = $roles->with('user')->where('user_id',auth()->id())->get();
                    foreach($roles as $role){
                        if($role->user != null){
                            $role->user_name = $role->user->username;
                        }else{
                            $role->user_name = '--';
                        }
                    }
                }
            }
            return datatables($roles)->make(true);
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
        return view('admin.dashboard.roles.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolesRequest $request)
    {
        $inputs = $request->except(['_token']);
        $user = auth()->user();
        if($user->role == 'admin')
            $role = Role::create(['name'=>$inputs['name'],'type'=>$inputs['type'],'guard_name'=>'web','user_id'=>$inputs['user_id'],'parent_role'=>($inputs['has_roles_id'])??0]);
        else
            $role = Role::create(['name'=>$inputs['name'],'type'=>$user->role,'guard_name'=>'web','user_id'=>$inputs['user_id'],'parent_role'=>($inputs['has_roles_id'])??0]);
        $role->givePermissionTo($inputs['permissions']);
        return redirect()->route('dashboard.roles.index')
            ->with('successful_message', __('added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return  view('admin.dashboard.roles.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RolesRequest  $request
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(RolesRequest $request, Role $role)
    {
        $inputs = $request->except(['_token','_method']);
        $user = auth()->user();
        if($user->role == 'admin')
            $role->update(['name'=>$inputs['name'],'type'=>$inputs['type'],'parent_role'=>($inputs['has_roles_id'])??0]);
        else
            $role->update(['name'=>$inputs['name'],'type'=>$user->role,'parent_role'=>($inputs['has_roles_id'])??0]);
        $role->syncPermissions($inputs['permissions']);
        $users = $role->users;
        foreach($users as $user)

            $user->syncPermissions($inputs['permissions']);
        return redirect()->route('dashboard.roles.index')
            ->with('successful_message', __('updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $user = auth()->user();
        if($user->roles()->where('id',$role->id)->exists()){
            return response()->json(['status'=>false,'message'=>__('can not delete this role')],200);
        }
        $admins = Admin::whereHas('roles', function (Builder $query) use ($role) {
                $query->where('name', $role->name)
                    ->where('type',$role->type);
            })->get();
        $permissions = $role->permissions;
        foreach ($admins as $admin)
            $admin->revokePermissionTo($permissions);
        $role->revokePermissionTo($permissions);
        $role->delete();
        return response()->json(['status'=>true,'message'=>__('deleted successfully')],200);
    }
    public function CheckRole($role){
        $role=Role::where('type',$role)->get();
        return response()->json(['status'=>true,'data'=>$role,'message'=>'return success']);
    }
}
