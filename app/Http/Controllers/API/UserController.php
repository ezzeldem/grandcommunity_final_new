<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CompleteProfileRequest;
use App\Http\Requests\API\SocialStatusRequest;
use App\Http\Resources\API\UserResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Influencer;
use App\Models\InfluencerChild;
use App\Models\InfluencerPhone;
use App\Models\Subbrand;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        // dd(465);
    }

    public function getUser(Request $request)
    {
        $user = $request->user();
        $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
        if ($user->type == 0 && !$user->brands()->exists()) {
            return $this->returnError(404, "user need to register brand");
        }
        if ($user->type == 1 && !$user->influencers()->exists()) {
            return $this->returnError(404, "user need to register influencers");
        }
        return $this->returnData('user', new UserResource($user), 'User Registered Successfully Kindly Complete Data');
    }

    public function confirm(Request $request, $code)
    {
        $request['code'] = $code;
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|exists:users,forget_code',
        ]);
        if ($validate->fails()) {
            return $this->validationError($validate->errors());
        }

        $user = User::where('email', $request['email'])->where('forget_code', $code)->first();
        if (!$user) {
            return $this->returnError('', 'invalid code');
        }

        $user->update(['forget_code' => null, 'forget_at' => null]);
        $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;

        if (\request()->has('request_from') && \request('request_from') == 'mobile') {
            return $this->returnSuccessMessage('code updated successfully');
        } else {
            return $this->returnData('user', new UserResource($user), 'code updated successfully');
        }
    }

    public function resetConfirmCode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($validate->fails()) {
            return $this->validationError($validate->errors());
        }

        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return $this->returnError('', 'can not find user');
        }

        $user->update(['forget_code' => Str::random(11)]);
        $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;

        return $this->returnData('user', new UserResource($user), 'code updated successfully');
    }

    public function completeProfileV2(CompleteProfileRequest $request, User $user)
    {
        $data = [];
        $user = auth()->user();
        $brandInputs = $request['brand'];
        $brandInputs['step'] = $request->step;
        if (!empty($brandInputs['req_img']) && is_file($brandInputs['req_img'])) {
            $brandInputs['image'] = $brandInputs['req_img'];
            unset($brandInputs['req_img']);
        }
        if ($user->forget_code != null) {
            return $this->returnData('message', "please confirm user");
        }

        if ($user->type == 0 && !$user->brands()->exists()) {
            return $this->returnError(404, "user need to register brand");
        }

        if ($user->type == 1 && !$user->influencers()->exists()) {
            return $this->returnError(404, "user need to register influencers");
        }

        if ($user->type == 1) {
            if ($user->influencers->whatsapp == null && $user->influencers->social_type == null) {
                $dataInflue = $this->InfluencerCompleteV2($brandInputs, $user, $request['social_data']);
                $data = $dataInflue;
            } else {
                return $this->returnError('', 'can not complete data');
            }

        } else {
            $message = '';
            $datanew = $this->BrandCompleteV2($user, $brandInputs, $request);
            $data = $datanew;

            ($request->step == 1) ? $message = 'Step One Completed Successfully' : (($request->step == 2) ? $message = 'Step Two Completed Successfully' : $message = "Step Three Completed Successfully");
            $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
            return $this->returnData('user', $data, $message);
        }
        $user->refresh();
        $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
        return $this->returnData('user', $data, 'code updated successfully');
    }

    public function completeProfile(CompleteProfileRequest $request, User $user)
    {

        $user = auth()->user();

        $brandInputs = $request['brand'];
        (!empty($request->only('userData.password'))) ?? $user->update($request->only('userData.password'));
        if (!empty($brandInputs['req_img']) && is_file($brandInputs['req_img'])) {
            $brandInputs['image'] = $brandInputs['req_img'];
            unset($brandInputs['req_img']);
        }
        if ($user->forget_code != null) {
            return $this->returnData('message', "please confirm user");
        }

        if ($user->type == 0 && !$user->brands()->exists()) {
            return $this->returnError(404, "user need to register brand");
        }

        if ($user->type == 1 && !$user->influencers()->exists()) {
            return $this->returnError(404, "user need to register influencers");
        }

        if ($user->type == 1) {

            if ($user->influencers->whatsapp == null && $user->influencers->social_type == null) {
                $this->InfluencerComplete($brandInputs, $user, $request['social_data']);
            } else {
                return $this->returnError('', 'can not complete data');
            }

        } else {
            if ($user->brands->whatsapp == null) {
                if ((int) $request['brand_flag'] == 1) {
                    $this->BrandComplete($user, $brandInputs, $request);
                } else {
                    $user->oldData = !empty($user->oldData) ? $user->oldData : [];
                    $user->oldData = array_merge($user->oldData, $request->all());
                    $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
                    return $this->returnData('user', new UserResource($user), 'validation success');
                }
            } else {
                return $this->returnError('', 'can not complete data');
            }
        }
        $user->refresh();
        $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
        return $this->returnData('user', new UserResource($user), 'code updated successfully');
    }

    /**
     * @param $brandInputs
     * @param User $user
     */

    public function editCompleteProfile(SocialStatusRequest $request, $id)
    {
        $user = auth()->user();
        $social = [];
        $social['children_num'] = $request['social_data']['children_num'];
        $social['marital_status'] = $request['social_data']['social_type'];

        $children = [];

        if (isset($request['social_data']['children'])) {
            $children = $request['social_data']['children'];
        }

        $influ = Influencer::where('user_id', $id)->first();

        if ($influ) {
            $datachildren = [];
            foreach ($children as $key => $child) {
                $datachildren[] = ['influencer_id' => $influ->id, 'child_gender' => $child['gender'], 'child_name' => $child['name'], 'child_dob' => $child['DOB']];
            }

            if (!empty($datachildren)) {
                $influ->ChildrenInfluencer()->delete();
                InfluencerChild::insert($datachildren);
                $social['step'] = 3;

                $influ->update($social);
            }

            $data = ["marital_status" => $influ->marital_status, 'children_num' => $influ->children_num, 'childrens' => $influ->ChildrenInfluencer];
            $user->refresh();
            $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
            return $data;
        }
    }

    public function chechUserStatus(User $user)
    {
        return response()->json(['status' => true, 'data' => new UserResource($user)], 200);
    }

    protected function InfluencerComplete($brandInputs, User $user, $social_data): void
    {
        $brandInputs['interest'] = $brandInputs['interest'] ?? null;
        $brandInputs['whats_number'] = $brandInputs['whatsapp'];

        DB::beginTransaction();
        try {
            $influencer = $user->influencers;
            $influencer->update($$brandInputs);
            if (\request()->has('request_from') && \request('request_from') == 'mobile') {
                $data['social_data'] = \request('social_data');
                $this->editCompleteProfile(new SocialStatusRequest($data), $user->id);
            }
            DB::commit();
        } catch (\Exception$e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function InfluencerCompleteV2($brandInputs, User $user, $social_data)
    {
        if ($brandInputs['step'] == 1) {
            $brandInputs['interest'] = $brandInputs['interest'] ?? null;
            $brandInputs['classification_ids'] = $brandInputs['classification_ids'] ?? null;
            $brandInputs['lang'] = $brandInputs['lang'] ?? null;
            $brandInputs['coverage_channel'] = $brandInputs['coverage_channel'] ?? null;
            $brandInputs['whats_number'] = $brandInputs['whatsapp'];
            $brandInputs['step'] = $brandInputs['step'];
        }

        $data = [];
        $influencer = $user->influencers;

        if ($brandInputs['step'] == 1) {
            $brandInputs['step'] == 2;
            if ($brandInputs['interest'] && count($brandInputs['interest']) > 0) {
                $brandInputs['interest'] = array_map('strval', $brandInputs['interest']);
            }

            if ($brandInputs['lang'] && count($brandInputs['lang']) > 0) {
                $brandInputs['lang'] = array_map('strval', $brandInputs['lang']);
            }

            if ($brandInputs['classification_ids'] && count($brandInputs['classification_ids']) > 0) {
                $brandInputs['classification_ids'] = array_map('strval', $brandInputs['classification_ids']);
            }

            if($brandInputs['coverage_channel'] && count($brandInputs['coverage_channel']) > 0){
                $brandInputs['coverage_channel'] = array_map('strval', $brandInputs['coverage_channel']);
            }

            $inputs = Brand::socailMediaInputs($brandInputs['social']);
            $newInputs = array_merge($brandInputs, $inputs);
            $influencer->update($newInputs);
            $influencer->user()->update(['phone' => $brandInputs['phone'], 'code' => $brandInputs['code']]);
            $influencer->update(['step' => 2]);

            $phones = [];
            if (isset($brandInputs['phones']) && is_array($brandInputs['phones']) && count($brandInputs['phones']) > 0) {
                foreach ($brandInputs['phones'] as $key => $phone) {
                    if (!isset($phone['phone_code'])) {
                        continue;
                    }
                    $phones[] = ['influencer_id' => $influencer->id, 'phone' => $phone['phone'], 'code' => $phone['phone_code'], 'is_main' => 0, 'user_type' => 1];
                    $influencer->InfluencerPhones()->delete();
                }
            }

            if (count($phones) > 0) {
                InfluencerPhone::insert($phones);
            }


            $data = [
                "id" => $influencer->id, "name" => $influencer->name, 'facebook_uname' => $influencer->facebook_uname,
                'insta_uname' => $influencer->insta_uname, 'tiktok_uname' => $influencer->tiktok_uname,
                'snapchat_uname' => $influencer->snapchat_uname, 'code_whats' => $influencer->code_whats, "whatsapp" => $influencer->whats_number, "req_img" => $influencer->image, 'country_id' => $influencer->country_id,
                'state_id' => $influencer->state_id, "city_id" => $influencer->city_id, "nationality" => $influencer->nationality, "gender" => $influencer->gender, "interest" => $influencer->interest,
                "date_of_birth" => $influencer->date_of_birth, "lang" => $influencer->lang, "job" => $influencer->job, "step" => 2, "phones" => $influencer->InfluencerPhones, "classification_ids" => $influencer->classification_ids, "coverage_channels" => $influencer->coverage_channel
            ];
        }

        if ($brandInputs['step'] == 2) {
            $data['social_data'] = \request('social_data');
            $datanew = $this->editCompleteProfile(new SocialStatusRequest($data), $user->id);
            $influencer->update(['step' => 3]);
            $data = $datanew;
        }

        return new UserResource($user);
    }

    /**
     * @param User $user
     * @param $brandInputs
     * @param CompleteProfileRequest $request
     */
    protected function BrandCompleteV2(User $user, $brandInputs, CompleteProfileRequest $request)
    {
        $data = [];
        $skipped = isset($request->skipped) && $request->skipped ? 1 : 0;
        if (isset($brandInputs['code_whats'])) {
            $whatsapp_code = $brandInputs['code_whats'];
            $brandInputs['whatsapp_code'] = $whatsapp_code;
        }

        if (isset($brandInputs['phone'])) {
            $user->update(['code' => $brandInputs['code'], 'phone' => $brandInputs['phone']]);
        }

        $brand = $user->brands;

        if ($request->step == 1) {
            $brandInputs['step'] = $request->step + 1;
            if ($brandInputs['country_id'] && count($brandInputs['country_id']) > 0) {
                $brandInputs['country_id'] = array_map('strval', $brandInputs['country_id']);
            }

            $inputs = Brand::socailMediaInputs($brandInputs['social']);
            $newInputs = array_merge($brandInputs, $inputs);
            unset($newInputs['phone']);
            $brand->update($newInputs);

            if ($brandInputs['country_id'] && count($brandInputs['country_id']) > 0) {
                createbrandCountries($brandInputs['country_id'], $brand->id, $status = 0);
            }

        }

        if ($request->step == 2) {
            if (!checkIfNull($request['sub_brand'] ?? [])) {
                $sub_brand = $request['sub_brand'];
                $sub_brand['brand_id'] = @$user->brands->id ?? 0;
                $sub_brand['status'] = 0;
                $skipped = 0;
                $phone = mergeCodeWithPhone($request->code_phone, $request->phone);

                if ($sub_brand['country_id'] != null) {
                    if (array_key_exists('country_id', $request['sub_brand'])) {
                        $sub_brand['country_id'] = array_map('strval', $sub_brand['country_id']);
                    }
                }

                $sub_inputs = Subbrand::subBrandSocailMediaInputs($sub_brand['social']);
                $sub_newInputs = array_merge($sub_brand, $sub_inputs);
                if (!auth()->user()->brands->subbrands()->exists()) {
                    $new_sub = Subbrand::Create($sub_newInputs);
                } else {
                    $up_sub = $request['sub_brand'];
                    if ($up_sub['country_id'] != null) {
                        if (array_key_exists('country_id', $request['sub_brand'])) {
                            $up_sub['country_id'] = array_map('strval', $up_sub['country_id']);
                        }
                    }
                    $sub_inputs = Subbrand::subBrandSocailMediaInputs($up_sub['social']);
                    $sub_newInputs = array_merge($up_sub, $sub_inputs);
                    unset($sub_newInputs['social']);
                    $new_sub = auth()->user()->brands->subbrands()->latest()->first()->update($sub_newInputs);
                }
            } else {
                $skipped = 1;
                $sub_brand_data = ["name" => $brand->name, 'link_facebook' => $brand->facebook_uname,
                    'link_insta' => $brand->insta_uname, 'link_tiktok' => $brand->tiktok_uname,
                    'link_snapchat' => $brand->snapchat_uname, 'link_twitter' => $brand->twitter_uname,
                    'link_website' => $brand->website_uname,
                    'code_whats' => (int) $brand->whatsapp_code,
                    "whats_number" => $brand->whatsapp,
                    "code_phone" => (int) $brand->user->code,
                    "phone" => (int) $brand->user->phone,
                    "brand_id" => $brand->id,
                    "image" => $brand->image, 'country_id' => array_map('strval', $brand->country_id),
                ];
                if (!auth()->user()->brands->subbrands()->exists()) {
                    $new_sub = Subbrand::Create($sub_brand_data);
                } else {
                    $new_sub = auth()->user()->brands->subbrands()->latest()->first()->update($sub_brand_data);
                }
                //skip sub brands
            }

            $brand->update(['step' => $request->step + 1, 'skipped' => $skipped]);
        }

        if ($request->step == 3) {
            $newsubBrands = auth()->user()->brands->subbrands()->first();
            if ($request->has('branches') && $request['branches'] != null) {
                foreach ($request['branches'] as $branch) {
                    $branch['brand_id'] = @$user->brands->id ?? 0;
                    $branch['subbrand_id'] = (isset($newsubBrands)) ? $newsubBrands->id : 0;
                    $branch['status'] = 1;
                    $branches = Branch::create($branch);
                    array_push($data, ['name' => $branches->name, "address" => $branches->address, "city" => $branches->city, "state" => $branches->state, "country_id" => (int) $branches->country_id]);
                }
            }
            $brand->update(['step' => $request->step + 1]);
        }
        //  'all step request';

        //return $data;
        return new UserResource($user);
    }

    protected function BrandComplete(User $user, $brandInputs, CompleteProfileRequest $request): void
    {

        DB::beginTransaction();
        try {
            if (isset($brandInputs['code_whats'])) {
                $whatsapp_code = $brandInputs['code_whats'];
                $brandInputs['whatsapp_code'] = $whatsapp_code;
            }
            $brand = $user->brands;
            $brand->update($brandInputs);

            $sub_brand = $request['sub_brand'];
            if (!empty($sub_brand['req_img']) && is_file($sub_brand['req_img'])) {
                $sub_brand['image'] = $sub_brand['req_img'];
                unset($sub_brand['req_img']);
            }

            if (!checkIfNull($request['sub_brand'] ?? [])) {
                $sub_brand['brand_id'] = @$user->brands->id ?? 0;
                $sub_brand['status'] = 1;
                $new_sub = Subbrand::create($sub_brand);
            } else {
                $new_sub = Subbrand::create([
                    'brand_id' => $brand->id,
                    'name' => $brand->name,
                    'phone' => $brand->whatsapp,
                    'country_id' => $brand->country_id,
                    'code_whats' => $brand->whatsapp_code ?? '',
                    'code_phone' => $brand->code ?? $brand->whatsapp_code,
                    'whats_number' => $brand->whatsapp ?? '',
                    'phone' => $brand->phone ?? $brand->whatsapp,
                    'preferred_gender' => 'both',
                    'status' => 1,
                    'link_insta' => !is_null($brand->insta_uname) ? $brand->insta_uname : null,
                    'link_facebook' => !is_null($brand->facebook_uname) ? $brand->facebook_uname : null,
                    'link_twitter' => !is_null($brand->twitter_uname) ? $brand->twitter_uname : null,
                ]);
            }

            if ($request->has('branches') && $request['branches'] != null) {
                foreach ($request['branches'] as $branch) {
                    $branch['brand_id'] = @$user->brands->id ?? 0;
                    $branch['subbrand_id'] = (isset($new_sub)) ? $new_sub->id : 0;
                    $branch['status'] = 1;
                    Branch::create($branch);
                }
            }

            DB::commit();
        } catch (\Exception$e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function uploadFiles(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $type = $user->type; //0 for brand , 1 for influencer
            switch ($type) {
                case 0: //brand
                    $brand = $user->brands;
                    if (!empty($request->image) && is_file($request->image)) {
                        if (isset($request->sub_brand_id) && empty($request->sub_brand_id)) {
                            $brand->subbrands()->update(['image' => $request->image]);
                        } elseif (isset($request->sub_brand_id) && !empty($request->sub_brand_id)) {
                            Subbrand::where('id', $request->sub_brand_id)->update(['image' => $request->image]);
                        } else {
                            $brand->update(['image' => $request->image]);
                        }

                    }
                    break;
                case 1: //brand
                    if (!empty($request->image) && is_file($request->image)) {
                        $influencer = $user->influencers;
                        $influencer->update(['image' => $request->image]);
                    }
                    break;
            }

            DB::commit();
            return $this->returnSuccessMessage('Image updated successfully');
        } catch (\Exception$e) {
            DB::rollBack();
            return $this->returnError('', 'Server Error!!');
        }
    }

    public function switchUser(Request $request)
    {

        $user = auth()->user();
        switch ($request['type']) {
            case "1":
                if (!$user->influencers()->exists()) {
                    $user->influencers()->create(['name' => $user->user_name, 'status' => [1, 2, 3]]);
                }

                $user->update(['type' => 1]);
                $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
                return $this->returnData('user', new UserResource($user), 'User Registered Successfully Kindly Complete Data');
                break;
            case "0":
                if (!$user->brands()->exists()) {
                    $user->brands()->create(['name' => $user->user_name]);
                }

                $user->update(['type' => 0]);
                $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
                return $this->returnData('user', new UserResource($user), 'User Registered Successfully Kindly Complete Data');
                break;
            default:
                break;
        }
    }

    /**
     * @param $target
     * @param $brandInputs
     */
}
