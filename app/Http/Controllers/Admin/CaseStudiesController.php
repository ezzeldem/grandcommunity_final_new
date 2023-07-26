<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CaseStudyRequest;
use App\Http\Resources\Admin\CaseStudies;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\CaseStudies as ModelsCaseStudies;
use App\Models\CaseStudyCategory;
use Illuminate\Http\Request;
use App\Models\CaseStudies as ModelCaseStudies;
use App\Models\QuestionsAndAnswer;
use Illuminate\Support\Facades\DB;

class CaseStudiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caseCategories = CaseStudyCategory::all();
        return view('admin.dashboard.case-studies.index',compact('caseCategories'));
    }

    public function get_campaigns(Request $request){
       $campaigns = Campaign::where('campaign_type',$request->type)->select('id', 'name')->get();
       return response()->json(['data' => $campaigns]);
    }

    public function get_campaign_brand(Request $request){
        $campaign = Campaign::where('id',$request->campaign)->first();
        $brand =$campaign->brand->insta_uname;
        return response()->json(['data' => $brand]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CaseStudyRequest $request)
    {
        $images = [];
        if($request->image){
            foreach ($request->image as $image){
                $file= $image;
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path('photos/case_studies'), $filename);
                array_push($images,$filename);
            }
        }
            $caseStudies =   ModelCaseStudies::create([
                'real'=>json_encode(['en'=>$request->real_en, 'ar'=>$request->real_ar]),
                'total_followers'=>$request->total_followers,
                'total_influencers'=>$request->total_influencers,
                'total_reals'=>$request->total_reals,
                'total_days'=>$request->total_days,
                'client_profile_link'=>$request->client_profile_link,
                'campaign_type'=>$request->campaign_type,
                'campaign_name'=>$request->campaign_name ?? '',
                'category_id'=>$request->category,
                'channels'=>json_encode($request->channel_data),
                'image'=>json_encode($images),
            ]);

            if($caseStudies){
                return redirect()->back()->with(['successful_message' => 'Case Studies Stored successfully']);
            }
            
        return redirect()->back()->with(['error_message' => 'Something went wrong, please try again later']);
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

    public function getCaseStudies(){
        $caseStudies = CaseStudies::collection(ModelsCaseStudies::all());
//        dd($caseStudies);
        return datatables($caseStudies)->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

    {
        $case=ModelsCaseStudies::findOrFail($id);

        $caseCategories = CaseStudyCategory::all();
        $all_campaigns = Campaign::all();
        $campaign = Campaign::where('id',$case->campaign_name)->first();

        $case->campaign_id =  $campaign->id;
         return view('admin.dashboard.case-studies.edit', compact('case','caseCategories', 'campaign', 'all_campaigns'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CaseStudyRequest $request, $id)
    {
        $caseStudies = ModelsCaseStudies::findOrFail($id);

        $images = [];

//        $campaign = Campaign::find($request->campaign_name);
        $caseStudies->update([
            'real'=>json_encode(['en'=>$request->real_en, 'ar'=>$request->real_ar]),
            'total_followers'=>$request->total_followers,
            'total_influencers'=>$request->total_influencers,
            'total_reals'=>$request->total_reals,
            'total_days'=>$request->total_days,
            'client_profile_link'=>$request->client_profile_link,
            'campaign_type'=>$request->campaign_type,
            'campaign_name'=>$request->campaign_name,
            'category_id'=>$request->category,
            'channels'=>json_encode($request->channel_data),
        ]);
        if($request->image){
            foreach ($request->image as $image){
                $file= $image;
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path('photos/case_studies'), $filename);
                array_push($images,$filename);
            }
            $caseStudies ->update(['image'=>json_encode($images)]);
        }
    return redirect()->route('dashboard.caseStudies.index')->with(['successful_message' => 'Case Studies updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $case = ModelsCaseStudies::find($id);
        if($case){
            $case->delete();
        }
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

}