<?php

namespace App\Http\Controllers\API\BrandDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\BrandDashboard\EditProfile;
use App\Http\Resources\API\Brand_dashboard\UserProfileResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class BrandController extends Controller
{
    use ResponseTrait;

    public function edit_profile(EditProfile $request)
    {
        $user = auth()->user();
        $brand = $user->brands;
        $userData = [];

        if ($brand != null && @$user->brands->id != @$brand->id) {
            return $this->returnError('404', __('api.user brand not found'));
        }

        // if ($request['phone'] != null && count($request['phone']) == count($request['phone_code'])) {
        //     $request['phone'] = mergeCodeWithPhone($request->phone_code, $request->phone);
        //     collect($request['phone'])->filter()->toArray();
        // }

        $data = $request->except(['id', 'code', 'phone', 'password', 'password_confirmation']);

        $Inputs = Brand::socailMediaInputs($data['social']);
        $newInputs = array_merge($data, $Inputs);
        $brand->update($newInputs);

        // if (isset($request->password) && !empty($request->password)) {
        //     $userData['password'] = $request->only('password');
        // }

        // if (isset($request->email) && !empty($request->email)) {
        //     $userData['email'] = $request->only('email');
        // }

        $userData = $request->only('email', 'password', 'phone', 'code');

        $user->update($userData);

        $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
        return $this->returnData('user', new UserProfileResource($user), __('api.Profile Updated Successfully'));
    }

    public function get_brand_countries(Brand $brand)
    {
        return response()->json(['data' => $brand->countries]);
    }

}
