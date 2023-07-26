<?php

use App\Models\City;
use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\State;
use App\Models\Branch;
use App\Models\Office;
use App\Models\Status;
use App\Models\Country;
use App\Models\Setting;
use App\Models\Campaign;
use App\Models\Interest;
use App\Models\Subbrand;
use App\Models\Influencer;
use App\Models\Permission;
use App\Models\Nationality;
use Illuminate\Support\Facades\Cache;
use \Illuminate\Support\Str;
use App\Models\BrandCountry;
use App\Models\CampaignInfluencer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

if (!function_exists('asset_public')) {
    /**
     * Full asset public path
     */
    function asset_public($path = null)
    {
        return env('APP_URL' . '/public/', 'http://localhost/public/') . $path;
    }
}

if (!function_exists('taskPriority')) {
    function taskPriority($priority)
    {
        switch ($priority) {
            case 0:
                $response = 'Top';
                break;
            case 1:
                $response = 'High';
                break;
            case 2:
                $response = 'Low';
                break;
            default:
                $response = "No priority Recognized";
                break;
        }
        return $response;
    }
}

if (!function_exists('routeContain')) {
    /**
     * Full asset public path
     */
    function routeContain($wordForSearch)
    {
        $routeName = Request::route()->getName();
        $contains = Str::contains($routeName, $wordForSearch);
        return $contains;
    }
}
///use this important
if (!function_exists('getInfluencerCampaignStatus')) {
    function getInfluencerCampaignStatus($val, $type = 1)
    {

        $response = '';
        switch ($val) {
            case 0:
                $response = "Pending";
                break;
            case 1:
                $response = 'Confirmed';
                break;
            case 4:
                $response = "Canceled";
                break;
            case 2:
                $response = ($type == 2) ? 'Delivered' : 'Visit';
                break;
            case 3:
                $response = ($type == 2) ? "Not Delivered" : "Missed Visit";
                break;
            case 5:
                $response = "Waiting";
                break;
            default:
                return false;
                break;
        }
        return $response;
    }
}
///use this important
// if (!function_exists('getInfluencerCampaignStatus_val')) {
//     function getInfluencerCampaignStatus_val($val, $type = 1)
//     {
//         $response = '';
//         switch ($val) {
//             case 0:
//                 $response = "pending..";
//                 break;
//             case 1:
//                 $response = 'Confirmed';
//                 break;
//             case 4:
//                 $response = "Cancel";
//                 break;
//             case 2:
//                 $response = ($type == 2) ? 'Delivered' : 'Visit';
//                 break;
//             case 3:
//                 $response = ($type == 2) ? "Not Delivered" : "NOT Visit";
//                 break;
//             case 5:
//                 $response = "Waiting";
//                 break;
//             default:
//                 return false;
//                 break;
//         }
//         return $response;
//     }
// }

if (!function_exists('user_can_any')) {
    /**
     * @param $table
     * @return bool
     */
    function user_can_any($table)
    {

        $user = auth()->user();
        return $user->can('read ' . $table) || $user->can('create ' . $table) ||
            $user->can('update ' . $table) || $user->can('delete ' . $table);
    }
}

if (!function_exists('nr')) {
    function nr($number, $decimals = 0, $extra = false)
    {
        if ($extra) {
            if (!is_array($extra) || (is_array($extra) && in_array('B', $extra))) {
                if ($number > 999999999) {
                    return floor($number / 1000000000) . 'B';
                }
            }
            if (!is_array($extra) || (is_array($extra) && in_array('M', $extra))) {
                if ($number > 999999) {
                    return floor($number / 1000000) . 'M';
                }
            }
            if (!is_array($extra) || (is_array($extra) && in_array('K', $extra))) {
                if ($number > 999) {
                    return floor($number / 1000) . 'K';
                }
            }
        }

        if ($number == 0) {
            return 0;
        }
        return number_format($number, $decimals, ".", ",");
    }
}

if (!function_exists('adminRoles')) {
    /**
     * @return mixed
     */
    function adminRoles()
    {
        $roles = Role::where('type', 'admin')
            ->where('guard_name', 'web')->get()->mapWithKeys(function ($q) {
                return [$q->id => $q->name];
            });
        return $roles;
    }
}

//Articles Tags Old Value Return
if (!function_exists('selectTags')) {
    /**
     * @return mixed
     */
    function selectTags($tags)
    {
        $oldTags = collect($tags);
        $oldTags  = $oldTags->mapWithKeys(function ($tag) {
            return [$tag => $tag];
        });

        return $oldTags;
    }
}

//if(!function_exists('metaTags')){
//    /**
//     * @return mixed
//     */
//    function metaTags(){
//        $metas=[];
//        if(\request()->path() == '/'){
//            if(app()->getLocale() == 'en')
//            $metas['twitter:description'] = 'Grand Community, the top influencer marketing and campaign management platform, Grow your business now with persuasive campaigns lead by worldwide celebrities';
//        }
//
//        return $metas;
//    }
//}


if (!function_exists('salesRoles')) {
    /**
     * @return mixed
     */
    function salesRoles()
    {
        $roles = Role::where('type', 'sales')
            ->where('guard_name', 'web')->get()->mapWithKeys(function ($q) {
                return [$q->id => $q->name];
            });
        return $roles;
    }
}

if (!function_exists('randomDigits')) {
    $digits = '';
    function randomDigits($length)
    {
        $numbers = range(0, 9);
        shuffle($numbers);
        for ($i = 0; $i < $length; $i++) {
            global $digits;
            $digits .= $numbers[$i];
        }
        return $digits;
    }
}

if (!function_exists('operationRoles')) {
    /**
     * @return mixed
     */
    function operationRoles()
    {
        if (auth()->user()->roles[0]['type'] == 'admin') {
            $roles = Role::where('type', 'operations')
                ->where('guard_name', 'web')->get()->mapWithKeys(function ($q) {
                    return [$q->id => $q->name];
                });
        } else {
            $roles = Role::where('type', 'operations') //->where('name', 'like', '%OperationManager%')
                ->where('guard_name', 'web')->get()->mapWithKeys(function ($q) {
                    return [$q->id => $q->name];
                });
        }
        return $roles;
    }
}

if (!function_exists('communityRoles')) {
    /**
     * @return mixed
     */
    function communityRoles()
    {
        if (auth()->user()->roles[0]['type'] == 'admin') {
            $roles = Role::where('type', 'community')
                ->where('guard_name', 'web')->get()->mapWithKeys(function ($q) {
                    return [$q->id => $q->name];
                });
        } else {
            $roles = Role::where('type', 'community')->where('name', 'not like', '%OperationManager%')->where('name', 'not like', '%superCommunity%')
                ->where('guard_name', 'web')->get()->mapWithKeys(function ($q) {
                    return [$q->id => $q->name];
                });
        }

        return $roles;
    }
}

if (!function_exists('subOperationRoles')) {
    /**
     * @return mixed
     */
    function subOperationRoles()
    {
        $roles = Role::where('type', 'operations')
            ->where('guard_name', 'web')->get()->mapWithKeys(function ($q) {
                return [$q->id => $q->name];
            });
        return $roles;
    }
}

if (!function_exists('operationStatus')) {
    /**
     * @return mixed
     */
    function operationStatus()
    {
        $roles = Status::where('type', 'operation')
            ->get()->mapWithKeys(function ($q) {
                return [$q->id => $q->name];
            });
        return $roles;
    }
}

if (!function_exists('Operations')) {
    /**
     * @return mixed
     */
    function Operations()
    {
        $operations = Admin::where('role', 'operations')
            ->get()->mapWithKeys(function ($q) {
                return [$q->id => $q->name];
            });
        return $operations;
    }
}

if (!function_exists('offices')) {
    /**
     * @return mixed
     */
    function offices()
    {
        $offices = Office::get()->mapWithKeys(function ($q) {
            return [$q->id => $q->name];
        });
        return $offices;
    }
}

if (!function_exists('user_can_control')) {
    function user_can_control($table)
    {
        $user = auth()->user();
        return $user->can('update ' . $table) || $user->can('delete ' . $table) || $user->can('read ' . $table);
    }
}


if (!function_exists('roleTypes')) {
    /**
     * @return mixed
     */
    function roleTypes()
    {
        $types = [
            'admin' => 'admin',
            // 'OperationManager' => 'Operation Manger',
            // 'superSales' => 'Super Sales',
            // 'superCommunity' => 'Super Community',
            // 'superOperation' => 'Super Operation',
            // 'sales' => 'sales',
            // 'community' => 'community',
            'operations' => 'operations'
        ];
        return $types;
    }
}

if (!function_exists('adminDbTablesPermissions')) {
    /**
     * @return mixed
     */
    function adminDbTablesPermissions()
    {
        $adminPermissions = [
            'admins', 'operations', 'brands_buttons', 'roles', 'brands', 'sub-brands', 'branches', 'influencers',
            'campaigns', 'group lists', 'setting', 'our_sponsors', 'contacts', 'pages', 'statistics',
            'faqs', 'articles', 'comments', 'replies', 'jobs', 'offices', 'match_campaigns', 'tasks', 'community' //, 'sales tabs', 'sales',

        ];
        return $adminPermissions;
    }
}

if (!function_exists('dbOperationManagerTables')) {
    /**
     * @return mixed
     */
    function dbOperationManagerTables()
    {
        $operationManagersPermissions = [
            'operations', 'brands', 'sub-brands', 'branches', 'influencers',
            'campaigns', 'group lists', 'match_campaigns', 'brands_buttons', 'tasks'
        ];
        return $operationManagersPermissions;
    }
}

if (!function_exists('dbSalesTables')) {
    /**
     * @return mixed
     */
    function dbSalesTables()
    {
        $salesPermissions = ['sales', 'influencers', 'campaigns', 'tasks'];
        return $salesPermissions;
    }
}

if (!function_exists('dbCommunityTables')) {
    /**
     * @return mixed
     */
    function dbCommunityTables()
    {
        $communityPermissions = ['operations', 'community', 'influencers', 'campaigns', 'tasks'];
        return $communityPermissions;
    }
}

if (!function_exists('dbOperationsTables')) {
    /**
     * @return mixed
     */
    function dbOperationsTables()
    {
        $operationsPermissions = [
            'operations', 'brands', 'sub-brand', 'branches', 'influencers',
            'campaigns', 'group lists', 'contacts', 'match_campaigns', 'brands_buttons', 'tasks'
        ];
        return $operationsPermissions;
    }
}

if (!function_exists('userPermissions')) {
    /**
     * @return mixed
     */
    function userPermissions($tbl = null)
    {
        if ($tbl) {
            $userPermissions = auth()->user()->getAllPermissions()
                ->filter(function ($q) use ($tbl) {
                    if (strpos($q->name, $tbl) !== false)
                        return $q;
                })
                //                ->where("name","like","%{$tbl}")
                ->pluck('id')->toArray();
        } else {
            $userPermissions = auth()->user()->getAllPermissions()->pluck('id')->toArray();
        }

        return $userPermissions;
    }
}

if (!function_exists('tblPermissions')) {
    /**
     * @return mixed
     *
     */

    function tblPermissions($tbl)
    {
        $user = auth()->user();
        if (in_array('superAdmin', $user->getRoleNames()->toArray())) {
            $tblPermissions = Permission::where('name', 'LIKE', "%{$tbl}")
                ->where('guard_name', 'web')->get();
        } else {

            $tblPermissions = Permission::where('name', 'LIKE', "%{$tbl}")
                ->whereIn('id', userPermissions())
                ->where('guard_name', 'web')->get();
        }

        return $tblPermissions;
    }
}

if (!function_exists('getLogoImage')) {
    /**
     * @return mixed
     */
    function getLogoImage()
    {
        $logo_image = Setting::first();
        if (isset($logo_image->image)) {
            return $logo_image->image;
        }
        return asset('assets/img/brand/logo.png');
    }
}

if (!function_exists('getCompanyName')) {
    /**
     * @return mixed
     */
    function getCompanyName()
    {
        $logo_image = Setting::first();
        if (isset($logo_image->company_name)) {
            return $logo_image->company_name;
        }
        return 'Grand Community';
    }
}

if (!function_exists('getBannerImage')) {
    /**
     * @return mixed
     */
    function getBannerImage()
    {
        $banner_image = Setting::first();
        if (isset($banner_image->banner)) {
            return $banner_image->banner;
        }
        return 'Grand Community';
    }
}

if (!function_exists('getCompanyNameAr')) {
    /**
     * @return mixed
     */
    function getCompanyNameAr()
    {
        $logo_image = Setting::first();
        if (isset($logo_image->company_name_ar)) {
            return $logo_image->company_name_ar;
        }
        return 'جراند كومينيتي';
    }
}

if (!function_exists('generateImageName')) {
    /**
     * @param $file
     * @return string
     */
    function generateImageName($file)
    {
        $fileNameWithExt = $file->getClientOriginalName();
        $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extention = $file->getClientOriginalExtension();
        $fileNameToStore = $filename . '_' . time() . '.' . $extention;
        return Str::snake($fileNameToStore);
    }
}


if (!function_exists('getImg')) {
    /**
     * @param $filename
     * @return string
     */
    function getImg($filename, $imageFolder)
    {

        if (!empty($filename)) {
            $base_url = url('/');
            return $base_url . '/storage/' . $imageFolder . '/' . $filename;
        } else {
            return '';
        }
    }
}



if (!function_exists('file_get_contents_curl')) {

    function file_get_contents_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}

if (!function_exists('brands')) {
    /**
     * @return mixed
     */
    function brands()
    {
        $brands = Brand::where('status', 1)->orderBy('id', 'DESC')->get()->mapWithKeys(function ($q) {
            return [$q->id => $q->name];
        });
        return $brands;
    }
}

if (!function_exists('all_brands')) {
    /**
     * @return mixed
     */
    function all_brands()
    {
        $brands = Brand::get()->mapWithKeys(function ($q) {
            return [$q->id => $q->name];
        });
        return $brands;
    }
}
if (!function_exists('subBrands')) {
    /**
     * @return mixed
     */
    function subBrands($brandId = null, $countriesIds = [])
    {
        $subBrands = Subbrand::query();
        if ($brandId) {
            $subBrands = $subBrands->where('brand_id', $brandId);
        }

        if(count($countriesIds) > 0){
            $subBrands = $subBrands->where(function ($q2) use ($countriesIds) {
                    foreach($countriesIds as $countryId) {
                        $q2->orWhereJsonContains('country_id', $countryId)->orWhereJsonContains('country_id', (string) $countryId);
                    }
                });
        }

        return $subBrands->where('status', 1)->get()->mapWithKeys(function ($q) {
            return [$q->id => $q->name];
        });
    }
}
if (!function_exists('branches')) {
    /**
     * @return mixed
     */
    function branches($brandId = null, $subBrandId = null, $countriesIds = [])
    {
        $branches = Branch::query();
        if ($brandId) {
            $branches = $branches->where('brand_id', $brandId);
        }

        if ($subBrandId) {
            $branches = $branches->where('subbrand_id', $subBrandId);
        }

        if (count($countriesIds) > 0) {
            $branches = $branches->whereIn('country_id', $countriesIds);
        }

        return $branches->where('status', "1")->get()->mapWithKeys(function ($q) {
            return [$q->id => $q->name];
        });
    }
}
if (!function_exists('countries')) {
    /**
     * @return mixed
     */
    function countries()
    {
        $countries = Country::all()->mapWithKeys(function ($q) {
            return [$q->id => $q->name];
        });
        return $countries;
    }
}

if (!function_exists('kmb')) {
    function kmb($num)
    {

        if ($num > 1000) {

            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;
        }

        return $num;
    }
}

if (!function_exists('handleInfluencerInterest')) {
    function handleInfluencerInterest($interest)
    {
        dd($interest);
    }
}

if (!function_exists('array_diff_fun')) {
    /**
     * @return mixed
     * Array1 Existing array which will compared with.
     * Array2 The new array need to compare.
     */
    function array_diff_fun($array1, $array2)
    {
        $diff = $array2;
        foreach ($array2 as $item) {
            if (!in_array($item, $array1)) {
                array_push($diff, $item);
            }
        }
        foreach ($array1 as $key => $item) {
            if (!in_array($item, $array2)) {
                if (in_array($item, $diff)) {
                    if (isset($diff[$key])) {
                        unset($diff[$key]);
                    }
                }
            }
        }
        return $diff;
    }
}

if (!function_exists('country')) {
    /**
     * @return mixed
     */
    function country($id)
    {
        $country = Country::find($id);
        return $country;
    }
}

if (!function_exists('brand')) {
    /**
     * @return mixed
     */
    function brand($id)
    {
        $brand = Brand::find($id);
        return $brand;
    }
}

if (!function_exists('campaignStatus')) {
    /**
     * @return mixed
     */
    function campaignStatus()
    {
        $campaignStatus = Status::where('type', 'campaign')
            ->whereNotIn('name', ['Finished', 'Canceled'])->get()->mapWithKeys(function ($q) {
                return [$q->value => $q->name];
            });
        return $campaignStatus;
    }
}


if (!function_exists('states')) {
    /**
     * @return mixed
     */
    function states()
    {
        $states = State::get()->mapWithKeys(function ($q) {
            return [$q->id => $q->name];
        });
        return $states;
    }
}

if (!function_exists('cities')) {
    /**
     * @return mixed
     */
    function cities()
    {
        $cities = City::get()->mapWithKeys(function ($q) {
            return [$q->id => $q->name];
        });
        return $cities;
    }
}

if (!function_exists('preferred_gender')) {
    /**
     * @return mixed
     */
    function preferred_gender()
    {
        $preferred_gender = [
            'male' => 'Male',
            'female' => 'Female',
            'both' => 'Both',
        ];
        return $preferred_gender;
    }
}

if (!function_exists('objective')) {
    /**
     * @return mixed
     */
    function objective()
    {
        $objective = [
            '1' => 'objective one',
            '2' => 'objective two',
            '3' => 'objective three',
        ];
        return $objective;
    }
}

if (!function_exists('status')) {
    /**
     * @return mixed
     */
    function status()
    {
        $status = [
            '1' => 'Active',
            '0' => 'Inactive',
        ];
        return $status;
    }
}

if (!function_exists('positions')) {
    /**
     * @return mixed
     */
    function positions()
    {
        $status = [
            '0' => 'Header',
            '1' => 'Footer',
        ];
        return $status;
    }
}

if (!function_exists('handleInputLanguage')) {
    /**
     * @return mixed
     */
    function handleInputLanguage($input)
    {

        return ['en' => $input[0], 'ar' => $input[1]];
    }
}

if (!function_exists('handleQueryInPagination')) {
    /**
     * @param $targetUrl
     * @param null $query
     * @return mixed|string
     */
    function handleQueryInPagination($targetUrl, $query = null)
    {
        if ($query && $targetUrl)
            return $targetUrl . '&' . http_build_query($query, '', '&amp;');
        elseif ($targetUrl)
            return $targetUrl;
        else
            return '';
    }
}


if (!function_exists('campaignStatus')) {
    /**
     * @return mixed
     */
    function campaignStatus()
    {
        $status = status::where('type', 'campaign')->get()->mapWithKeys(function ($q) {
            return [$q->value => $q->name];
        });
        return $status;
    }
}

if (!function_exists('createbrandCountries')) {
    /**
     * @return mixed
     */
    function createbrandCountries(array $country_ids, $brand, $status)
    {
        $items = collect($country_ids);
        $items->each(function ($item) use ($brand, $status) {
            BrandCountry::create(['country_id' => $item, 'brand_id' => $brand, 'status' => $status]);
        });
    }
}

if (!function_exists('campaignType')) {
    /**
     * @return mixed
     */
    function campaignType($objective = null)
    {
        $array = [];

        if(app()->getLocale() == 'en'){
            $array = ['0' => 'Visit', '1' => 'Delivery', '2' => 'Mix', '3' => 'Share', '4' => 'Post Creation'];
        }elseif(app()->getLocale() == 'ar'){
            $array = ['0' => 'زيارة', '1' => 'توصيل', '2' => 'مختلطة', '3' => 'مشاركة', '4' => 'كتابة منشور'];
        }

        if((int) $objective == 2){
            $array = \array_diff($array, ["0", "1", "2"]);
        }

        return $array;
    }
}


if (!function_exists('CampaignSearch')) {
    /**
     * @return mixed
     */
    function CampaignSearch()
    {
        $arr[] = (object)["id" => 0, "title" => ["en" => "Visit", "ar" => "زيارة"]];
        $arr[] = (object)["id" => 1, "title" => ["en" => "Delivery", "ar" => "توصيل"]];
        $arr[] = (object)["id" => 2, "title" => ["en" => "Mixed", "ar" => "مختلطة"]];
        $arr[] = (object)["id" => 3, "title" => ["en" => "Share", "ar" => "مشاركة"]];
        $arr[] = (object)["id" => 4, "title" => ["en" => "Post Creation", "ar" => "كتابة منشور"]];
        $arr = collect($arr)->map(function ($item) {
            return  ['id' => $item->id, 'title' => $item->title[app()->getLocale()]];
        });
        return $arr;
    }
}
if (!function_exists('getInfluencerStatus')) {
    /**
     * @return mixed
     */
    function getInfluencerStatus($status)
    {
        $arr = [];
        if ($status) {
            foreach ($status as $sta) {
                if ($sta == "0") {
                    array_push($arr, '<span class="badge badge-pill badge-success">Normal</span>');
                } elseif ($sta == "1") {
                    array_push($arr, '<span class="badge badge-pill badge-success">OutOfCountry</span>');
                } elseif ($sta == "2") {
                    array_push($arr, '<span class="badge badge-pill badge-success">Vip</span>');
                } elseif ($sta == "3") {
                    array_push($arr, '<span class="badge badge-pill badge-success">delivery_only</span>');
                }
            }
        }

        return $arr;
    }
}
if (!function_exists('getLang')) {
    /**
     * @return mixed
     */
    function getLang($lang)
    {

        if ($lang) {
            $arr = [];
            foreach ($lang as $sta) {
                if ($sta == "1") {
                    array_push($arr, '<span class="badge badge-pill badge-primary">Arabic</span>');
                } elseif ($sta == "2") {
                    array_push($arr, '<span class="badge badge-pill badge-primary">English</span>');
                } elseif ($sta == "3") {
                    array_push($arr, '<span class="badge badge-pill badge-primary">French</span>');
                } elseif ($sta == 0) {
                    array_push($arr, '<span class="badge badge-pill badge-danger">Not found</span>');
                }
            }
            return $arr;
        } else {
            return "----";
        }
    }
}

if (!function_exists('has_guests')) {
    function has_guests()
    {
        return ['0' => 'False', '1' => 'True'];
    }
}

if (!function_exists('has_voucher')) {
    function has_voucher()
    {
        return ['0' => 'False', '1' => 'True'];
    }
}
if (!function_exists('social_status')) {
    function social_status($status)
    {
        $data = '';
        switch ($status) {
            case 1:
                $data = 'Father';
                break;
            case 2:
                $data = 'Mother';
                break;
            case 3:
                $data = 'Single Father';
                break;
            case 4:
                $data = 'Single Mother';
                break;
        }
        return $data;
    }
}
if (!function_exists('campaignStatus')) {
    /**
     * @return mixed
     */
    function campaignStatus($status)
    {
        $campStatus = '';
        switch ($status->value) {
            case '0':
                $campStatus = '<span class="badge badge-pill badge-success">' . $status->name . '</span>';
                break;
            case '1':
                $campStatus = '<span class="badge badge-pill badge-primary">' . $status->name . '</span>';
                break;
            case '2':
                $campStatus = '<span class="badge badge-pill badge-danger">' . $status->name . '</span>';
                break;
            case '3':
                $campStatus = '<span class="badge badge-pill badge-secondary">' . $status->name . '</span>';
                break;
            default:
                $campStatus = '<span class="badge badge-pill badge-info">' . $status->name . '</span>';
                break;
        }
        return $campStatus;
    }
}

if (!function_exists('campaignStatusName')) {
    /**
     * @return mixed
     */
    function campaignStatusName($status)
    {
        $campStatus = '';
        if(app()->getLocale() == 'en'){

            switch ($status) {
                case '0':
                    $campStatus = 'Pending for Approval';
                    break;
                case '1':
                    $campStatus = 'Active';
                    break;
                case '2':
                    $campStatus = 'Finished';
                    break;
                case '3':
                    $campStatus = 'Canceled';
                    break;
                case '4':
                    $campStatus = 'Upcoming';
                    break;
                default:
                    $campStatus = 'Drafted';
                    break;
            }
        } else if (app()->getLocale() == 'ar'){

            switch ($status) {
                case '0':
                    $campStatus = 'قيد الانتظار';
                    break;
                case '1':
                    $campStatus = 'نشط';
                    break;
                case '2':
                    $campStatus = 'منتهي';
                    break;
                case '3':
                    $campStatus = 'ملغي';
                    break;
                case '4':
                    $campStatus = 'قادم';
                    break;
                default:
                    $campStatus = 'مسودة';
                    break;
            }
        }

        return $campStatus;
    }
}


if (!function_exists('campaignStatusLabels')) {
    /**
     * @return mixed
     */
    function campaignStatusLabels($status)
    {
        $campStatus = '';
        switch ($status) {
            case '0':
                $campStatus = '<span class="badge badge-pill badge-success">Pending</span>';
                break;
            case '1':
                $campStatus = '<span class="badge badge-pill badge-primary">Active</span>';
                break;
            case '2':
                $campStatus = '<span class="badge badge-pill badge-danger">Finished</span>';
                break;
            case '3':
                $campStatus = '<span class="badge badge-pill badge-secondary">Canceled</span>';
                break;
            default:
                $campStatus = '<span class="badge badge-pill badge-info">Confirmed</span>';
                break;
        }
        return $campStatus;
    }
}

if (!function_exists('campaignStatusWithoutLabels')) {
    /**
     * @return mixed
     */
    function campaignStatusWithoutLabels($status)
    {
        $campStatus = '';
        switch ($status) {
            case '0':
                $campStatus = 'Pending';
                break;
            case '1':
                $campStatus = 'Active';
                break;
            case '2':
                $campStatus = 'Finished';
                break;
            case '3':
                $campStatus = 'Canceled';
                break;
            default:
                $campStatus = 'Confirmed';
                break;
        }
        return $campStatus;
    }
}
if (!function_exists('campaignStatusData')) {
    function campaignStatusData()
    {
        return Status::whereType('campaign')->get();
    }
}
if (!function_exists('generateRandomCode')) {

    function generateRandomCode()
    {
        $string_char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string_char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = 3;
        $string_shuffled = substr(str_shuffle(str_repeat($string_char, ceil($length / strlen($string_char)))), 1, $length);
        $number_char = '0123456789';
        $number_shuffled = substr(str_shuffle(str_repeat($number_char, ceil($length / strlen($number_char)))), 1, $length);
        $shuffled = $string_shuffled . '' . $number_shuffled;
        $checkIfExist = Influencer::where('influ_code', $shuffled)->get()->count();
        if ($checkIfExist > 0) $shuffled = generateRandomCode();
        return $shuffled;
    }
}


if (!function_exists('generateRandomInfluencerId')) {

    function generateRandomInfluencerId()
    {

		$number_char = '0123456789';
        $length = 10;
        $number_shuffled = substr(str_shuffle(str_repeat($number_char, ceil($length / strlen($number_char)))), 1, $length);
        $shuffled = $number_shuffled;
        $checkIfExist = Influencer::where('vInflUuid', $number_shuffled)->count();
		if ($checkIfExist > 0) $shuffled = generateRandomInfluencerId();

        return $shuffled;
    }
}


if (!function_exists('generateQrcode')) {
    function generateQrcode($influencer, $is_test = false, $influencer_code = null)
    {

        $influencer_username = !empty($influencer->insta_uname) ? : 'influ';
        //$country_code = ($influencer->country) ? $influencer->country->code : 'kw';
        $qrcode = ($is_test) ? $influencer->insta_uname . '_' . time() . '_test_qrcode' . '.png' : $influencer->insta_uname . '_' . time() . '_qrcode' . '.png';
        $path = public_path('storage/photos/influencers/qrcode/');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $old_qrcode = (!empty($influencer->qrcode)) ? substr(strrchr($influencer->qrcode, '/'), 1) : '' ;
		if (!empty($old_qrcode) && file_exists(public_path('storage/photos/influencers/qrcode/'.$old_qrcode)))
			     @unlink(public_path('storage/photos/influencers/qrcode/'.$old_qrcode));

//        $influencerData = ["id" => $influencer->id, "insta_name" => $influencer_username, 'code' => $influencer_code?:$influencer->influ_code];
        $influencerData = ["id" => $influencer_code?:$influencer->influ_code, "insta_name" => $influencer_username]; //fixme::to avoid edit from frontend
        QrCode::size(500)
            ->backgroundColor(255, 255, 204)
            ->format('png')
            ->generate(json_encode($influencerData, true), $path . '/' . $qrcode);

        return $qrcode;
    }
}


if (!function_exists('campaignInfluencerStatus')) {
    function campaignInfluencerStatus($status)
    {
        return Status::where('type', 'campaign_influencers')->where('value', $status)->first();
    }
}


if (!function_exists('attitude')) {
    function attitude()
    {
        $attitude = [
            ["id" => 1, "name" => "bad"],
            ["id" => 2, "name" => "good"],
            ["id" => 3, "name" => "excellent"]
        ];
        return $attitude;
    }
}


if (!function_exists('campaignDetailsStatus')) {
    function campaignDetailsStatus($value)
    {
        $status = Status::where('type', 'campaign')
            ->where('id', $value)->first();
        return $status;
    }
}








if (!function_exists('edit_all')) {


    function edit_all($request, $role)
    {
        $selected_ids_new = explode(',', $request->selected_ids);
        if ($request->input('bulk_active')) {
            Admin::where('role', $role)->whereIn('id', $selected_ids_new)->where('id', '!=', auth()->id())->update(['active' => ($request->bulk_active == 1) ? '1' : '0',]);
        }
        if ($request->input('bulk_role_id')) {
            $role = Role::where('id', $request->bulk_role_id)->first();
            if ($role) {
                $admins = Admin::whereIn('id', $selected_ids_new)->get();
                $permissions = $role->permissions;
                foreach ($admins as $admin) {
                    $admin->syncRoles($role);
                    $admin->syncPermissions($permissions);
                }
            }
        }
    }
}

if (!function_exists('activeCountries')) {

    function activeCountries()
    {
        return Country::where('active', 1)->get();
    }
}

if (!function_exists('activeRoute')) {

    function activeRoute($route)
    {
        if (Route::CurrentRouteName() == $route)
            return 'active';
    }
}

if (!function_exists('default_statistics')) {

    function default_statistics()
    {
        $statistics = [
            ['title' => 'influencer', 'count' => 501, 'image' => '/front/images/rating.png', 'body' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'],
            ['title' => 'campaigns', 'count' => 401, 'image' => '/front/images/influencer.png', 'body' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'],
            ['title' => 'country', 'count' => 100, 'image' => '/front/images/planet.png', 'body' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'],
        ];
        return $statistics;
    }
}

function settings()
{
    return  Setting::first();
}

function checkIfNull($array)
{
    $check = true;
    foreach ($array as $val) {
        if (!is_null($val)) {
            $check = false;
            break;
        }
    }
    return $check;
}

if (!function_exists('nationalities')) {
    function nationalities()
    {
        return Nationality::whereActive(1)->get();
    }
}

if (!function_exists('getBrandCountries')) {

    function getBrandCountries($brand, $collective = false)
    {
       $countries =  $brand->countries()/*->where('active',1)*/->get();
        if (!$collective)
            return $countries;
        else
            return $countries->mapWithKeys(function ($q) {
                return [$q['id'] => $q['name']];
            });
    }

}

if (!function_exists('getSubBrandCountries')) {

    function getSubBrandCountries($brand, $collective = false)
    {
        $countries =  $brand->countries()/*->where('active',1)*/->get();
        if (!$collective)
            return $countries;
        else
            return $countries->mapWithKeys(function ($q) {
                return [$q['id'] => $q['name']];
            });
    }
}

if (!function_exists('getSubBrands')) {

    function getSubBrands($brand, $collective = false)
    {
        $subBrands =  $brand->subBrands()->get();
        if (!$collective)
            return $subBrands;
        else
            return $subBrands->mapWithKeys(function ($q) {
                return [$q['id'] => $q['name']];
            });
    }
}

if (!function_exists('nullHandle')) {

    function nullHandle($val)
    {
        $undefined = ['null', null];
        if (!in_array($val, $undefined))
            return $val;
        else
            return  null;
    }
}

if (!function_exists('mergeCodeWithPhone')) {

    function mergeCodeWithPhone($codesArray, $phoneArray): array
    {
        $phones = [];
        if (!empty($phoneArray)) {
            foreach ($phoneArray as $key => $phone)
                if (isset($key))
                    $phones[$codesArray[$key]] = $phone;
                else
                    $phones[] = $phone;
        }
        return  $phones;
    }
}

if (!function_exists('staticticsProfilePage')) {

    function staticticsProfilePage($id)
    {
        $statistics['totalInfluencers'] = ['title' => 'Total Influencers', 'id' => 'total_influencers', 'count' => Brand::withCount('influencers')->where('id', $id)->first()];
        $statistics['totalCamp'] = ['title' => 'Total Camp', 'id' => 'total_camp', 'count' => Campaign::where('brand_id', $id)->count()];
        $statistics['totalBranches'] = ['title' => 'Total Branches', 'id' => 'total_branches', 'count' => Branch::where('brand_id', $id)->count()];
        $statistics['totalSubBrands'] = ['title' => 'Total Sub-Brands', 'id' => 'total_sub_brands', 'count' => Subbrand::where('brand_id', $id)->count()];
        return $statistics;
    }
}


if (!function_exists('handlePlatform')) {
    function handlePlatform($channels)
    {


        $arr = [];
        $platForms = ['Instagram' => 1,  'Facebook' => 2, 'snapChat' => 3, 'Tiktok' => 4, 'Youtube' => 5];
        foreach ($channels as $channel) {
            $value =  array_search($channel, $platForms);

            $arr[] = $value;
        }
        return $arr;
    }
}

if (!function_exists('generateCode')) {

    /**generateCode
     * @return string
     */
    function generateCode(): string
    {
        $string_char = '26548';
        $length = 3;
        $string_shuffled = substr(str_shuffle(str_repeat($string_char, ceil($length / strlen($string_char)))), 1, $length);
        $number_char = '0123456789';
        $number_shuffled = substr(str_shuffle(str_repeat($number_char, ceil($length / strlen($number_char)))), 1, $length);
        $shuffled = $string_shuffled . '' . $number_shuffled;
        $checkIfExist = User::where('forget_code', $shuffled)->get()->count();
        if ($checkIfExist > 0) $shuffled = generateRandomCode();
        return $shuffled;
    }
}

if (!function_exists('PhoneCountryCode')) {

    function PhoneCountryCode($phonecode): string
    {
		$country = Country::where('phonecode',$phonecode)->first();
          return  ($country) ? strtoupper($country->code) : 'KW';

    }
}

if (!function_exists('checkDataNotRelatedToAdmin')) {

    /**checkDataNotRelatedToAdmin
     * @return string
     */
    function checkDataNotRelatedToAdmin($data): string
    {
        $is_admin = 'admin';
        if (strpos(Str::lower(str_replace(' ', '', $data)), "admin") !== false)
            $is_admin = $data;
        return $is_admin;
    }

    function campaignObjectives() //NOT USED
    {
        $arr[] = (object)['dataoption' => 'data-one', "id" => 1, "title" => "Application", "no_of_coverage" => 2, "names" => [['dataoption' => 'data-one', 'random' => 1, 'id' => 3, 'title' => 'GiftCoverage'], ['dataoption' => 'data-one', 'random' => 2, 'id' => 1, 'title' => "ApplicationCoverage"]]];
        $arr[] = (object)['dataoption' => 'data-two', "id" => 2, "title" => "Share", "no_of_coverage" => 1, "names" => [['dataoption' => 'data-two', 'random' => 3, 'id' => 1, 'title' => 'Coverage']]];
        $arr[] = (object)['dataoption' => 'data-three', "id" => 3, "title" => "Event", "no_of_coverage" => 2, "names" => [['dataoption' => 'data-three', 'random' => 4, 'id' => 2, 'title' => 'InvitationCoverage'], ['dataoption' => 'data-three', 'random' => 5, 'id' => 1, 'title' => 'VisitCoverage']]];
        $arr[] = (object)['dataoption' => 'data-four', "id" => 4, "title" => "Visit", "no_of_coverage" => 1, "names" => [['dataoption' => 'data-four', 'random' => 6, 'id' => 1, 'title' => 'Coverage']]];
        $arr[] = (object)['dataoption' => 'data-five', "id" => 5, "title" => "Delivery", "no_of_coverage" => 1, "names" => [['dataoption' => 'data-five', 'random' => 7, 'id' => 1, 'title' => 'Coverage']]];
        return $arr;
    }

    function updatedCampaignObjectives(){
        $arr = [];
        foreach (updatedCampaignObjectivesArray() as $key => $value){
            $arr[] = (object)['id'=>$key, 'title'=>$value];
        }
        return $arr;
    }

    function updatedCampaignObjectivesArray()
    {
        if (app()->getLocale() == 'en') {
            return [
                1 => "Brand Awarness",
                2 => "Website/app promote",
                3 => "Products",
                4 => "Events",
            ];
        } elseif (app()->getLocale() == 'ar') {
            return [
                1 => "التوعية بالعلامة التجارية",
                2 => "الترويج للموقع / التطبيق",
                3 => "المنتجات",
                4 => "الأحداث",
            ];
        }

        return [];
    }


    function getCampaignCoverageChannels()
    {
        $arr[] = (object)["id" => 1, "title" => "Instagram", "objectives" => drawSocailObjective('instagram')];
        $arr[] = (object)["id" => 2, "title" => "Facebook", "objectives" => drawSocailObjective('facebook')];
        $arr[] = (object)["id" => 3, "title" => "snapChat", "objectives" => drawSocailObjective('snapchat')];
        $arr[] = (object)["id" => 4, "title" => "Tiktok", "objectives" => drawSocailObjective('tiktok')];
        $arr[] = (object)["id" => 5, "title" => "Youtube", "objectives" => drawSocailObjective('youtube')];
        return $arr;
    }

    function drawSocailObjective($key = "instagram")
    {
        $postType = [
            ["id" => 1, "name" => "image"],
            ["id" => 2, "name" => "video"]
        ];
        if (in_array($key, ["instagram", "facebook"])) {
            $arr[] = ["key" => "post", "value" => "posts", "post_type" => $postType];
            $arr[] = ["key" => "reel", "value" => "reels", "post_type" => $postType];
        }
        if (in_array($key, ["instagram", "facebook", "snapchat", "tiktok"])) {
            $arr[] = ["key" => "story", "value" => "story", "post_type" => $postType];
        }
        if (in_array($key, ["youtube", "tiktok"])) {
            $arr[] = ["key" => "video", "value" => "video", "post_type" => $postType];
        }
        return $arr;
    }

if (!function_exists('randColor')) {
	function randColor() {
		return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
	}
}


    if (!function_exists('SubbrandStatus')) {
        /**
         * @return mixed
         */
        function SubbrandStatus()
        {
            if(app()->getLocale() == 'en'){
                $status = [
                    1 => 'Active',
                    0 => 'Inactive',
                ];
            }else if(app()->getLocale() == 'ar'){
                $status = [
                    1 => 'نشط',
                    0 => 'غير نشط',
                ];
            }
            return $status;
        }
    }

    function getCompliment(){
        $arr = [];
        foreach (complimentArray() as $key => $value){
            $arr[] = (object)['id'=>$key, 'title'=>$value];
        }
        return $arr;
    }
    if (!function_exists('currenciesList')) {
        function currenciesList()
        {
            return  Cache::remember('currencies-list', (60*24*3), function() {
                $path = "https://gist.githubusercontent.com/ksafranski/2973986/raw/5fda5e87189b066e11c1bf80bbfbecb556cf2cc1/Common-Currency.json";
                $list = [];
                foreach (json_decode(file_get_contents($path), true) as $key => $value){
                    $list[$key] = $value['code'];
                }
                return $list;
            });

        }
    }

    function complimentArray(){
        if (app()->getLocale() == 'en') {
            return [
                1 => 'Voucher',
                2 => 'Gift',
                3 => 'Both',
            ];
        } elseif (app()->getLocale() == 'ar') {
            return [
                1 => 'قسيمة',
                2 => 'هدية',
                3 => 'كلاهما',
            ];
        }

        return [];
    }
}


if (!function_exists('paginateQuery')) {
    /**
     * @return mixed
     */
    function paginateQuery($query, $start = 0, $length = 10)
    {
        if($start > 0){
            $page = ((int) $start + (int) $length)/$length;
        }else{
            $page = 1;
        }

        \request()->merge(['page' => $page]);

        return $query->paginate($length);
    }
}
