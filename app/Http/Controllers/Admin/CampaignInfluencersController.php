<?php

namespace App\Http\Controllers\Admin;

use Psy\Util\Str;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\Campaign;
use App\Models\Influencer;
use Illuminate\Http\Request;
use App\Imports\pendingImport;
use App\Models\CampaignComplaint;
use App\Imports\ChickInListImport;
use App\Models\CampaignInfluencer;
use Illuminate\Support\Facades\DB;
use App\Imports\ConfirmationImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CampaignInfluencerVisit;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Support\Facades\Validator;
use App\Imports\AddInfluencerToCampImport;
use Yajra\DataTables\Html\Editor\Fields\Field;
use App\Http\Requests\Admin\CampaignQrSecretRequest;

class CampaignInfluencersController extends Controller
{


    public function __construct()
    {
        $this->middleware('permission:update campaigns', ['only' => ['generateCodes']]);
        $this->middleware('permission:delete campaigns', ['only' => ['destroy', 'bulkDelete']]);
    }

    public function destroy(CampaignInfluencer $campaign_influ)
    {
        $campaign_influ->delete();
        return response()->json(['status' => true, 'message' => 'Deleted successfully!'], 200);
    }
    //where remove Influencer where status == 3
    public function updateInfluencerStatusVisit(CampaignInfluencer $campaign_influ)
    {
        if ($campaign_influ->status == 3) {
            $campaign_influ->update(['status' => 1]);
            return response()->json(['status' => true, 'message' => 'deleted successfully'], 200);
        }
        return response()->json(['status' => true, 'message' => 'deleted successfully'], 200);
        // $campaign_influ->delete();
    }


    public function updateinf(CampaignInfluencer $campaign_influ)
    {

        if ($campaign_influ->status && $campaign_influ->status == 3) {
            $campaign_influ->update(['status' => 0]);
        }

        return response()->json(['status' => true, 'message' => 'deleted successfully'], 200);
    }
    public function bulkupdateinfluncer(Request $request)
    {
        CampaignInfluencer::whereIn('id', $request['id'])->update(['status' => 1]);
        return response()->json(['status' => true, 'message' => 'deleted successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        CampaignInfluencer::whereIn('id', $request['id'])->delete();
        return response()->json(['status' => true, 'message' => 'deleted successfully'], 200);
    }


    /**
     * @param CampaignQrSecretRequest $request
     */
    public function generateCodes(Request $request)
    {

        $campaignInfluencers = CampaignInfluencer::whereIn('id', $request['users_list'])->get();
        foreach ($campaignInfluencers as $campaignInfluencer) {
            $array = (isset($request['is_test']) && $request['is_test'] == 'on') ? $this->checkCodeType($request['generate_types'], $campaignInfluencer, true)
                : $this->checkCodeType($request['generate_types'], $campaignInfluencer);
            $array['qrcode_valid_times'] = $request['qrcode_valid_times'];
            $array['visit_or_delivery_date'] = $request['visit_or_delivery_date'];
            $campaignInfluencer->update($array);
        }
        return response()->json(['status' => true, 'message' => 'generated successfully'], 200);
    }

    /**
     * @param $generate_types
     * @param $campaignInfluencer
     * @return array
     */
    private function checkCodeType($generate_types, $campaignInfluencer, $generate_test = false): array
    {
        $updateArray = [];
        if (in_array('secret', $generate_types) && in_array('qr', $generate_types)) {
            $updateArray = [
                'influ_code' => generateRandomCode(),
                'qr_code' => generateQrcode($campaignInfluencer?->influencer),
            ];
            if ($generate_test) {
                $updateArray['test_influ_code'] = generateRandomCode();
                $updateArray['test_qr_code'] =  generateQrcode($campaignInfluencer?->influencer, true);
            }
        } elseif (in_array('qr', $generate_types)) {
            $updateArray = ['qr_code' => generateQrcode($campaignInfluencer?->influencer)];
            if ($generate_test)
                $updateArray['test_qr_code'] =  generateQrcode($campaignInfluencer?->influencer, true);
        } elseif (in_array('secret', $generate_types)) {
            $updateArray = ['influ_code' => generateRandomCode()];

            if ($generate_test)
                $updateArray['test_influ_code'] = generateRandomCode();
        }
        return $updateArray;
    }


    public function pendingimport($status, Request $request)
    {
        $message_success = '';
        if ($status == 'Confirmation') {
            $cc = new ConfirmationImport($request, $dd = null);
            $done =  Excel::import($cc, $request->file);
            $message_success = $cc->messages_success;
        } else {

            $cc = new ChickInListImport($request, $dd = null);
            Excel::import($cc, $request->file);
            $message_success = $cc->messages_success;
        }
        return response()->json(['status' => true, 'message' => $message_success], 200);
    }


    public function influeStatus(Request $request)
    {

        $campaignInfluencers = CampaignInfluencer::whereIn('id', $request['users_list']);
        if ($request->status_camp == 2) {
            $campaignInfluencers->update(['status' => $request->status_camp, 'branch_id' => $request->branch_id, 'visit_or_delivery_date' => $request->checkindate]);
            $countSuccess = null;
            $countFail = null;
            $arr = [];
            foreach ($campaignInfluencers->get() as $camp_influe) {

                $influencer_visit_last = CampaignInfluencerVisit::where('campaign_influencer_id', $camp_influe->id)->latest()->first();
                $diff_in_minutes = 20;
                if ($influencer_visit_last) {
                    $now = \Carbon\Carbon::now();
                    $from = \Carbon\Carbon::parse($influencer_visit_last->actual_date);
                    $diff_in_minutes = $now->diffInMinutes($from);
                }
                if ($diff_in_minutes > 10) //10 min
                {

                    $influencer_visit = CampaignInfluencerVisit::where('campaign_influencer_id', $camp_influe->id)->count();
                    $scan_type = 0;
                    $visitDate = CampaignInfluencerVisit::create([
                        'campaign_influencer_id' => $camp_influe->id,
                        'used_code_type' => $scan_type,
                        'actual_date' => \Carbon\Carbon::now(),
                        'no_of_companions' => $request->num_guest ?? 0,
                        'branch_id' => $request->branch_id,
                        'comment' => $request->note,
                        'status' => 2,
                        'incorrect' => ($influencer_visit > $camp_influe->qrcode_valid_times) ? 1 : 0
                    ]);
                    Db::commit();
                    $countSuccess = $countSuccess + 1;
                    array_push($arr, ['visitDate' => Carbon::parse($visitDate->actual_date), "successCount" => $countSuccess, 'message' => 'success']);
                } else {
                    $countFail = $countFail + 1;
                    array_push($arr, ['visitDate' => 'null', "failCount" => $countFail, 'message' => 'Sorry... But The Code Already Used Try Again After 10 Minute number Fail =']);
                }
            }
            return response()->json(['status' => true, 'data' => $arr]);
        } else {
            $campaignInfluencers->update(['status' => $request->status_camp, 'reason' => $request->reason]);
        }
        return response()->json(['status' => true, 'message' => 'Updated successfully'], 200);
    }



    public function confirm_status(Request $request)
    {
        if ($request->has('coverage_status') && count($request->coverage_status) > 0) {
            $coverage_status = implode(',', $request->coverage_status);
        }

        $campaignInfluencers = CampaignInfluencer::whereIn('id', $request['users_list']);
        $campaignInfluencers->update(['invetaion' => $request->invetaion, 'confirmation_date' => $request->confirm_date, 'brief' => $request->brief, 'branch_id' => $request->branch, 'status' => 1, 'coverage_date' => ($request->coverage_date) ?? Null]);
        return response()->json(['status' => true, 'message' => 'Updated successfully'], 200);
    }

    public function missed_visit(Request $request)
    {

        $campaignInfluencers = CampaignInfluencer::whereIn('id', $request['users_list']);
        $campaignInfluencers->update(['status' => 3, 'missed_visit_date' => $request->missed_visit_date, 'brief' => $request->brief, 'branch_id' => $request->branch, 'coverage' => $request->coverage_status, 'coverage_date' => ($request->coverage_date) ?? Null]);
        return response()->json(['status' => true, 'message' => 'Updated successfully'], 200);
    }
    public function reject(Request $request)
    {
        $campaignInfluencers = CampaignInfluencer::whereIn('id', $request['users_list']);
        $campaignInfluencers->update(['status' => $request->status, 'brief' => $request->brief, 'branch_id' => $request->branch, 'reason' => $request->reason, 'coverage_date' => ($request->coverage_date) ?? Null]);
        return response()->json(['status' => true, 'message' => 'Updated successfully'], 200);
    }
    public function updateInflueStatusPending(Request $request)
    {
        $campaignInfluencers = CampaignInfluencer::whereIn('id', $request['users_list']);
        $campaignInfluencers->update(['status' => 0, 'confirmation_date' => Null, 'brief' => Null, 'coverage' => Null, 'coverage_date' => Null, 'branch_id' => Null]);
        foreach ($campaignInfluencers->get() as $camp_influe) {
            CampaignInfluencerVisit::where('campaign_influencer_id', $camp_influe->id)->delete();
        }
        return response()->json(['status' => true, 'message' => 'Updated successfully'], 200);
    }

    public function campaignInfluencersCounter(Request $request)
    {

        $campaign = Campaign::find($request->camp_id);
        $campaignInfluencersFirst = $campaign->campaignInfluencers()->first();
        $input = [
            'count_all' => $campaign->campaignInfluencers()->distinct('influencer_id')->count(),
            'count_confirmation' =>  $campaign->campaignInfluencers()->distinct('influencer_id')->where('status', 1)->count(),
            'count_visit' =>  $campaign->campaignInfluencers()->distinct('influencer_id')->where('status', 2)->count(),
            'count_not_visit' =>  $campaign->campaignInfluencers()->distinct('influencer_id')->where('status', 3)->count(),
            'count_cancel' =>  $campaign->campaignInfluencers()->distinct('influencer_id')->where('status', 4)->count(),
            'count_waiting' =>  $campaign->campaignInfluencers()->distinct('influencer_id')->where('status', 5)->count(),
            'count_incorrect' =>  $campaign->campaignInfluencers()->distinct('influencer_id')->where('status', 6)->count(),
            'count_coverage' =>   $campaign->campaignInfluencers()->distinct('influencer_id')->where('status', 7)->count(),
            'count_complaint' => 0
//            'count_complaint' => $campaignInfluencersFirst?$campaignInfluencersFirst->campaignComplaint()->count():0,

        ];

        return response()->json($input);
    }

    public function edit_coulmn(Request $request)
    {
        $id = array_keys($request->data)[0];
        $campInflue = CampaignInfluencer::where('id', $id)->first();
        $data = array_values($request->data)[0];
        if (isset($data['folderId'])) {
            if(!is_null($data['folderId'])){
                $campInflue->campaign()->update(['folderId' => $data['folderId']]);
                return response()->json(['status' => 'true', 'message' => 'done'], 200);
            }else{
                return response()->json(['status' => 'false', 'message' => 'please enter folderId '], 500);
            }

        }

        $datanew = [];
        if (isset($data['date'])) {
            if (!empty($data['date']) && !empty($data['branches'])) {
                $influencer_visit = CampaignInfluencerVisit::where('campaign_influencer_id', $campInflue->id)->count();
                $campInflue->update(['status' => 2, 'branch_id' => $data['branches']]);
                $visitDate = CampaignInfluencerVisit::create([
                    'campaign_influencer_id' => $campInflue->id,
                    'actual_date' => $data['date'],
                    'no_of_companions' => $request->num_guest ?? 0,
                    'branch_id' => $data['branches'],
                    'status' => 2,
                    'incorrect' => ($influencer_visit > $campInflue->qrcode_valid_times) ? 1 : 0
                ]);
                return response()->json(['status' => 'true', 'message' => 'done'], 200);
            } else {
                return response()->json(['status' => 'false', 'message' => 'please enter data '], 500);
            }
        }

        if (isset($data['clear_confirmation_date']) && $data['clear_confirmation_date'] == true) {
            $campInflue->update(['status' => 0, 'confirmation_date' => null, 'branch_id' => null, 'confirmation_start_time' => null, 'confirmation_end_time' => null]);
            return response()->json(['status' => 'true', 'message' => 'done'], 200);
        }

        if (isset($data['confirmation_date'])) {
            if (!empty($data['confirmation_date'])) {
                if(empty($data['branches'])){
                    return response()->json(['status' => 'false', 'message' => 'Please select branch '], 500);
                }

                if(empty($data['confirmation_start_time']) || empty($data['confirmation_end_time'])){
                    return response()->json(['status' => 'false', 'message' => 'Start time and end time is required. '], 500);
                }

                $campaign = $campInflue->campaign;
                if(!$campaign){
                    return response()->json(['status' => 'false', 'message' => 'Something went wrong.'], 500);
                }

                $getCountCurrentDailyConfirmations = CampaignInfluencer::where('campaign_id', $campInflue->campaign_id)->where('id', '!=', (int) $campInflue->id)->whereDate('confirmation_date', $data['confirmation_date'])->count();
                if($getCountCurrentDailyConfirmations >= (int) $campaign->daily_confirmation){
                    return response()->json(['status' => 'false', 'message' => 'The number of influencers for selected date has reached the allowed limit [Limit: '.$campaign->daily_confirmation.']'], 500);
                }

                if(CampaignInfluencer::where('campaign_id', $campInflue->campaign_id)->whereNotNull('confirmation_date')->where('id', '!=', (int) $campInflue->id)->count() >= (int) $campaign->daily_influencer){
                    return response()->json(['status' => 'false', 'message' => 'The number of influencers for this campaign has reached the allowed limit of target influencers [Limit: '.$campaign->daily_influencer.']'], 500);
                }

                if(strtotime("2000-01-01 ".$data['confirmation_start_time']) > strtotime("2000-01-01 ".$data['confirmation_end_time'])){
                    return response()->json(['status' => 'false', 'message' => 'Start time must be before End time. '], 500);
                }

                $confStartTimeTimestamp = strtotime($data['confirmation_date']." ".$data['confirmation_start_time']);
                $confEndTimeTimestamp = strtotime($data['confirmation_date']." ".$data['confirmation_end_time']);

                if(in_array((int) $campaign->campaign_type, [0, 3, 4])){
                    $campStartTimeTimestamp = strtotime($campaign->visit_start_date." ".$campaign->visit_from);
                    $campEndTimeTimestamp = strtotime($campaign->visit_end_date." ".$campaign->visit_to);
                }elseif (in_array((int) $campaign->campaign_type, [2])){
                    $campVisitStartTimeTimestamp = strtotime($campaign->visit_start_date." ".$campaign->visit_from);
                    $campVisitEndTimeTimestamp = strtotime($campaign->visit_end_date." ".$campaign->visit_to);
//                    $campDeliverStartTimeTimestamp = strtotime($campaign->deliver_start_date." ".$campaign->deliver_from);
//                    $campDeliverEndTimeTimestamp = strtotime($campaign->deliver_end_date." ".$campaign->deliver_to);

                    $campStartTimeTimestamp = $campVisitStartTimeTimestamp;
                    $campEndTimeTimestamp = $campVisitEndTimeTimestamp;
                }else{
                    $campStartTimeTimestamp = strtotime($campaign->deliver_start_date." ".$campaign->deliver_from);
                    $campEndTimeTimestamp = strtotime($campaign->deliver_end_date." ".$campaign->deliver_to);
                }

                if($confStartTimeTimestamp < $campStartTimeTimestamp || $confStartTimeTimestamp > $campEndTimeTimestamp || $confEndTimeTimestamp < $campStartTimeTimestamp || $confEndTimeTimestamp > $campEndTimeTimestamp){
                    return response()->json(['status' => 'false', 'message' => 'Confirmation start and end dates must be between campaign start and end time'], 500);
                }

//                $userCounts = CampaignInfluencer::select(DB::raw('DATE(confirmation_date) as confirmation_date'), DB::raw('count(*) as total'))
//                    ->groupBy('confirmation_date')
//                    ->where('campaign_id', (int) $campInflue->campaign_id)
//                    ->get();

                $campInflue->update(['status' => 1, 'confirmation_date' => $data['confirmation_date'], 'branch_id' => $data['branches'], 'confirmation_start_time' => $data['confirmation_start_time'], 'confirmation_end_time' => $data['confirmation_end_time']]);
                return response()->json(['status' => 'true', 'message' => 'done'], 200);
            } else {
                return response()->json(['status' => 'false', 'message' => 'please enter data '], 500);
            }
        }

        if (isset($data['coverage_date'])) {
            $campInflue->update(['coverage_date' => $data['coverage_date']]);
            return response()->json(['status' => 'true', 'message' => 'done'], 200);
        }

        if (isset($data['branches'])) {
            $campInflue->update(['branch_id' => $data['branches']]);
            return response()->json(['status' => 'true', 'message' => 'done'], 200);
        }

        if (isset($data['coverage_status'])) {

            $campInflue->update(['coverage' => $data['coverage_status']]);

            return response()->json(['status' => 'true', 'message' => 'done'], 200);
        }

        if (isset($data['brief'])) {
            $campInflue->update(['brief' => $data['brief']]);
            return response()->json(['status' => 'true', 'message' => 'done'], 200);
        }

        if (isset($data['rate'])) {
            $campInflue->update(['rate' => $data['rate'], 'comment_rate' => $data['comment_rate'] ?? '']);
            return response()->json(['status' => 'true', 'message' => 'done'], 200);
        }

        if (($data['branches'] == null && !in_array('date', $data)) || ($data['branches'] == null && !$data['confirmation_date'])) {
            return response()->json(['status' => 'false', 'message' => 'please enter data'], 500);
        }
    }

    public function addInfluencerImport(Request $request)
    {
        $message_success = '';
        $getAttr = new AddInfluencerToCampImport($request, $dd = null);
        Excel::import($getAttr, $request->file);
        $message_success = $getAttr->messages_success;
        return response()->json(['status' => true, 'message' => $message_success], 200);
    }

    public function CampaignComplaign()
    {
        $validator = Validator::make(request()->all(), [
            'note' => 'required',
        ]);
        if (count(request()->selectedIds) && !is_null(request()->note)) {
            $complaint = [];
            foreach (request()->selectedIds as $campaing) {
                $influencerIds =  CampaignInfluencer::where('id', $campaing)->pluck('influencer_id')->first();
                $complaint['camp_id'] = $campaing;
                $complaint['influe_id'] = $influencerIds;
                $complaint['date'] = request()->date;
                $complaint['note'] = request()->note;
                CampaignComplaint::create($complaint);
            }
            return response()->json(['message' => 'success', 'status' => true]);
        }
        return response()->json(['message' => 'faild', 'status' => false]);
    }
}
