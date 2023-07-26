<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeDetailInfluencerRequest;
use App\Models\Influencer;
use App\Models\InfluencerChangeDetail;
use Illuminate\Http\Request;

class ChangeDetailInfluencerController extends Controller
{
    public function submit_influ_change_details(ChangeDetailInfluencerRequest $request){
          InfluencerChangeDetail::updateOrCreate(['influencer_id'=>(int)$request->influencer_id],$request->all());
        return response()->json(['msg'=>'Change Success','status'=>true],200);

    }
}
