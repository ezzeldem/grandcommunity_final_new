<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\SocialScrape\InstagramScrapeTrait;
use App\Jobs\ScrapCommand;
use App\Mail\RegisterEmail;
use App\Models\Brand;
use App\Models\BrandCountry;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthenticationController extends Controller
{

    use ResponseTrait, InstagramScrapeTrait;

    /** this method adds new users
     * @param RegisterRequest $request
     * @return mixed
     */

    public function register(RegisterRequest $request)
    {
        $data = [];
        DB::beginTransaction();
        try {
            $setting = Setting::first();
            $request['forget_code'] = $setting->send_mail ? generateCode() : null;
            $request['forget_at'] = $setting->send_mail ? now() : null;
            $inputs = $request->only('user_name', 'email', 'password', 'type', 'phone', 'code', 'forget_code', 'forget_at');

            $user = User::create($inputs);
            \Auth::guard('api')->login($user);
            $request['user_id'] = $user?->id;

            $brandInputs['user_id'] = $user?->id;
            $brandInputs['name'] = $request->name;
            $brandInputs['status'] = 0;
            $brandInputs['whatsapp_code'] = $inputs['code'];
            $brandInputs['whatsapp'] = $inputs['phone'];
			$brandInputs['vInflUuid'] = NULL;
            $socailInputs = Brand::socailMediaInputs($request['social']);

            switch ($request['type']) {
                case 0:
                    if ($request['country_id'] && count($request['country_id']) > 0) {
                        $brandInputs['country_id'] = array_map('strval', $request['country_id']);
                    }

                    $newInputs = array_merge($brandInputs, $socailInputs);
                    $brand = $user->brands()->create($newInputs);
                    $this->createSubBrand($brand);
                    foreach ($request['country_id'] as $country_id) {
                        BrandCountry::create(['brand_id' => $brand->id, 'country_id' => $country_id, 'status' => 1]);
                    }
                    break;
                case 1:

                    $brandInputs['address'] = $request['address'];
                    $brandInputs['nationality'] = $request['nationality'];
                    $brandInputs['date_of_birth'] = $request['date_of_birth'];
                    $brandInputs['country_id'] = $request['country_id'];
                    $brandInputs['code_whats'] = $inputs['code'];
                    $brandInputs['whats_number'] = $inputs['phone'];
                    $brandInputs['gender'] = $request["gender"];
					$brandInputs['vInflUuid'] = NULL;
                    $newInputs = array_merge($brandInputs, $socailInputs);
                    $user->influencers()->create($newInputs);

                    break;

            }

            $token = $user->createToken('token-name', ['server:update'])->plainTextToken;

            $data = ['token' => $token, 'id' => $user?->id, 'user_type' => $user->type == 0 ? 'brand' : 'influencer',
                'phone' => $user->phone, 'code' => $user->code, 'forget_code' => $user->forget_code,
                'email' => $user->email, 'user_name' => $user->user_name, 'type' => $user->type == 0 ? 'brand' : 'influencer',
                'status' => true, 'account_status' => 'pending',
            ];

            if ($setting->send_mail) {
                Mail::to($user->email)->send(new RegisterEmail($user));
            }

            DB::commit();
            if ($user->wasRecentlyCreated) {
                //send notification
                /*  $notification= new Notification();
                $notification->message = "The  $user->user_name  has created an account with Grand Community";
                $notification->user_id = $user->id;
                $notify =  $user->notification()->save($notification);
                broadcast(new NotificationEvent($user,$notify));
                //cron job
                 */
                $user->type == 1 ? dispatch(new ScrapCommand($user->influencers)) : false;
                return response()->json($data, 200);
            }

        } catch (\Exception$e) {
            DB::rollBack();
            throw $e;
        }

    }

    protected function createSubBrand($brand): void
    {
        $sub_brand_data = ["name" => $brand->name, 'link_facebook' => $brand->facebook_uname,
            'link_insta' => $brand->insta_uname, 'link_tiktok' => $brand->tiktok_uname,
            'link_snapchat' => $brand->snapchat_uname, 'link_twitter' => $brand->twitter_uname,
            'link_website' => $brand->website_uname,
            'code_whats' => (int) $brand->whatsapp_code,
            "whats_number" => $brand->whatsapp,
            "code_phone" => (int) $brand->whatsapp_code,
            "phone" => $brand->whatsapp,
            "brand_id" => $brand->id,
            "country_id" => array_map('strval', $brand->country_id),
        ];

        $new_sub = \App\Models\Subbrand::Create($sub_brand_data);
    }
    /** login user
     * @param LoginRequest $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $attr = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $field = filter_var($attr['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
        $credentials = [$field => $attr['login'], 'password' => $attr['password']];

        if (!\Auth::guard('api')->attempt($credentials)) {
            return $this->validationError([
                'login' => [__('auth.failed')],
            ]);
        }

        $user = \Auth::guard('api')->user();

        $token = $user->createToken('token-name', ['server:update'])->plainTextToken;
        $data['status'] = true;
        $data['id'] = $user?->id;
        $data['user_type'] = $user->type == 1 ? 'influencer' : 'brand';
        $data['user_name'] = $user->user_name;
        $data['email'] = $user->email;
        $data['token'] = $token;
        $data['phone'] = $user->phone;
        $data['phone_code'] = $user->code;

        if ($user->type == 1) {
            if (@$user->influencers->active == 1) {
                $data['account_status'] = 'active';
            } elseif (@$user->influencers->active == 0) {
                $data['account_status'] = 'pending';
            } elseif (@$user->influencers->active == 3) {
                $data['account_status'] = 'rejected';
            } elseif (@$user->influencers->active == 2) {
                $data['account_status'] = 'inactive';
            } else {
                $data['account_status'] = '';
            }

            $data['insta_username'] = $user->influencers->insta_uname ?? '';
            $data['image'] = $user->influencers->image ?? '';
        } else {
            if (@$user->brands->status == 1) {
                $data['account_status'] = 'active';
            } elseif (@$user->brands->status == 0) {
                $data['account_status'] = 'pending';
            } elseif (@$user->brands->status == 3) {
                $data['account_status'] = 'rejected';
            } elseif (@$user->brands->status == 2) {
                $data['account_status'] = 'inactive';
            } else {
                $data['account_status'] = '';
            }

            $data['name'] = $user->brands->name ?? '';
            $data['step'] = $user->brands->step ?? '';

            $data['countries'] = $user->brands->countries ?? [];

        }

        return response()->json($data, 200);
    }

    public function social($provider, Request $request)
    {
        $auth = Socialite::driver($provider)->stateless()->user();
        $email = $auth->getEmail();
        $avatar = $auth->getAvatar();
        $user = User::where('email', $email);
        if (!$user->exists()) {
            $data = (array) $auth;
            $data['user_name'] = $auth['name'];
            $data['phone'] = randomDigits(9);
            $data['password'] = \Illuminate\Support\Str::random(15);
            $data['type'] = 0;
            $data = User::create($data);
            $data->brands()->create($this->brandData($data, $avatar));
        } else {
            $user = $user->first();
            if (!$user->brands()->exists()) {
                $user->brands()->create($this->brandData($user, $avatar));
            }
        }
        $userCreated = User::where('email', $email)->first();
//          $userCreated->socialProviders()->updateOrCreate(['provider'=>$provider],[
//              'provider_id' => $auth->getId(),
//              'token' => $auth->token,
//              'expireIn' => $auth->expireIn,
//          ]);
        $response['token'] = $userCreated->createToken('token-name', ['server:update'])->plainTextToken;
        $response['status'] = true;
        $response['user_type'] = $userCreated->type == 1 ? 'influencer' : 'brand';
        $response['phone'] = $userCreated->phone;
        return response()->json($response, 200);
    }

    private function findOrCreateUser($socialLiteUser)
    {

        $user = User::firstOrNew([
            'email' => $socialLiteUser->email,
        ], [
            'facebook_id' => $socialLiteUser->id,
        ]);

        return $user;
    }

    /**this method signs out users by removing tokens
     * @param Request $request
     */
    public function signout(Request $request): void
    {
        //auth()->user()->tokens()->delete();
		$request->user()->currentAccessToken()->delete();
    }

    public function resendVerification()
    {
        $setting = Setting::first();
        $inputs['forget_code'] = generateCode();
        $inputs['forget_at'] = now();
        $user = auth()->user();
        if (Carbon::parse($user->forget_at)->diffInSeconds(now()) < 50) {
            return $this->returnError('', 'please wait minute');
        }

        $user->update($inputs);
        $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
        Mail::to($user->email)->send(new RegisterEmail($user));
        return $this->returnData('send_at', $user->forget_at, 'resend verification code');
    }

    protected function brandData($data, $avatar)
    {
        $brand['country_id'] = Country::whereIn('phonecode', ['971', '20', '965'])->get()->pluck('id')->toArray();
        $brand['status'] = 1;
        $brand['insta_uname'] = $data['user_name'];
        $brand['whatsapp'] = randomDigits(9);
        $brand['whatsapp_code'] = 971;
        $brand['phone'] = ['971' => randomDigits(9)];
        $brand['image'] = $avatar;
        $brand['name'] = $data['user_name'];
        return $brand;
    }

}
