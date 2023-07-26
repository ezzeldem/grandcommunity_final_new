<?php

namespace App\Http\Controllers\API;

use App\Models\Job;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Article;
use App\Models\Country;
use App\Models\Interest;
use App\Models\Language;
use App\Models\GroupList;
use App\Models\CaseStudies;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Traits\GroupListTraits;
use App\Http\Resources\API\JobsResource;
use App\Http\Resources\API\CompleteDateResource;

class SpinnersController extends Controller
{
    use ResponseTrait,GroupListTraits;

    public function __construct(){
        $this->middleware('auth:sanctum')->except(['getStates','languages','getStateCities','getCountryCities']);
    }

    public function countries(){
        $user = auth()->user();
        if($user->type == 0 && $brand = $user->brands){
            return $this->returnData('countries',  getBrandCountries($brand), 'countries returned successfully');
        }else{
            return $this->returnError('','will access from influencer');
        }

    }


    public function getAccessories(){

        $data = [
            'nationalities' => nationalities(),
            'getLanguages' => Language::all(),
            'interests' => Interest::whereStatus(1)->get(),
        ];
        return $this->returnData('data',$data);
    }

    public function influ_social_type(User $user){
        return $this->returnData('influencers_social_type',$user->getInfluencerSocialType());
    }

    public function languages(){
        $languages = Language::select('id','name','status')->get();
        return $this->returnData('languages',$languages);
    }

    public function jobs(){
        $allJobs = Job::where('status',1)->get();
        return $this->returnData('allJobs', JobsResource::collection($allJobs), 'Jobs returned successfully');

    }



    public function cities(){
        $user = auth()->user();
        if($user->type == 0 && $brand = $user->brands){
            $citiesData = $brand->countries()->select('id','name')
                ->where('active',1)
                ->when(\request('countries'),function ($q){
                    $countries = is_array(\request('countries'))?\request('countries'):explode(',',\request('countries'));
                    $q->whereIn('id',$countries);
                })
                ->with('cities')->get();
            if (\request()->has('multiple') && \request('multiple') == true){
                $cities = $citiesData->mapWithKeys(function ($q){
                    return[$q->name=>$q->cities];
                });
            }else{
                $cities = $citiesData->flatMap(function ($q){
                    return $q->cities;
                });
            }
            return $this->returnData('cities', $cities, 'cities returned successfully');
        }else{
            return $this->returnError('','will access from influencer');
        }

    }

	public function getSubBands(){
        $user = auth()->user();
        if($user->type == 0 && $brand = $user->brands){
            $sub_brands = $brand->subbrands()->select('id','name')->where('status',1)
                ->when(\request('countries'),function ($q)use ($brand){
                    $countries = is_array(\request('countries'))?\request('countries'):explode(',',\request('countries'));
							$q->where(function ($query) use ($countries) {
										for ($j = 0; $j < count($countries); $j++) {
											$query->orWhereJsonContains('country_id', "{$countries[$j]}");
										}
							});
                })->get();
                
            
            return $this->returnData('sub_brands', $sub_brands, 'sub_brands returned successfully');
        }else{
            return $this->returnError('','will access from influencer');
        }
    }

    public function getBranches(){
        $user = auth()->user();
        if ($user->type == 0 && $brand = $user->brands){
            $branches = $brand->branchs()->select('id','name')/*->where('status',1)*/
                ->when((\request('countries')&& \request('countries')!=null),function ($q){
                    $countries = is_array(\request('countries'))?\request('countries'):explode(',',\request('countries'));
                    $q->whereIn('country_id',$countries);
                })
                ->when((\request('sub_brand') && \request('sub_brand')!=null),function ($q){
                    $q->whereHas('subbrand',function ($t){
                        $t->where('id',\request('sub_brand'))
                            ->where('status',1);
                    });
                })->get();
            return $this->returnData('branches', $branches, 'branches returned successfully');
        }else{
            return $this->returnError('','will access from influencer');
        }
    }

    public function getBrandBranches(){
        $user = auth()->user();
        if ($user->type == 0 && $brand = $user->brands){
            $branches = $brand->branchs()->where('brand_id', $user->brands->id)->select('id','name','subbrand_id')->where('status',1)
                ->when((\request('countries')&& \request('countries')!=null),function ($q){
                    $countries = is_array(\request('countries'))?\request('countries'):explode(',',\request('countries'));
                    $q->whereIn('country_id',$countries);
                })->get()->map(function ($q){$q['has_sub_brand']=$q->subbrand_id!=0?true:false;return$q;});
            return $this->returnData('branches', $branches, 'branches returned successfully');
        }else{
            return $this->returnError('','will access from influencer');
        }
    }

    public function getGroupList(){

        $user = auth()->user();
		$countries = [];
		if(\request('countries') && !empty(\request('countries')))
           $countries = is_array(\request('countries'))?\request('countries'):explode(',',\request('countries'));

        if ($user->type == 0 && $brand = $user->brands){
            $groups =$this->brandGroupList($brand,$countries);
           
            return $this->returnData('groups', $groups, 'groups returned successfully');
        }else{
            return $this->returnError('','will access from influencer');
        }
    }

    public function getStates(Country $country){
         $states = $country->states()->has('cities')->get();
        return $this->returnData('states', $states, 'states returned successfully');
    }

    public function getStateCities(State $state){
        $cities = $state->cities()->select('id','name','state_id')->get();
        return $this->returnData('cities', $cities, 'cities returned successfully');
    }

    public function getCountryCities(Country $country){
        $cities = $country->cities;
        return $this->returnData('cities', $cities, 'cities returned successfully');
    }

    public function getCompleteProfileData(){

        $user = auth()->user();
        $step='';
//        dd($user->brands->step);
        if($user->type==0)
            ($user->brands->step)?$step=$user->brands->step:$step=1;
        else
            ($user->influencers->whats_number)?$step=2:(($user->influencers->social_type)?$step=3:$step=1);

        $data = [
            'nationalities' => nationalities(),
            'getLanguages' => Language::all(),
            'interests' => Interest::whereStatus(1)->get(),
            'step'=>$step
        ];

        return new CompleteDateResource($data);


    }


}
