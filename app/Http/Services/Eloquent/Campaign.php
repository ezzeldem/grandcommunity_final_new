<?php

namespace App\Http\Services\Eloquent;

use App\Http\Resources\Admin\CampaignResource;
use App\Http\Traits\GroupListTraits;
use App\Http\Traits\ResponseTrait;
use App\Models\BrancheCampaign;
use App\Models\Brand;
use App\Models\CampaignCheckList;
use App\Models\CampaignCountryFavourite;
use App\Models\BrandFav;
use App\Models\CampaignSecret;
use App\Models\City;
use App\Models\ComplimentCampaign;
use App\Models\Country;
use App\Models\GroupList;
use App\Models\InfluencerGroup;
use App\Models\LogCamp;
use App\Models\Status;
use App\Models\Subbrand;
use App\Models\Influencer;
use App\Models\CampaignInfluencer;
use \App\Models\Campaign as CampaignModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Campaign extends AbstractEloquent
{
    use ResponseTrait, GroupListTraits;

    public function campaignLog($campaignId)
    {
        $campaign = \App\Models\Campaign::find($campaignId);
        return view('admin.dashboard.campaign.campaignLog', compact('campaign'));
    }

    public function campaignLogAjax($request, $id)
    {
        $campaignLog = LogCamp::where('campaign_id', $id)->with(['campaign', 'admin', 'influencer'])->paginate($request['limit']);
        return response()->json(['data' => $campaignLog]);
    }
    public function getBrands()
    {
        $brands = Brand::where('status', 1)->select('id', 'name')->get();
        return $brands;
    }

    public function getCountries()
    {
        $countries = Country::where('active', 1)->get();
        return $countries;
    }

    public function getStates()
    {
        $country_ids = request('country_ids');
        $brand = Brand::find(\request('brand_id'));
        $countries = is_array($country_ids) ? $country_ids : explode(',', $country_ids);

        $subbrands = $brand->subbrands()->select('id', 'name')->where('status', 1)
            ->when($country_ids, function ($q) use ($countries, $brand) {
                $q->whereJsonContains('country_id', $countries[0]);
                for ($i = 1; $i < count($countries); $i++) {
                    $q->orWhereJsonContains('country_id', $countries[$i])
                        ->where('brand_id', $brand->id);
                }
            })->get();

        $branches = $brand->branchs()
            ->when((\request()->has('sub_brand_id') && \request('sub_brand_id') != null), function ($q) {
                $q->where('branches.status', 1)
                    ->where('branches.subbrand_id', \request('sub_brand_id'));
            })
            ->when((\request()->has('country_ids') && count(\request('country_ids'))), function ($q) {
                $q->where('branches.status', 1)
                    ->whereIn('branches.country_id', \request('country_ids'));
            })->get();

        $groups = GroupList::where('brand_id', \request('brand_id'))
            ->where(function ($q) use ($countries) {
                for ($i = 0; $i < count($countries); $i++) {
                    $q->orWhereJsonContains('country_id', $countries[$i]);
                }
            })
            ->where('sub_brand_id', \request('sub_brand_id'))->get();

        $input = [
            'groups' => $groups,
            'camp_id' => request('camp_id'),
        ];
        $returnHTML = view('admin.dashboard.campaign.countries-form', $input)->render();
        return ['html' => $returnHTML, 'branches' => $branches, 'subbrands' => $subbrands, 'groups' => $groups];
    }

    public function getStateCities($id)
    {
        $cities = City::where('state_id', (int) $id)->get();
        return $this->returnData('cities', $cities, 'State Cities Returned successfully');
    }

    public function getStatus()
    {
        $status = Status::where('type', 'campaign')->get();
        return $status;
    }

    public function getSubBrands($id)
    {
        $brand = Brand::find($id)->load(['subbrands', 'branchs', 'countries']);
        $selectedCountries = request('company_country_ids', []);
        $selectedSubBrand = request('company_sub_brand');
        $subBrands = [];
        $branches = [];

        if (count($selectedCountries) > 0) {
            $subBrands = $brand->subbrands()->where(function ($q2) use ($selectedCountries) {
                for ($i = 0; $i < count($selectedCountries); $i++) {
                    $q2->orWhereJsonContains('subbrands.country_id', $selectedCountries[$i]);
                }
            })->where('status', 1)->get();
        }

        if (count($selectedCountries) > 0 && $selectedSubBrand) {
            $branches = $brand->branchs()->whereIn('branches.country_id', $selectedCountries)->where('branches.subbrand_id', $selectedSubBrand)
                ->where('status', 1)->get();
        }

        $countries = $brand->countries()->has('states.cities')->get();
        $data = ['subBrands' => $subBrands, 'branches' => $branches, 'brand_phones' => $brand->phone, 'brand_whatsapp' => $brand->whatsapp, 'countries' => $countries];
        return $this->returnData('data', $data, 'data Returned successfully');
    }

    public function getSubBrandBranches($id)
    {
        $branches = Subbrand::find($id)->branches()->select('id', 'name')
            ->when((\request()->has('country_ids') && count(\request('country_ids'))), function ($q) {
                $q->where('branches.status', 1)
                    ->whereIn('branches.country_id', \request('country_ids'));
            })->get()->map(function ($branch) {
                if (\request()->has('camp_id') && \request('camp_id') != null) {
                    $branch['has_voucher'] = BrancheCampaign::where('campaign_id', \request('camp_id'))->where('branche_id', $branch->id)->where('has_compliment', 1)->exists();
                } else {
                    $branch['has_voucher'] = false;
                }
                return $branch;
            });
        $subBrands = Subbrand::find($id);
        $data = ['subBrands' => $subBrands, 'branches' => $branches];
        return $this->returnData('data', $data, 'branches Returned successfully');
    }

    /**
     * @param $data
     * @return mixed
     * create campaign
     */
    public function createCampaign($data, $branch, $branchesWithCompliment = [])
    {
        $model = new CampaignModel();
        if (array_key_exists('camp_brief', $data)) {
            $data['sub_brand_id'] = ($data['sub_brand_id']) ? $data['sub_brand_id'] : 0;
            foreach ($data['camp_brief'] as $i => $note) {
                $data['camp_brief'] = handleInputLanguage($note);
                if (isset($data['camp_note'][$i])) {
                    $data['camp_note'] = handleInputLanguage($data['camp_note'][$i]);
                }
                if (isset($data['camp_invetation'][$i])) {
                    $data['camp_invetation'] = handleInputLanguage($data['camp_invetation'][$i]);
                }
            }
        }

        $data['delivery_from'] = isset($data['deliver_from']) ? $data['deliver_from'] : null;
        $data['delivery_to'] = isset($data['deliver_to']) ? $data['deliver_to'] : null;
        $data['gender'] = isset($data['gender']) ? (string) $data['gender'] : null;
        $data['campaign_check_list'] = (isset($data['chicklist']) ? $data['chicklist'] : null);
        $data['compliment_branches'] = isset($data['compliment_branches']) ? $data['compliment_branches'] : [];
        $data['has_guest'] = isset($data['has_guest']) ? (int) $data['has_guest'] : 0;
        $data['guest_numbers'] = isset($data['guest_numbers']) ? $data['guest_numbers'] : 0;
        $data['target'] = isset($data['influencer_count']) ? $data['influencer_count'] : $data['target'] ?? 0;
        $data['influencer_per_day'] = isset($data['influencer_per_day']) ? $data['influencer_per_day'] : 0;
        $data['list_ids'] = isset($data['list_ids']) ? $data['list_ids'] : [];
        $data['compliment_type'] = isset($data['compliment_type']) ? $data['compliment_type'] : 0;
        $data['status'] = (isset($data['draft']) && $data['draft'] == 1) ? 5 : (isset($data['status']) ? $data['status'] : 0);

        $data['camp_id'] = $model->createCampId();

        if (isset($data['attached_files']) && is_array($data['attached_files'])) {
            $newFiles = $this->handleFileUploads($data['attached_files']);
            $data['attached_files'] = $newFiles;
        }

        $camp = $model->create($data);

        $this->addBranchesToCampaign($data, $camp, $branch, $branchesWithCompliment);
        return $camp->id;
    }

    public function addBranchesToCampaign($data, $campaign, $branches = [], $branchesWithCompliment = [])
    {

        $complimentData = [
            'voucher_expired_date' => null,
            'voucher_expired_time' => null,
            'voucher_amount' => null,
            'voucher_amount_currency' => null,
            'gift_image' => null,
            'gift_description' => null,
            'gift_amount' => null,
            'gift_amount_currency' => null,
        ];

        if (isset($data['campaign_type']) && in_array((int) $data['campaign_type'], [0, 1, 2])) {

            if (isset($data['compliment_type']) && in_array($data['compliment_type'], [1, 3])) {
                $complimentData['voucher_expired_date'] = $data["voucher_expired_date"] ?? null;
                $complimentData['voucher_expired_time'] = $data["voucher_expired_time"] ?? null;
                $complimentData['voucher_amount'] = $data["voucher_amount"] ?? null;
                $complimentData['voucher_amount_currency'] = $data["voucher_amount_currency"] ?? null;
            }

            if (isset($data['compliment_type']) && in_array($data['compliment_type'], [2, 3])) {
                $complimentCampaignEntity = $campaign->compliment;
                $existingFiles = $complimentCampaignEntity ? ($complimentCampaignEntity->gift_image ?: []) : [];
                $existingFiles = array_map(function ($file) {
                    return ['id' => $file['id'], 'name' => $file['name']];
                }, $existingFiles);

                $newFiles = [];
                if (isset($data['gift_image']) && is_array($data['gift_image'])) {
                    $newFiles = $this->handleFileUploads($data['gift_image']);
                }

                $mergedFiles = array_merge($existingFiles, $newFiles);
                $data['deleted_gift_image'] = $data['deleted_gift_image'] ?? [];
                $deletedIds = isset($data['deleted_gift_image']) && is_array($data['deleted_gift_image']) ? $data['deleted_gift_image'] : ($data['deleted_gift_image'] ? explode("||", (string) $data['deleted_gift_image']) : []);
                $mergedFiles = array_filter($mergedFiles, function ($file) use ($deletedIds) {
                    return !in_array(($file['id'] ?? ""), $deletedIds);
                });

                $complimentData['gift_image'] = $mergedFiles;

                $complimentData['gift_description'] = $data["gift_description"] ?? null;
                $complimentData['gift_amount'] = $data["gift_amount"] ?? null;
                $complimentData['gift_amount_currency'] = $data["gift_amount_currency"] ?? null;
            }

            ComplimentCampaign::updateOrCreate(['campaign_id' => $campaign->id], array_merge($complimentData, ['campaign_id' => $campaign->id]));

            $branchesWithCompliment = isset($data['compliment_type']) && in_array((int) $data['compliment_type'], [1, 2, 3]) ? $branchesWithCompliment : [];
        } else {
            $branchesWithCompliment = [];
            ComplimentCampaign::updateOrCreate(['campaign_id' => $campaign->id], array_merge($complimentData, ['campaign_id' => $campaign->id]));
        } //end campaign_type

        $syncBranchesList = [];
        if (is_array($branches)) {
            foreach ($branches as $branchId) {
                $has_compliment = isset($branchesWithCompliment) && in_array((int) $branchId, $branchesWithCompliment) ? 1 : 0;
                $syncBranchesList[(int) $branchId] = ['has_compliment' => $has_compliment, 'brand_id' => $campaign->brand_id, 'sub_brand_id' => $campaign->sub_brand_id];
            }
        }

        $campaign->branches()->sync($syncBranchesList);

        return true;
    }

    /**
     * @param $campaign
     * @param $data
     * add favourite list for each  country in campaign
     */
    public function campaignCountryFavourite($campaign, $data)
    {
        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $countries = Country::select('id', 'name')->whereIn('id', array_map('intval', $data['country_id']))->get();
            foreach ($countries as $key => $country) {
                $campaignFavCountry = CampaignCountryFavourite::updateOrCreate([
                    'country_id' => (int) $country->id,
                    'campaign_id' => $campaign->id,
                    'list_id' => 0,
                ], [
                    'campaign_id' => $campaign->id,
                    'country_id' => (int) $country->id,
                    'city_id' => @(int) $data['city_id'],
                    'list_id' => 0,
                ]);

                $data['campaign_id'] = $campaign->id;
                if (isset($data['campaign_type']) && in_array((int) $data['campaign_type'], [0, 1, 2]) && isset($data['secret']) && isset($data['permissions'])) {
                    $this->campaignFavCountriesSecrets($campaignFavCountry, $key, $data, $country);
                } else {
                    CampaignSecret::where('campaign_country_id', $campaignFavCountry->id)->delete();
                }
            }
            if (isset($data['list_ids']) && $data['list_ids'] != null) {
                foreach ($data['list_ids'] as $list) {
                    $this->campaignInfluencers($data, $list);
                }
            }
        }
    }

    private function campaignFavCountriesSecrets($campaignFavCountry, $key, $data, $country)
    {
        if (isset($data['secret']) && count($data['secret']) == count($data['permissions'])) {
            if (isset($data['secret'][$country->id])) {
                $brand_secret = CampaignSecret::updateOrCreate([
                    'campaign_country_id' => $campaignFavCountry->id,
                ], [
                    'campaign_country_id' => $campaignFavCountry->id,
                    'secret' => $data['secret'][$country->id], 'is_active' => 1,
                ]);
                $brand_secret->permissions()->sync($data['permissions'][$key]);
            }
        }
    }

    public function campaignInfluencers($data, $list)
    {
        $list_id = $list;
        $group_list = GroupList::find($list_id);
        if ($group_list) {
            $influencers = InfluencerGroup::with('influencer')->where('brand_id', $group_list->brand_id)->whereNull('deleted_at')->whereNull('group_deleted_at')->where('group_list_id', $group_list->id)->get();
            if (count($influencers) > 0) {
                $typesOfCamp = ($data['campaign_type'] == 0 || $data['campaign_type'] == 1) ? [(int) $data['campaign_type']] : [0, 1];
                foreach ($typesOfCamp as $campe_type) {
                    foreach ($influencers as $influencer) {
                        if ($influencer->influencer) {

                            $influencer->influencer->campaignInfluencer()->updateOrCreate([
                                'influencer_id' => $influencer->influencer->id,
                                'campaign_id' => $data['campaign_id'],
                                'country_id' => $influencer->influencer->country_id,
                                'campaign_type' => $campe_type,
                            ], [
                                'list_id' => $list_id,
                                'brand_id' => $group_list->brand_id,
                                // 'qr_code' => generateQrcode($influencer->influencer->user, $influencer->influencer->country_name),
                                // 'influ_code' => generateRandomCode(),
                                'status' => 0,
                                'take_campaign' => 1,
                                'qrcode_valid_times' => 1,
                            ]);
                        }
                    }
                }
            }
        }
    }

    /**
     * create secrets with permissions to brand
     * @param $request
     */
    public function brandSecret($request)
    {
        $brand = Brand::find($request['brand_id']);
        foreach ($request['secret'] as $key => $secret) {
            $brand_secret = $brand->secrets()->create(['secret' => $secret, 'is_active' => 1]);
            $brand_secret->permissions()->sync($request['permissions'][$key]);
        }
    }

    public function updateCampaign($request, $campaign)
    {
        $data = $request->except(['country_id', 'state_id', 'city_id', 'secret', 'permissions', 'branch_ids', 'list_ids', 'deliver_from', 'deliver_to', 'old_deliver_start_date', 'old_visit_start_date']);
        $data['list_ids'] = $request->get('list_ids', []);
        $data['delivery_from'] = $request->deliver_from;
        $data['delivery_to'] = $request->deliver_to;
        $data['has_guest'] = isset($data['has_guest']) ? (int) $data['has_guest'] : 0;
        $data['target'] = $request->target_influencer;
        $data['influencer_per_day'] = $request->influencer_per_day;
        $data['daily_influencer'] = $request->target_confirmation;
        $data['daily_confirmation'] = $request->daily_confirmation;

        $model = CampaignModel::find($campaign->id);
        if (array_key_exists('camp_brief', $data)) {
            $data['sub_brand_id'] = ($data['sub_brand_id']) ? $data['sub_brand_id'] : 0;
            foreach ($data['camp_brief'] as $i => $note) {
                $data['camp_brief'] = handleInputLanguage($note);
                if (isset($data['camp_note'][$i])) {
                    $data['camp_note'] = handleInputLanguage($data['camp_note'][$i]);
                }
                if (isset($data['camp_invetation'][$i])) {
                    $data['camp_invetation'] = handleInputLanguage($data['camp_invetation'][$i]);
                }
            }
        }

        $newFiles = [];
        $existingFiles = $campaign->attached_files ?: [];
        $existingFiles = array_map(function ($file) {
            return ['id' => $file['id'], 'name' => $file['name']];
        }, $existingFiles);

        if ($request->hasFile('attached_files') && is_array($request->file('attached_files'))) {
            $newFiles = $this->handleFileUploads($request->file('attached_files'));
        }

        $mergedFiles = array_merge($existingFiles, $newFiles);
        $data['deleted_attached_files'] = $data['deleted_attached_files'] ?? [];
        $deletedIds = isset($data['deleted_attached_files']) && is_array($data['deleted_attached_files']) ? $data['deleted_attached_files'] : ($data['deleted_attached_files'] ? explode("||", (string) $data['deleted_attached_files']) : []);
        $mergedFiles = array_filter($mergedFiles, function ($file) use ($deletedIds) {
            return !in_array(($file['id'] ?? ""), $deletedIds);
        });

        $data['attached_files'] = $mergedFiles;

        if (isset($data['draft']) && $data['draft'] == 1) {
            $data['status'] = 5;
        } elseif (!isset($data['draft']) && $model->status == 5) {
            $data['status'] = 0;
        }

        $data['target'] = isset($data['influencer_count']) ? $data['influencer_count'] : $data['target'] ?? 0;
        $data['influencer_per_day'] = $data['influencer_per_day'] ?? 0;
        $data['daily_influencer'] = $data['daily_influencer'] ?? 0;
        $data['daily_confirmation'] = $data['daily_confirmation'] ?? 0;
        $data['gender'] = isset($data['gender']) ? $data['gender'] : null;
        $data['campaign_check_list'] = (isset($data['chicklist']) ? $data['chicklist'] : null);
        $model->update($data);
        $this->addBranchesToCampaign($data, $model, $request->branch_ids, $request->compliment_branches);
        return $model->id;
    }

    public function updateBrandAndSubBrandInfo($request)
    {
        if (isset($request['sub_brand_id']) && $request['sub_brand_id'] != null) {
            $subbrand = Subbrand::find($request['sub_brand_id']);
            $subbrand->update([
                'phone' => $request['phone'][0],
                'whats_number' => $request['whatsapp'],
            ]);
        } else {
            $subbrand = Brand::find($request['brand_id']);
            $subbrand->update([
                'phone' => $request['phone'],
                'whatsapp' => $request['whatsapp'],
            ]);
        }
    }

    public function datatable($request)
    {
        $filter = $request->only(['status_val', 'country_val', 'campaign_type_val', 'start_date', 'end_date', 'status_type', 'group_of_brand_val']);
        $filter['search_name'] = $request->input('search.value');
        $records = CampaignModel::filter($filter)->count();
        $campaigns = CampaignResource::collection(CampaignModel::filter($filter)->skip((int) $request->get('start', 0))->take((int) $request->get('length', 10))->orderBy('id', 'desc')->get());
        return datatables($campaigns)
            ->setTotalRecords($records)
            ->setFilteredRecords($records)
            ->skipPaging()
            ->make(true);
    }

    public function show($campaign)
    {
        $campaignCountries = $campaign->campaignCountries()->pluck('country_id')->toArray();
        $countries = Country::whereIn('id', $campaignCountries)->get();
        $total_confirmations = $campaign->campaignInfluencers()->whereStatus(7)->get()->count();
        $total_refused = $campaign->campaignInfluencers()->whereStatus(8)->get()->count();
        $list_count = 0;
        //$list_count=  $campaign->campCountryFavourite()->first()->listFavourits()->get()->count();
        $allBranches = $campaign->branches;
        $brand = $campaign->brand()->first();
        $chick_lists = CampaignCheckList::all();
        $secrets = $campaign->secrets()->with('campaignCountry.country')->get();
        $target_confirmation = $campaign->daily_influencer;
        $daily_confirmation = $campaign->daily_confirmation;
        $groupIDs = is_array($campaign->list_ids)?$campaign->list_ids:[];
        $groupLists = GroupList::whereIn('id', $groupIDs)->pluck('name', 'id')->toArray();

        // TODO:: move this to a separate function.
        $GroupIDAsKeyAndInfluencerIDsAsValue = [];

        // DB::enableQueryLog();

        $influencers = InfluencerGroup::leftJoin('campaign_influencers as i', function ($join) use ($campaign) {
            $join->on('influencers_groups.influencer_id', '=', 'i.influencer_id')
                // g.group_list_id = i.list_id
                ->where('influencers_groups.group_list_id', '=', DB::raw('i.list_id'))
                ->where('i.campaign_id', '=', $campaign->id);
        })
            ->whereIn('group_list_id', $groupIDs)
            ->whereNull('i.influencer_id')
            ->whereNull('influencers_groups.group_deleted_at')
            ->select('influencers_groups.influencer_id', 'influencers_groups.group_list_id')
            ->get();

        // dd(DB::getQueryLog());

        foreach ($influencers as $influencer) {
            if (!isset($GroupIDAsKeyAndInfluencerIDsAsValue[$influencer->group_list_id])) {
                $GroupIDAsKeyAndInfluencerIDsAsValue[$influencer->group_list_id] = [];
            }
            $GroupIDAsKeyAndInfluencerIDsAsValue[$influencer->group_list_id][] = $influencer->influencer_id;
        }

        // dd($GroupIDAsKeyAndInfluencerIDsAsValue);

        $groups = [];

        foreach ($groupLists as $id => $name) {
            array_push(
                $groups,
                (object) [
                    "id" =>  $id,
                    "name" => $name,
                    "influencer_ids" => implode(',', $GroupIDAsKeyAndInfluencerIDsAsValue[$id] ?? []),
                ]
            );
        }

        return view('admin.dashboard.campaign.show', compact('campaign', 'chick_lists', 'countries', 'total_confirmations', 'list_count', 'total_refused', 'allBranches', 'brand', 'secrets', 'target_confirmation', 'daily_confirmation', 'groups'));
    }

    public function handleFileUploads($files)
    {
        $fileObjects = [];
        foreach ($files as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '', $fileName);
            $file->move(public_path('photos/campaign'), $fileName);

            $fileObject = [
                'id' => hexdec(uniqid()),
                'name' => $fileName,
            ];

            $fileObjects[] = $fileObject;
        }
        return $fileObjects;
    }


    public function updateInfluencerStatus($request)
    {
        try {

            $campaign = CampaignModel::where('camp_id', $request->camp_id)->first(['id', 'brand_id', 'campaign_type', 'daily_confirmation']);
            if (!$campaign)
                return ['status' => false, 'message' => 'The campaign cannot be found'];
            $influencer = Influencer::where('vInflUuid', $request->vContUuid)->first(['id', 'country_id']);
            if (!$influencer)
                return ['status' => false, 'message' => 'The Influencer cannot be found'];

            $influencerId = $influencer->id;
            $branchId = ($request->branch_name != '') ? \App\Models\Branch::where('name', 'LIKE', "%{$request->branch_name}%")->where('brand_id', $campaign->brand_id)->value('id') : 0;
            $confirm_date = (isset($request->confirm_date) && !empty($request->confirm_date)) ?     Carbon::parse($request->confirm_date)->format("Y-m-d") : NULL;
            $confirmation_start_time = (isset($request->confirm_start_time) && !empty($request->confirm_start_time)) ?     Carbon::parse($request->confirm_start_time)->format("H:i") : NULL;
            $confirmation_end_time = (isset($request->confirm_end_time) && !empty($request->confirm_end_time)) ?     Carbon::parse($request->confirm_end_time)->format("H:i") : NULL;

            $newInput['confirmation_date'] = $confirm_date;
            $newInput['confirmation_start_time'] = $confirmation_start_time;
            $newInput['confirmation_end_time'] = $confirmation_end_time;
            $newInput['campaign_type'] = $campaign->campaign_type;
            $newInput['branch_id']  = $branchId;
            $newInput['country_id']  = $influencer->country_id;
            $newInput['brand_id']  = $campaign->brand_id;
            $newInput['status'] = ($request->status == "3") ? 4 : 1;
            $newInput['reason'] = $request->reason;

            $getCountCurrentDailyConfirmations = CampaignInfluencer::selectRaw('count(id) as influe_count')->where('campaign_id', $campaign->id)->whereDate('confirmation_date', $confirm_date)->first();
            if (($getCountCurrentDailyConfirmations) && $getCountCurrentDailyConfirmations->influe_count >= (int) $campaign->daily_confirmation) {
                return ['status' => false, 'message' => 'The number of influencers for selected date has reached the allowed limit [Limit: ' . $campaign->daily_confirmation . ']'];
            }

            CampaignInfluencer::updateOrCreate(['influencer_id' => $influencerId, 'campaign_id' => $campaign->id], $newInput);
            if (isset($request->address) && !empty($request->address))
                Influencer::where('vInflUuid', $request->vContUuid)->update(['address', $request->address]);

            return ['status' => true, 'message' => 'Updated Succees'];
        } catch (\Exception $exception) {
            return  ['status' => false, 'message' => 'Server Error !!'];
        }
    }
}
