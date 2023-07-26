<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Country;
use App\Models\Setting;
use App\Models\Social;
use App\Models\Status;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read setting', ['only' => ['index', 'show']]);
        $this->middleware('permission:update setting', ['only' => ['edit', 'update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        return view('admin.dashboard.setting.main_setting.index', compact('setting'));
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
    public function store(SettingRequest $request)
    {
        // dd($request->all());
        $data = [
            'company_name' => $request->company_name,
            'company_name_ar' => $request->company_name_ar,
            'image' => $request->file('image'),
            'banner' => $request->file('banner'),
            'homepage_pic' => $request->file('homepage_pic'),
            'influencers_count' => $request->influencers_count,
            'campaign_count' => $request->campaign_count,
            'country_count' => $request->country_count,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'snapchat' => $request->snapchat,
            'linkedin' => $request->linkedin,
            'account_verification_limit' => $request->account_verification_limit,
            'google_play' => $request->google_play,
            'app_store' => $request->app_store,
            'phone' => $request->phone,
            'email' => $request->email,
            'location' => $request->location,
            'slogan' => $request->slogan,
            'slogan_ar' => $request->slogan_ar,
            'pinterset' => $request->pinterset,
            'youtube' => $request->youtube,
            'desc_ar' => $request->desc_ar,
            'desc_en' => $request->desc_en,
            'send_mail' => ($request->send_mail) ? 1 : 0,
        ];

        if ($request->id == null) {
            Setting::create(
                $data
            );
        } else {
            $setting = Setting::findOrFail($request->id);
            $setting->update(
                $data
            );
        }
        return redirect()->route('dashboard.setting.index')->with(['successful_message' => 'Setting Updated successfully']);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function controlHome()
    {
        $setting = Setting::first();
        $status = Status::whereType('influencer')->get();
        $countries = Country::whereActive(1)->paginate(5);
        $socials = Social::all();
        return view('admin.dashboard.setting.main_setting.controll-home', get_defined_vars());
    }
    public function saveupdated(Request $request)
    {

        $request->validate([
            'social_id' => 'required|integer|exists:App\Models\Social,id',
            'country_id' => 'required|array|exists:App\Models\Country,id',
            'status_id' =>  'required|integer|exists:App\Models\Status,id',
            'followers' => 'integer',
        ]);
        $setting = Setting::first();
        $setting->update($request->all());
        return redirect()->back()->with('successful_message', 'Data Adedd Successfully!');
    }
}