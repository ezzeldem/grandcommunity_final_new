<?php

namespace App\Http\Controllers\API;

use Aloha\Twilio\Twilio;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\ForgetPassword;
use App\Http\Resources\API\UserResource;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword as ForgetMail;

class ForgetPasswordController extends Controller
{
    use ResponseTrait;

    public function __construct(){
        $this->middleware('guest:api')->except(['verifyRecaptcha']);
    }

    /**
     * @param ForgetPassword $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function forgetStep1(ForgetPassword $request){
       $user =  User::where($request['send_type'],$request['send_to'])->first();
       if($user){
           $code = mt_rand(111111,999999);
           $user->update([
               'forget_type'=>$request['send_type'],
               'forget_code'=>$code,
               'forget_at'=>now(),
           ]);
           if($request['send_type'] =='email'){
               Mail::to($user->email)->send(new ForgetMail($user));
           }else{
               $twilio = new Twilio('','','');
               $twilio->message('', $code);
           }
           $data = ['send_type'=>$request['send_type'],'send_to'=>$request['send_to'],'forget_at'=>@$user->forget_at, 'currentStep'=>'step2','code'=>$code ];
           return $this->returnData('forget_info',$data,'code send successfully');

       }else{
           return $this->returnError(422, ' ( '.$request['send_to'].' ) Not Valid '.$request['send_type'].' .');
       }

   }

    /**
     * @param ForgetPassword $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function forgetStep2(ForgetPassword $request){
       $user = User::where($request['send_type'],$request['send_to'])
                    ->where('forget_code',$request['code'])->first();
       if(!$user)
           return $this->returnError('','error code, code not match your data');
       $user->update(['forget_code'=>null]);
       $data = ['send_type'=>$request['send_type'],'send_to'=>$request['send_to'],'forget_at'=>$user->forget_at,'currentStep'=>'step3'];
       return $this->returnData('forget_info',$data,'code send successfully');
   }

    /**
     * @param ForgetPassword $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgetStep3(ForgetPassword $request){
        $user = User::where($request['send_type'],$request['send_to'])->first();
        if(!$user)
            return $this->returnError('','something went wrong please contact with support');
        if($user->forget_code!= null)
            return $this->returnError('','you can not reset password please insert code sent');
        $user->update([
            'password'=>$request['password'],
            'forget_code'=>null,
            'forget_at'=>null,
            'forget_type'=>null
        ]);
        $user->refresh();
        $user['token'] = $user->createToken('token-name', ['server:update'])->plainTextToken;
        return $this->returnData('user',[],'code send successfully');
    }

    /**
     * @param ForgetPassword $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendForget(ForgetPassword $request){
        $user = User::where($request['send_type'],$request['send_to'])->first();
        if(!$user)
            return $this->returnError('','something went wrong please contact with support');
        if($user->forget_code==null || $user->forget_at==null)
            return $this->returnError('','you do not have code send before that try to go to forget link');
        if(Carbon::parse($user->forget_at)->diffInSeconds(now())<50)
            return $this->returnError('','please wait minute to resend');
        $code = mt_rand(111111,999999);
        $user->update([
            'forget_type'=>$request['send_type'],
            'forget_code'=>$code,
            'forget_at'=>now(),
        ]);
        $user->refresh();
        if($request['send_type'] =='email'){
            Mail::to($user->email)->send(new ForgetMail($user));
        }else{
            $twilio = new Twilio('','','');
            $twilio->message('', $code);
        }
        $data = ['send_type'=>$request['send_type'],'send_to'=>$request['send_to'],'forget_at'=>$user->forget_at,'currentStep'=>'step2'];
        return $this->returnData('forget_info',$data,'code send successfully');
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function verifyRecaptcha(Request $request){
        $result = file_get_contents(config('services.recaptcha.check_url')."?secret=".config('services.recaptcha.secret_key')."&response=".$request['recaptcha_token']);
        $response = json_decode($result);
        if($response->success == true){
            return $this->returnSuccessMessage('you are not robot');
        }else{
            return $this->returnError('','you are robot');
        }
    }
}
