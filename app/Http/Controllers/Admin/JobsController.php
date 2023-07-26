<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobsRequest;
use App\Http\Resources\Admin\JobsResource;
use App\Models\Faq;
use App\Http\Requests\Admin\FaqRequest;
use App\Http\Resources\Admin\FaqResources;
use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.jobs.index');
    }

    /**datatable
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function getJobs(){
        $jobs = JobsResource::collection(Job::all());
        return datatables($jobs)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.dashboard.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobsRequest $request)
    {
        Job::create([
            'name'=>json_encode([ 'ar'=>$request->name_ar,'en'=>$request->name_en,]),
        ]);
        return redirect()->route('dashboard.jobs.index')->with(['successful_message' => 'Job Stored successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Job $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return view('admin.dashboard.jobs.edit',compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(JobsRequest $request, Job $job)
    {
        $job->update($request->validated());
        return redirect()->route('dashboard.jobs.index')->with(['successful_message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return response()->json(['status'=>true,'message'=>'Deleted successfully'],200);
    }

    /**toggleStatus
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id){
        $job = Job::find($id);
        $job->update(['status' => !$job->status]);
        return response()->json(['status'=>true,'active'=>false,'message'=>'Changed successfully']);
    }

    /**deleteAll
     * @param Request $request
     */
//    public function bulckDelete(Request $request){
//        Faq::whereIn('id',$request['id'])->delete();
//        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
//    }
//
//    public function bulckStatus(Request $request){
//        $faqs = Faq::whereIn('id',$request['id'])->get();
//        foreach ($faqs as $faq){
//            $faq->update(['status' => !$faq->status]);
//        }
//        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
//    }

}
