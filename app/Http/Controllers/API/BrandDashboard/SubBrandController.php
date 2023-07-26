<?php

namespace App\Http\Controllers\API\BrandDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\BrandDashboard\SubBrandRequest;
use App\Http\Resources\API\Brand_dashboard\SubBrandEditResource;
use App\Http\Resources\API\SubBrandResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Branch;
use App\Models\Subbrand;
use App\Models\User;
use App\Repository\Interfaces\SubBrandsRepositoryInterface;
use Illuminate\Http\Request;

class SubBrandController extends Controller
{
    use ResponseTrait;
    protected $subBrandsRepo;

    public function __construct(SubBrandsRepositoryInterface $subBrandsRepo)
    {
        $this->subBrandsRepo = $subBrandsRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brand = User::find(auth()->user()->id);
        $filter = $request->only(['status_val', 'searchTerm', 'country_val', 'campaign_status', 'start_date', 'end_date']);
        $paginatedBrand = $brand->brands->subbrands()->ofFilter($filter)->orderBy('created_at', 'desc')->paginate(request()->get("per_page"));
        $subbrands = SubBrandResource::collection($paginatedBrand);
        $count = [
            'all' => $brand->brands->subbrands()->count(),
            'active' => $brand->brands->subbrands()->where('status', 1)->count(),
            'inactive' => $brand->brands->subbrands()->where('status', 0)->count(),
        ];
        return response()->json(['count' => $count , 'subbrands' => $subbrands, 'status' => 200, 'msg' => '']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubBrandRequest $request)
    {
        $user = auth()->user();
        $request['brand_id'] = @$user->brands->id;
        $data = $request->except(['country_id', 'branch_ids']);
        $data['country_id'] = array_map('strval', $request->country_id);
        $sub_inputs = Subbrand::subBrandSocailMediaInputs($data['social']);
        $newInputs = array_merge($data, $sub_inputs);
        $subbrand = $this->subBrandsRepo->createSubBrand($newInputs);
        if ($request->has('branch_ids') && !empty($request['branch_ids'])) {
            $data['branch_ids'] = array_map('intval', $request->branch_ids);
            $branche = Branch::whereIn('id', $data['branch_ids'])
                ->update(['subbrand_id' => $subbrand->id]);
        }
        return response()->json(['status' => true, 'msg' => __('api.successfully_added'), 'subbrand_id' => $subbrand->id]);
    }

    public function delete_all(Request $request)
    {
        $sub_brands = Subbrand::whereIn('id', $request['ids'])->whereDoesntHave('campaigns', function ($q) {
            $q->where('campaigns.status', 0);
        });
        if ($sub_brands->exists()) {
            $sub_brands->delete();
            return $this->returnSuccessMessage(__('api.successfully_deleted'));
        } else {
            return response()->json(['status' => false, 'message' => __('api.contains active campaign')], 200);
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
        $subBrand = Subbrand::findOrFail($id);

        $brand = auth()->user()->brands;

        if ($subBrand->brand_id != $brand->id) {
            $this->returnError(null, __('api.SubBrand does not belong to you'));
        }

        return $this->returnData('subbrand', new SubBrandEditResource($subBrand));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SubBrandRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubBrandRequest $request, $id)
    {
        $request['brand_id'] = @auth()->user()->brands->id;
        $subbrand = Subbrand::findOrFail($id);
        $data = $request->all();

        if (isset($data['social'])) {
            $sub_inputs = Subbrand::subBrandSocailMediaInputs($data['social']);
            $data = array_merge($data, $sub_inputs);
        }

        if ($request->has('country_id') && $request['country_id']) {
            $data['country_id'] = array_map('strval', $request->country_id);
        }

        if ($request->filled('branch_ids')) {
            $branchIds = array_map('intval', $request->input('branch_ids'));

            Branch::where('subbrand_id', $subbrand->id)->update(['subbrand_id' => 0]);
            Branch::whereIn('id', $branchIds)->update(['subbrand_id' => $subbrand->id]);

            $data['branch_ids'] = $branchIds;
        } else {
            Branch::where('subbrand_id', $subbrand->id)->update(['subbrand_id' => 0]);
        }

        $this->subBrandsRepo->updateSubBrand($data, $subbrand);
        return response()->json(['status' => true, 'msg' => __('api.successfully_updated'), 'subbrand_id' => $subbrand->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $subBrand = Subbrand::findOrFail($id);
    $campaigns = $subBrand->campaigns()->whereIn('status', [0, 1, 4, 5])->get();
    if ($campaigns->isEmpty()) {
        $subBrand->delete();
        return $this->returnSuccessMessage(__('api.successfully_deleted'));
    }
    return response()->json(['status' => false, 'message' => __('api.Subbrand is assigned to campaign')], 200);
}

}
