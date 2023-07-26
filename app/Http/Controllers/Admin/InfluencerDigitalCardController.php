<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Influencer;
use App\Http\Traits\CustomCrypt;
Use Carbon\Carbon;

class InfluencerDigitalCardController extends Controller
{
    use CustomCrypt;
    /**index
     * @return mixed
     */
    public function index($username,$influencercode)
    {
		$code =(string) $this->decrypt(explode('_',$influencercode)[0]);
		$influencer = Influencer::where(['influ_code'=>$code,'insta_uname'=>$username])->first();
		if($influencer)
		   return view('admin.Influencer.digital_card',compact('influencer'));

		return redirect('/404');
    }


	public function NOTFound(){
		return view('admin.influencer.404');
	}

}
