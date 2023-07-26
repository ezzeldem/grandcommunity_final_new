<?php

namespace App\Http\Controllers\API\BrandDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\BrandDashboard\BranchesRequest;
use App\Http\Resources\API\Brand_dashboard\BranchResource;
use App\Http\Resources\API\CampaignResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brand = User::find(auth()->user()->id);
        $filter = $request->only(['status_val', 'country_val', 'searchTerm', 'subbrand_val', 'subbrand']);

        $brandBranches = $brand->brands->branchs();
        $paginatedBranches = (clone $brandBranches)->offilter($filter)->orderBy('id', 'desc')->paginate(request()->get("per_page"));
        $branches = BranchResource::collection($paginatedBranches);
//        $response['per_page'] = $paginatedBranches->perPage();
//        $response['current_page'] = $paginatedBranches->currentPage();
//        $response['last_page'] = $paginatedBranches->lastPage();
//        $response['total'] = $paginatedBranches->total();
//        $response['message'] = 'Branches Returned Successfully';
//        $response['status'] = true;
        return response()->json($branches, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BranchesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchesRequest $request)
    {
        $user = auth()->user();
        $branchData = $request->except(['_token']);
        $branchData['subbrand_id'] = $branchData['subbrand_id'] ?? 0;
        $branchData['brand_id'] = @$user->brands->id ?? 0;
        if ($request->subbrandBranch) {
            $branchData['status'] = 1;
        }
        if (!$request->has('id') || $request['id'] == 0) {
            $branch = Branch::create($branchData);
            return $this->returnData('data', $branch, __('api.Branch Added Successfully'));
        } else {
            $branch = Branch::find($request['id']);
            if ($branch) {
                $branch->update($branchData);
            }
            return $this->returnData('data', $branch, __('api.Branch edit successfully'));
        }
    }

    public function delete_all(Request $request)
    {
        $statuses = [0, 1, 4, 5];
        $hascamp = Branch::whereHas('campaigns', function ($q) use ($statuses) {$q->whereIn('campaigns.status', $statuses);})->whereIn('id', $request['ids']);
        if (!$hascamp->exists()) {
            Branch::whereIn('id', $request['ids'])->delete();
            return $this->returnSuccessMessage(__('api.successfully_deleted'));
        } else {
            return response()->json(['status' => false, 'message' => __('api.Branch is assigned to campaign')], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = auth()->user()->brands;
        $branch = $brand->branchs()->where('id', $id)->first();
        if (!$branch) {
            return $this->returnError('404', __('api.branch not belong to brand'));
        }

        return $this->returnData('branch', new BranchResource($branch));
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
        $statuses = [0, 1, 4, 5];
        $hascamp = Branch::whereHas('campaigns', function ($q) use ($statuses) {
            $q->whereIn('campaigns.status', $statuses);
        })->where('id', $id);
        if (!$hascamp->exists()) {
            Branch::find($id)->delete();
            return $this->returnSuccessMessage(__('api.Branch Deleted Successfully'));
        }
        return response()->json(['status' => false, 'message' => __('api.Branch is assigned to campaign')], 200);
    }

    public function branchCampaigns($id)
    {
        $brand = auth()->user()->brands;
        $branch = $brand->branchs()->where('id', $id)->first();
        if (!$branch) {
            return $this->returnError('404', __('api.branch not belong to brand'));
        }

        $campaings = $branch->campaings;
        return $this->returnData('campaings', CampaignResource::collection($campaings));
    }
}
