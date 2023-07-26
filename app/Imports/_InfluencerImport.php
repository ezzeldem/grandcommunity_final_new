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

class _InfluencerImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable, SkipsErrors;

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

        $statuses = [];
        foreach (User::getInfluencerStatus() as $statusRow) {
            $statuses[$statusRow['name']] = $statusRow['id'];
        }

        $platforms = [
            'instagram' => 1,
            'facebook' => 2,
            'snapchat' => 3,
            'tiktok' => 4,
            'youtube' => 5,
            'twitter' => 6,
        ];

        $languages = [];
        foreach (Language::all() as $langRow) {
            $languages[$langRow->name] = $langRow->id;
        }


        foreach ($rows as $row) {
            $userData = [
                'user_name' => $row['user_name'],
                'email' => $row['email'],
                'password' => $row['password'],
                'type' => 1,
                'code' => $row['main_phone_code'],
                'phone' => $row['main_phone']
            ];

            $coveragePlatforms = [];
            if ($row['coverage_platforms']) {
                foreach (array_map('trim',  explode(',', $row['coverage_platforms'])) as $platformRow) {
                    if (key_exists($platformRow, $platforms)) {
                        $coveragePlatforms[] = $platforms[$platformRow];
                    }
                }
            }

            $user = User::updateOrCreate(['user_name' => $row['user_name']], $userData);
            $selectedLanguagesIds = [];
            $selectedLanguages = $row['languages'] ? array_map('trim',  explode(',', $row['languages'])) : [];

            foreach ($selectedLanguages as $rowName) {
                if (key_exists($rowName, $languages)) {
                    $selectedLanguagesIds[] = $languages[$rowName];
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
            $influencerData = [
                'user_id' => $user->id,
                'name' => $row['name'],
                'code_whats' => $row['whatsapp_code'],
                'whats_number' => $row['whatsapp'],
                'address' => $row['address'],
                'has_voucher' => $row['has_voucher'] == "yes" ? 1 : 0,
                'attitude_id' => $attitudes[$row['attitude']] ?? null,
                'licence' => $row['licence'] == "yes" ? 1 : 0,
                'v_by_g' => $row['v_by_g'] == "yes" ? 1 : 0,
                'date_of_birth' => (isset($row['date_of_birth']) && $row['date_of_birth'])?trim($row['date_of_birth'], '"'):null,
                'expirations_date' => $row['expirations_date']?trim($row['expirations_date'], '"'):null,
//                'country_id' => $country?$country->id:null,
//                'state_id' => $state?$state->id:null,
//                'city_id' => $city?$city->id:null,
//                'nationality' => $nationality?$nationality->id:null,
                'country_id' => $row['country'],
                'state_id' => $row['state'],
                'city_id' => $row['city'],
                'nationality' => $row['nationality'],
                'active' => $statuses[$row['status']] ?? $statuses["Pending"],
                'gender' => $row['gender'] == "female"?0:1,
                'insta_uname' => (isset($row['instagram']) && $row['instagram'])?$row['instagram']:null,
                'facebook_uname' => $row['facebook'],
                'tiktok_uname' => $row['tiktok'],
                'snapchat_uname' => $row['snapchat'],
                'twitter_uname' => $row['twitter'],
                'website_uname' => $row['website'] ? str_replace(['https://', 'http://'], ['', ''], $row['website']) : null,
//                'job' => $job?$job->id:null,
                'job' => $row['job'],
                'ethink_category' => ($row['ethink_category'] == 'open-minded') ? 1 : (($row['ethink_category'] == 'conservative') ? 2 : null),
                'account_type' => ($row['account_type'] == 'personal') ? 1 : (($row['account_type'] == 'product-based') ? 2 : (($row['account_type'] == 'general') ? 3 : null)),
                'citizen_status' => $row['citizen_status'] == 'Expat' ?2: 1,
                'marital_status' => $row['marital_status'] == 'single' ? 1 : ($row['marital_status'] == 'married' ? 2 : ($row['marital_status'] == 'single father' ? 3 : ($row['marital_status'] == 'single mother' ? 4 : null))),
                'children_num' => count($childrenInfo),
                'category_ids' => $row['categories'] ? array_map('trim',  explode(',', $row['categories'])) : [],
                'classification_ids' => $row['classifications'] ? array_map('trim',  explode(',', $row['classifications'])) : [],
                'interest' => $row['interests'] ? array_map('trim',  explode(',', $row['interests'])) : [],
                'coverage_channel' => $coveragePlatforms,
                'lang' => $selectedLanguagesIds,
            ];

            $influencer = Influencer::updateOrCreate(['user_id' => $user->id], $influencerData);

            $phonesArray = [];
            foreach ($row['call_phones'] ? array_map('trim',  explode(',', str_replace(", ", ",", $row['call_phones']))) : [] as $phoneRow) {
                $onePhoneArray = array_map('trim',  explode('-', $phoneRow));
                if (count($onePhoneArray) >= 2) {
                    $phonesArray[] = ['influencer_id' => $influencer->id, 'code' => $onePhoneArray[0], 'phone' => $onePhoneArray[1], 'type' => 1, 'is_main' => 0, 'user_type' => 1];
                }
            }
            foreach ($row['office_phones'] ? array_map('trim',  explode(',', str_replace(", ", ",", $row['office_phones']))) : [] as $phoneRow) {
                $onePhoneArray = array_map('trim',  explode('-', $phoneRow));
                if (count($onePhoneArray) >= 2) {
                    $phonesArray[] = ['influencer_id' => $influencer->id, 'code' => $onePhoneArray[0], 'phone' => $onePhoneArray[1], 'type' => 2, 'is_main' => 0, 'user_type' => 1];
                }
            }

            if ($row['whatsapp_phones']) {
                foreach (array_map('trim',  explode(',', $row['whatsapp_phones'])) as $phoneRow) {
                    $onePhoneArray = array_map('trim',  explode('-', $phoneRow));
                    if (count($onePhoneArray) >= 2) {
                        $phonesArray[] = ['influencer_id' => $influencer->id, 'code' => $onePhoneArray[0], 'phone' => $onePhoneArray[1], 'type' => 3, 'is_main' => 0, 'user_type' => 1];
                    }
                }
                if (count($phonesArray) > 0) {
                    InfluencerPhone::insert($phonesArray);
                }
            }

            $childrenArray = [];
            foreach ($childrenInfo as $childRow) {
                $childRow = array_map('trim',  explode(',', $childRow));
                if (count($childRow) >= 3) {
                    $childrenArray[] = ['influencer_id' => $influencer->id, 'child_name' => $childRow[0], 'child_gender' => $childRow[2], 'child_dob' => $childRow[1]];
                }
            }
            if (count($childrenArray) > 0) {
                InfluencerChild::insert($childrenArray);
            }
        }

        app()->setLocale($oldLocale);
    }


    /**rules
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'status' => 'required',
            'name' => 'required',
            'user_name' => 'required|string|unique:users,user_name',
            'email' => 'nullable|string|unique:users,email',
            'main_phone_code' => 'nullable',
            'main_phone' => 'nullable',
            'whatsapp_code' => 'required',
            'whatsapp' => 'required',
            'address' => 'nullable',
            'nationality' => 'nullable',
            'country' => 'required',
            'state' => 'nullable',
            'city' => 'nullable',
            'languages' => 'nullable|string',
            'instagram' => 'nullable|unique:influencers,insta_uname',
            'snapchat' => 'unique:influencers,snapchat_uname',
            'tiktok' => 'unique:influencers,tiktok_uname',
            'facebook' => 'unique:influencers,facebook_uname',
            'twitter' => 'unique:influencers,twitter_uname',
            'expirations_date' => 'nullable|string',
            'date_of_birth' => 'nullable|string',
            'gender' => 'required|in:male,female',
            'children_info' => 'sometimes|nullable',
            'call_phones' => 'sometimes|nullable',
            'whatsapp_phones' => 'sometimes|nullable',
            'office_phones' => 'sometimes|nullable',
            'interests' => 'sometimes|nullable',
            'classifications' => 'sometimes|nullable',
            'marital_status' => 'sometimes|in:single,married,single father,single mother',
            'coverage_platform' => 'sometimes|in:instagram,snapchat,facebook,tiktok,youtube',
        ];
    }
}
