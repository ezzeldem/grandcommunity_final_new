<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobsRequest;
use App\Http\Requests\Admin\MatchCampaignRequest;
use App\Http\Resources\Admin\JobsResource;
use App\Http\Resources\Admin\MatchCampaignResource;
use App\Models\Faq;
use App\Http\Requests\Admin\FaqRequest;
use App\Http\Resources\Admin\FaqResources;
use App\Models\Job;
use App\Models\matchCampaign;
use Illuminate\Http\Request;

class MatchCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.match-campaign.index');
    }

    /**datatable
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function getMatchCampaigns(){
        $matchCampaigns = MatchCampaignResource::collection(matchCampaign::all());
        return datatables($matchCampaigns)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.dashboard.match-campaign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MatchCampaignRequest $request)
    {
        matchCampaign::create($request->validated());
        return redirect()->route('dashboard.match-campaign.index')->with(['successful_message' => 'Match Campaign Stored successfully']);
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
    public function edit(matchCampaign $matchCampaign)
    {
        return view('admin.dashboard.match-campaign.edit',compact('matchCampaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(MatchCampaignRequest $request, matchCampaign $matchCampaign)
    {
        $matchCampaign->update($request->validated());
        return redirect()->route('dashboard.match-campaign.index')->with(['successful_message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(matchCampaign $matchCampaign)
    {
        $matchCampaign->delete();
        return response()->json(['status'=>true,'message'=>'Deleted successfully'],200);
    }

    /**toggleStatus
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id){
        $matchCampaign = matchCampaign::find($id);
        $matchCampaign->update(['status' => !$matchCampaign->status]);
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
