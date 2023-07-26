<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Influencer;
use App\Models\InfluencerChild;
use App\Models\InfluencerClassification;
use App\Models\InfluencerPhone;
use App\Models\Interest;
use App\Models\Job;
use App\Models\Language;
use App\Models\Nationality;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class InfluencerImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable, SkipsErrors;

    public array $messages_success = [];

    /**
     * @param Collection $rows
     */


    public function collection(Collection $rows)
    {
        $oldLocale = app()->getLocale();
        app()->setLocale("en");
        $attitudes = [];
        foreach (attitude() as $attitudeRow) {
            $attitudes[$attitudeRow['name']] = $attitudeRow['id'];
        }

        $countriesList = [];
        foreach (Country::all() as $row){
            $countriesList[trim(strtolower($row->name))] = $row->id;
        }

        $nationalitiesList = [];
        foreach (Nationality::all() as $row){
            $nationalitiesList[trim(strtolower($row->name))] = $row->id;
        }

        $languagesList = [];
        foreach (Language::all() as $langRow) {
            $languagesList[trim(strtolower($langRow->name))] = $langRow->id;
        }

        $interestsList = [];
        foreach (Interest::all() as $row){
            $interestsList[trim(strtolower($row->interest))] = $row->id;
        }

        $classificationsList = [];
        foreach (InfluencerClassification::where('status', 'classification')->get() as $classification){
            $classificationsList[trim(strtolower($classification->name))] = $classification->id;
        }
        $statuses = [];
        foreach (User::getInfluencerStatus() as $statusRow) {
            $statuses[trim(strtolower($statusRow['name']))] = $statusRow['id'];
        }

        $platforms = [
            'instagram' => 1,
            'facebook' => 2,
            'snapchat' => 3,
            'tiktok' => 4,
            'youtube' => 5,
            'twitter' => 6,
        ];

        $line = 0;

        foreach ($rows as $row) {
            $line++;
            try {
            if(empty($row['status'])){
                continue;
            }

            if(empty($row['user_name'])){
                $this->messages_success[]=['message'=>'user_name is required',"Name"=>"(Line:".$line.")","status"=>"faild"];
                continue;
            }

//            if(empty($row['instagram'])){
//                $this->messages_success[]=['message'=>'instagram is required',"Name"=>$row['user_name']." (Line:".$line.")","status"=>"faild"];
//                continue;
//            }

            $userData = [
                'user_name' => $row['user_name'],
                'email' => $row['email'],
                'password' => $row['password']??hexdec(uniqid()),
                'type' => 1,
                'code' => $row['main_phone_code'],
                'phone' => $row['main_phone'],
                'deleted_at' => null,
            ];

            $coveragePlatforms = [];
            if ($row['coverage_platforms']) {
                foreach (array_map('trim',  explode(',', $row['coverage_platforms'])) as $platformRow) {
                    if (key_exists($platformRow, $platforms)) {
                        $coveragePlatforms[] = $platforms[$platformRow];
                    }
                }
            }

            $selectedLanguagesIds = [];
            $selectedLanguages = $row['languages'] ? array_map('trim',  explode(',', $row['languages'])) : [];

            foreach ($selectedLanguages as $rowName) {
                if (key_exists(strtolower($rowName), $languagesList)) {
                    $selectedLanguagesIds[] = (string) $languagesList[strtolower($rowName)];
                }
            }

            $selectedInterestsIds = [];
            $selectedInterests = $row['interests'] ? array_map('trim',  explode(',', $row['interests'])) : [];

            foreach ($selectedInterests as $rowName) {
                if (key_exists(strtolower($rowName), $interestsList)) {
                    $selectedInterestsIds[] = (string) $interestsList[strtolower($rowName)];
                }
            }

            $selectedClassificationsIds = [];
            $selectedClassifications = $row['classifications'] ? array_map('trim',  explode(',', $row['classifications'])) : [];

            foreach ($selectedClassifications as $rowName) {
                if (key_exists(strtolower($rowName), $classificationsList)) {
                    $selectedClassificationsIds[] = (string) $classificationsList[strtolower($rowName)];
                }
            }
//            $country = $row['country'] != null ? Country::query()
//                ->whereJsonContains('name->en',  trim($row['country']))->first() : null;
//
//            $state = $country != null && $row['state'] ? State::where('name', 'like', "%{$row['state']}%")->where('country_id', $country->id)->first(): null;
//
//            $city = $state != null && $row['city'] ?  City::whereJsonContains('name->en',  trim($row['city']))->where('state_id', $state->id)->first():null;
//
//            $nationality = $row['nationality'] ? Nationality::whereJsonContains('name->en',  trim($row['nationality']))->first():null;
//
//            $job = $row['job'] ? Nationality::whereJsonContains('name->en',  trim($row['job']))->first():null;
//
//            $job = $row['job'] ? Nationality::whereJsonContains('name->en',  trim($row['job']))->first():null;


            $childrenInfo = (isset($row['children_info']) && $row['children_info']) ? array_map('trim',  explode('|', $row['children_info'])) : [];

            $state = State::whereRaw('json_valid(name)')->whereJsonContains('name->en', trim(($row['state']??'none')))->first();

            if($state && !empty($row['city']))
            $city = City::where("name", 'like', '%' . trim($row['city']) . '%')->where('state_id',$state->id)->first();
            else{
                $city = '';
            }

            $user = User::withTrashed()->updateOrCreate(['user_name' => $row['user_name']], $userData);
if($user){
    if(!empty($row['instagram'])){
        if($otherUser = Influencer::where('insta_uname', $row['instagram'])->where('user_id', '!=', $user->id)->first()){
            $this->messages_success[]=['message'=> ('instagram is exists before for another influencer with name '.$otherUser->name),"Name"=>$row['user_name']." (Line:".$line.")","status"=>"faild"];
            continue;
        }
    }
    $country = Country::find((int) $this->getValue($row['country'], $countriesList));
    $nationality = Nationality::find((int) $this->getValue($row['nationality']??"none", $nationalitiesList));
    $citizen_status = null;
    if($country && $nationality){
        if(strtolower($country->code) == strtolower($nationality->code)){
            $citizen_status = 1;
        }else{
            $citizen_status = 2;
        }
    }

    $influencerData = [
        'user_id' => (int) $user->id,
        'name' => $row['name'],
        'code_whats' => $row['whatsapp_code'],
        'whats_number' => $row['whatsapp'],
        'country_id' => $this->getValue($row['country'], $countriesList),
        'state_id' => $state?$state->id:null,
        'city_id' => $city?$city->id:null,
        'address' => $row['full_address']??null,
        'nationality' => $this->getValue($row['nationality']??"none", $nationalitiesList),
        'citizen_status' => $citizen_status,
        'lang' => $selectedLanguagesIds,
        'gender' => $row['gender'] == "female"?0:1,
        'date_of_birth' => (isset($row['date_of_birth']) && $row['date_of_birth'])? Carbon::parse($row['date_of_birth'])->format('Y-m-d'):null,
        'ethink_category' => ($row['ethink_category'] == 'open-minded') ? 1 : (($row['ethink_category'] == 'conservative') ? 2 : null),
        'interest' => $selectedInterestsIds,
        'classification_ids' => $selectedClassificationsIds,
        'coverage_channel' => $coveragePlatforms,
        'insta_uname' => (isset($row['instagram']) && $row['instagram'])?$row['instagram']:null,
        'facebook_uname' => $row['facebook'],
        'tiktok_uname' => $row['tiktok'],
        'snapchat_uname' => $row['snapchat'],
        'twitter_uname' => $row['twitter'],
        'active' => $statuses[trim(strtolower($row['status']))] ?? $statuses["pending"],
        'deleted_at' => null,
		'vInflUuid'=>(isset($user->influencers) && !empty($user->influencers)) ? $user->influencers->vInflUuid : NULL,
//                'has_voucher' => $row['has_voucher'] == "yes" ? 1 : 0,
//                'attitude_id' => $attitudes[$row['attitude']] ?? null,
//                'licence' => $row['licence'] == "yes" ? 1 : 0,
//                'v_by_g' => $row['v_by_g'] == "yes" ? 1 : 0,
//                'expirations_date' => $row['expirations_date']?trim($row['expirations_date'], '"'):null,
////                'country_id' => $country?$country->id:null,
////                'state_id' => $state?$state->id:null,
////                'city_id' => $city?$city->id:null,
////                'nationality' => $nationality?$nationality->id:null,
//
//                'active' => $statuses[$row['status']] ?? $statuses["Pending"],
//
//                'website_uname' => $row['website'] ? str_replace(['https://', 'http://'], ['', ''], $row['website']) : null,
////                'job' => $job?$job->id:null,
//                'job' => $row['job'],
//                'account_type' => ($row['account_type'] == 'personal') ? 1 : (($row['account_type'] == 'product-based') ? 2 : (($row['account_type'] == 'general') ? 3 : null)),
//                'citizen_status' => $row['citizen_status'] == 'Expat' ?2: 1,
//                'marital_status' => $row['marital_status'] == 'single' ? 1 : ($row['marital_status'] == 'married' ? 2 : ($row['marital_status'] == 'single father' ? 3 : ($row['marital_status'] == 'single mother' ? 4 : null))),
//                'children_num' => count($childrenInfo),
//                'category_ids' => $row['categories'] ? array_map('trim',  explode(',', $row['categories'])) : [],
    ];


    Influencer::withTrashed()->updateOrCreate(['user_id' => (int) $user->id], $influencerData);
} //end check user

            }catch (\Exception $exception){
                $this->messages_success[]=['message'=> "Something went wrong.","Name"=>($row['user_name']?$row['user_name']." (Line: ".$line.")":"(Line: ".$line.")"),"status"=>"faild"];
            }

            $this->messages_success[]=["status"=>"success"];
        }

        app()->setLocale($oldLocale);
    }


    /**rules
     * @return string[]
     */
    public function rules(): array
    {
        return [
//            'status' => 'required',
//            'name' => 'required',
//            'user_name' => 'required|string|unique:users,user_name',
//            'email' => 'nullable|string|unique:users,email',
//            'main_phone_code' => 'nullable',
//            'main_phone' => 'nullable',
//            'whatsapp_code' => 'required',
//            'whatsapp' => 'required',
//            'full_address' => 'nullable',
//            'nationality' => 'nullable',
//            'country' => 'required',
//            'state' => 'nullable',
//            'city' => 'nullable',
//            'languages' => 'nullable|string',
//            'expirations_date' => 'nullable|string',
//            'date_of_birth' => 'nullable|string',
//            'gender' => 'required|in:male,female',
//            'children_info' => 'sometimes|nullable',
//            'call_phones' => 'sometimes|nullable',
//            'whatsapp_phones' => 'sometimes|nullable',
//            'office_phones' => 'sometimes|nullable',
//            'interests' => 'sometimes|nullable',
//            'classifications' => 'sometimes|nullable',
////            'marital_status' => 'sometimes|in:single,married,single father,single mother',
//            'coverage_platform' => 'sometimes|in:instagram,snapchat,facebook,tiktok,youtube',
        ];
    }

    protected function getValue($needle, $array){
        return $array[strtolower(trim((string)$needle))]??null;
    }
}
