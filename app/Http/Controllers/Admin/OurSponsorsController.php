<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\OurSponsorsRequest;
use App\Models\Category;
use App\Models\OurSponsors;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OurSponsorsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read our_sponsors|create our_sponsors|update our_sponsors|delete our_sponsors', ['only' => ['index','show']]);
        $this->middleware('permission:create our_sponsors', ['only' => ['create','store']]);
        $this->middleware('permission:update our_sponsors', ['only' => ['edit','update','statusToggle','edit_all']]);
        $this->middleware('permission:delete our_sponsors', ['only' => ['destroy','delete_all']]);
    }

    public function index(){
        $statistics['totalOurSponsors'] = ['id'=>'Total_Sponsors', 'title'=>'Total Sponsors','count'=>OurSponsors::count(),'icon'=>'fab fa-bandcamp'];
        $statistics['activeOurSponsors'] = ['id'=>'Active_Sponsors', 'title'=>'Active Sponsors','count'=>OurSponsors::where('status',"1")->count(),'icon'=>'fas fa-toggle-on'];
        $statistics['inactiveOurSponsors'] = ['id'=>'Inactive_Sponsors', 'title'=>'Inactive Sponsors','count'=>OurSponsors::where('status',"0")->count(),'icon'=>'fas fa-toggle-off'];
        $categories = Category::all();
        return view('admin.dashboard.setting.our_sponsors.index',compact('statistics','categories'));
    }
    public function getOurSponsors(){
        $oursponsers = OurSponsors::offilter(request()->all())->get();
        $oursponsers->map(function($quary){
            $quary['active_data'] = ['id'=>$quary->id,'status'=>$quary->status];
            $quary['category_id'] = @$quary->category->title;
        });

        return datatables($oursponsers)->make(true);
    }
    public function edit($id){
        $our_sponsor=OurSponsors::findOrFail($id);
        return response()->json(['status'=>'true','data'=>$our_sponsor],200);
    }
    public function update(OurSponsorsRequest $request,$id){
        $our_sponsor=OurSponsors::findOrFail($id);
        $our_sponsor->update($request->all());
        return response()->json(['status'=>'true','data'=>'data'],200);
    }
    public function store(OurSponsorsRequest $request){
        OurSponsors::create($request->all());
        return response()->json(['status'=>'true','data'=>'data'],200);
    }
    public function destroy($id){
        OurSponsors::findOrFail($id)->delete();
        return response()->json(['status'=>'true','data'=>'data'],200);
    }
        public function statusToggle($id){
            $our_sponsor=OurSponsors::findOrFail($id);

            if($our_sponsor->status==0){

                $our_sponsor->update(['status'=>1]);
                return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
            }
            else{
                $our_sponsor->update(['status'=>0]);
                return response()->json(['status'=>true,'active'=>true,'message'=>'change successfully']);
            }
        }
    public function delete_all(Request $request){
        $selected_ids_new = explode(',',$request->selected_ids);

        $sponsors = OurSponsors::whereIn('id',$selected_ids_new)->get();
        if($sponsors){
            foreach ($sponsors as $sponsor){
                $sponsor->delete();
            }
        }
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);

    }
    public function edit_all(Request $request){

        $selected_ids_new = explode(',',$request->selected_ids);
        if ($request->input('bulk_active')){
            OurSponsors::whereIn('id',$selected_ids_new)->update([
                'status'=>($request->bulk_active==1)?'1':'0',
            ]);
        }
        return response()->json(['status'=>true,'data'=>'done','message'=>'Update successfully'],200);
    }
}
