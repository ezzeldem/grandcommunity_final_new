<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Http\Requests\Admin\FaqRequest;
use App\Http\Resources\Admin\FaqResources;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.faqs.index');
    }

    /**datatable
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function getFaqs(){
        $faqs = FaqResources::collection(Faq::all());
        return datatables($faqs)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.dashboard.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request)
    {
         $answer=["ar"=>$request->answer_ar,"en"=>$request->answer_en];
         $question=["ar"=>$request->question_ar,"en"=>$request->question_en];
        Faq::create(['answer'=>$answer,'question'=>$question]);
        return redirect()->route('dashboard.faqs.index')->with(['successful_message' => 'Faqs Stored successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('admin.dashboard.faqs.edit',compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $answer=["ar"=>$request->answer_ar,"en"=>$request->answer_en];
        $question=["ar"=>$request->question_ar,"en"=>$request->question_en];
        $faq->update(['answer'=>$answer,'question'=>$question]);
        return redirect()->route('dashboard.faqs.index')->with(['successful_message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    /**toggleStatus
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id){
        $faq = Faq::find($id);
        $faq->update(['status' => !$faq->status]);
        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
    }

    /**deleteAll
     * @param Request $request
     */
    public function bulckDelete(Request $request){
        Faq::whereIn('id',$request['id'])->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    public function bulckStatus(Request $request){
        $faqs = Faq::whereIn('id',$request['id'])->get();
        foreach ($faqs as $faq){
            $faq->update(['status' => !$faq->status]);
        }
        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
    }

}
