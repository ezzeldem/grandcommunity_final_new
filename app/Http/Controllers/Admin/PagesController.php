<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Http\Resources\Admin\PagesResource;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PagesController extends Controller
{
    /**
     * Display a listing of the page.
     *
     * @return view
     */
    public function index()
    {
        $statistics['totalPages'] = ['id'=>'Total_Pages','title'=>'Total Pages','count'=>Page::count(),'icon'=>'fab fa-bandcamp'];
        $statistics['totalActivePages'] = ['id'=>'Active_Pages','title'=>'Active Pages','count'=>Page::whereStatus(1)->count(),'icon'=>'fas fa-toggle-off'];
        $statistics['totalInActivePages'] = ['id'=>'InActive_Pages','title'=>'InActive Pages','count'=>Page::whereStatus(0)->count(),'icon'=>'fas fa-toggle-on'];
        return view('admin.dashboard.setting.pages.index',  get_defined_vars());
    }

    /**
     * Show the form for creating a new page.
     *
     * @return view
     */
    public function create()
    {
        $routes =  [ ['route'=>route('dashboard.pages.index'),'name'=>'pages'] ];
        return view('admin.dashboard.setting.pages.create',  get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PageRequest  $request
     * @return Response
     */
    public function store(PageRequest $request)
    {
        try {
            DB::beginTransaction();
            $page = Page::create($request->validated());
            foreach($request->sub_title as $i => $title){
                $page->sections()->save(new Section([
                    'title' => handleInputLanguage($title),
                    'description' => handleInputLanguage($request['sub_description'][$i])
                ]));
            }       
            DB::commit();
            return redirect(route('dashboard.pages.index'))->with(['successful_message' => 'Page Stored successfully']);

        }catch (\Exception $ex){
            DB::rollBack();
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return view
     */
    public function edit(Page $page)
    {
        $routes =  [ ['route'=>route('dashboard.pages.index'),'name'=>'pages'] ];
        return view('admin.dashboard.setting.pages.edit',  get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PageRequest  $request
     * @param  Page $page
     * @return Response
     */
    public function update(PageRequest $request, Page $page)
    {
        $data = $request->validated();
        
        try {
        DB::beginTransaction();        
        foreach($request->sub_title as $i => $title){

            if(isset(request()->section_id[$i])){
                $check = $page->sections()->find(request()->section_id[$i]);
                // dd($check, $title, $request['sub_description'][2]);
                if($check->exists()){
                    $check->update([
                        'title' => handleInputLanguage($title),
                        'description' => handleInputLanguage($request['sub_description'][$i])
                    ]);
                }else{
                    $page->sections()->create([
                        'title' => handleInputLanguage($title),
                        'description' => handleInputLanguage($request['sub_description'][$i])
                    ]);
                }
            }else{
                $page->sections()->create([
                    'title' => handleInputLanguage($title),
                    'description' => handleInputLanguage($request['sub_description'][$i])
                ]);
            }
            
            
        }
        $page->update($data);
        DB::commit();
        return redirect(route('dashboard.pages.index'))->with(['successful_message' => 'Page Updated Successfully']);

        }catch (\Exception $ex){
            DB::rollBack();
        }

    }

    /**
     * Remove the specified resource from page.
     *
     * @param $page
     * @return Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    /**datatable
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function datatable(){
        $pages = PagesResource::collection(Page::ofFilter(request()->all())->orderBy('created_at','desc')->get());
        return datatables($pages)->make(true);
    }

    /**toggleStatus
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id){
        $page = Page::find($id);
        $page->update(['status' => !$page->status]);
        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
    }

    /**deleteAll
     * @param Request $request
     */
    public function bulckDelete(Request $request){
        Page::whereIn('id',$request['id'])->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    public function bulckStatus(Request $request){
        $pages = Page::whereIn('id',$request['id'])->get();
        foreach ($pages as $page){
            $page->update(['status' => !$page->status]);
        }
        return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
    }

    public function DeleteSection($id){
        $section = Section::find($id);
        $section->delete();
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }
}
