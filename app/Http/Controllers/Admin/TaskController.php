<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaskRequest;
use App\Http\Resources\Admin\HistoryResource;
use App\Http\Resources\Admin\TasksResource;
use App\Imports\TaskImport;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function index(){
        return view('admin.dashboard.tasks.index');
    }
    
    public function create(){
        return view('admin.dashboard.tasks.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        Task::create($request->validate());
        if($request->ajax()){
            return response()->json(['status'=>true,'message'=>'Task add successfully'],200);
        }else{
            return redirect()->route('dashboard.tasks.index')->with(['successful_message' => 'Task Added successfully']);
        }
    }

    public function getTasks(){
        $tasks = Auth::user()->role == 'admin' ? Task::all() : Task::where('user_id',Auth::id())->get();
        $tasks = TasksResource::collection($tasks);
        return datatables($tasks)->make(true);
    }

    public function show(){
        
    }
    
    public function edit(Task $task){
       
        if($task->assign_status == 0){

            $assigning_to = Admin::where('role','operations')->select('id','name')->get();
            
        }
        if($task->assign_status == 1){

            $assigning_to = Status::where('type','operation')->select('id','name')->get();
        }
        
        $task['assign_to'] = $task->assign_status == 0 ? $task->user_id : $task->status_id;
       
        
        $input = [
            'task' => $task,
            'assigns' => $assigning_to->pluck('name', 'id')
        ];

        return view('admin.dashboard.tasks.edit', $input);
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        
        if($request->ajax()){
            return response()->json(['status'=>true,'message'=>'Task Updated successfully'],200);
        }else{
            return redirect()->route('dashboard.tasks.index')->with(['successful_message' => 'Task Updated successfully']);
        }
        
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Request $request, $id)
    {
        $status = $request->status == 'true' ? 0 : 1; 
        $task = Task::find($id);
        $task->update([ 'status' => $status]);
        return response()->json(['status'=>true,'message'=>'Task Updated successfully'],200);
        
    }

    public function getAssignedStatus($status= null){
        $search = request()->search;
        if($search == ''){
            
            if(request('assign_status') == 0)
                $assigning_to = Admin::where('role','operations')->select('id','name')->get();
            if(request('assign_status') == 1)
                $assigning_to = Status::where('type','operation')->select('id','name')->get();
                
         }else{
            
            if(request('assign_status') == 0)
                $assigning_to = Admin::where('role','operations')->where('name', 'like', '%' .$search . '%')->limit(10)->select('id','name')->get();
            if(request('assign_status') == 1)
                $assigning_to = Status::where('type','operation')->where('name', 'like', '%' .$search . '%')->limit(10)->select('id','name')->get();
            // $status=Status::where('type','influencer')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(10)->get();

        }
        
        return response()->json(['status'=>true,'data'=>$assigning_to],200);
    }

    public function destroy($id)
    {
        Task::find($id)->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }


    public function import(Request $request)
    {
       
        try{
     
            Excel::import(new TaskImport(),$request->file);
            return redirect()->route('dashboard.tasks.index')->with(['successful_message' => 'Task Imported successfully']);
        }catch ( ValidationException $e ){
           
            return back()->withErrors($e->errors());
        }
    }
    public function bulkDelete(){
      $tasks =  Task::whereIn('id',request()->id)->delete();
      return $tasks;
    }

    public function editAll(){
       $task =  Task::whereIn('id',request()->selectedIds);
       $task->update(request()->except('selectedIds'));
       return response()->json(['status'=>'success','message'=> 'message Task Updated Successfully']);
    }

}
