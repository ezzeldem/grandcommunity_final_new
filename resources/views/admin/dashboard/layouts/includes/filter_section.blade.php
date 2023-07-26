
<style>
.dropdown-check-list {
  display: inline-block;
}

.dropdown-check-list .anchor {
  position: relative;
  cursor: pointer;
  display: inline-block;
  padding: 5px 50px 5px 10px;

}

.dropdown-check-list .anchor:after {
  position: absolute;
  content: "";
  border-left: 2px solid black;
  border-top: 2px solid black;
  padding: 5px;
  right: 10px;
  top: 20%;
  -moz-transform: rotate(-135deg);
  -ms-transform: rotate(-135deg);
  -o-transform: rotate(-135deg);
  -webkit-transform: rotate(-135deg);
  transform: rotate(-135deg);
}

.dropdown-check-list .anchor:active:after {
  right: 8px;
  top: 21%;
}

.dropdown-check-list ul.items {
  padding: 2px;
  display: none;
  margin: 0;
  border: 1px solid #ccc;
  border-top: none;
}

.dropdown-check-list ul.items li {
  list-style: none;
}


.dropdown-check-list.visible .items {
  display: block;
}
.multiple_select_classification .btn-group {
            width: 100%;
            background-color: transparent !important;
        }
        .multiple_select_classification ul.multiselect-container{
            width: 100%;
            padding: 5px 10px;
            background: #111;
            border: 1px solid var(--border-color);
        }
        .multiple_select_classification li a,
        .multiple_select_classification li a:hover{
            color: #fff
        }
</style>


    @if (Route::currentRoutename() == 'dashboard.influences.index')

        <div id="selectinsidediv">
            <div class="filter-form hideForm filterFormInfluence-sidebar" id="influencer_filter_form" style="display: none">
                <div class="close_btn">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="accordion" id="accordionExample" style="width:100%">
                <div>
                    <div class="card-header" id="headingOne">
                        <button type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Personal Information </button>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Gender</label>
                                    <select data-name="Gender" class="form-control select2" name="Gender" id="gender">
                                        <option value=""></option>
                                        <option value="1"> Male </option>
                                        <option value="0"> Female </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Has Child</label>
                                    <select data-name="Have Child" class="form-control select2 " name="have_child" id="children_num">
                                        <option value=""> Select </option>
                                        <option value="1"> Yes </option>
										<option value="0"> No </option>
                                    </select>
                                </div>
                            </div>
                            @inject('language', 'App\Models\Language')
                            @php
                                $languages = $language->whereStatus(1)->get();

                            @endphp
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Language</label>
                                    <select data-name="Language" class="form-control select2" multiple name="Language"
                                        id="lang">
                                        @foreach ($languages as $key => $lang)
                                            <option value={{ $lang->id}}> {{ $lang->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Marital Status</label>
                                    <select data-name="Marital Status" class="form-control select2 " name="socialType_filter" id="socialType_id_search">
                                        <option value=""></option>
                                        @foreach ($filterData['socialStatus'] as $socila)
                                            <option value={{ $socila['id'] }}> {{ $socila['name'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Lifestyle</label>
                                    <select data-name="Lifestyle" class="form-control select2 " name="ethink_category" id="ethink_id_search">
                                        <option value=""> Select </option>

                                        @foreach ($filterData['ethinkCategory'] as $key => $ethink)
                                            <option value={{ $ethink['id'] }}> {{ $ethink['title'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Citizen Status</label>
                                    <select data-name="Citizen Status" class="form-control" name="citizen_status" placeholder="Select"
                                        id="citizen_status">
                                        <option value=""></option>
                                        @foreach ($filterData['citizenStatus'] as $key => $citizen)
                                            <option value={{ $citizen['id'] }}> {{ $citizen['title'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header" id="headingTwo">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Social Media Information </button>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Platforms</label>
                                    <select data-name="Platform" class="form-control select2"  name="platform_filter" id="platform_id_search">
                                      <option value=""></option>
									     @foreach ($filterData['socialCoverage'] as $key => $socialCov)
                                            <option value={{ $socialCov['key'] }}> {{ $socialCov['value'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

							<div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Verified</label>
                                    <select data-name="verified" class="form-control select2"  name="verified_filter" id="verified_id_search">
									<option value=""> select</option>
									<option value="1"> Yes</option>
									<option value="0"> No</option>
                                    </select>
                                </div>
                            </div>

							</div>
						<div class="row">
							<div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>followers</label>
									<div class="row">
									<div class="col-md-6">
                                    <input type="number" data-name="min followers" class="form-control" min="0"  name="min_followers" id="min_followers_id_search" placeHolder="min">
	                               </div><div class="col-md-6">
									<input type="number" data-name="max followers" class="form-control" min="0"  name="max_followers" id="max_followers_id_search" placeHolder="max">
	                              </div></div>
								</div>
                            </div>

							<div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Engagement</label>
									<div class="row">
									<div class="col-md-6">
                                    <select data-name="min_engagment" class="form-control" name="min_engagment" id="min_engagement_id_search" placeHolder="min">
									<option value="">From</option>
										<option value="0.1">0.1%</option>
										<option value="0.5">0.5%</option>

										<option value="1">1%</option>
										<option value="2">2%</option>
										<option value="3">3%</option>
										<option value="5">5%</option>
										<option value="7">7%</option>
										<option value="10">10%</option>
									</select>
	                               </div><div class="col-md-6">
								   <select data-name="max_engagment" class="form-control"  name="max_engagment" id="max_engagement_id_search" placeHolder="min">
								   <option value="">To</option>
										<option value="1">1%</option>
										<option value="2">2%</option>
										<option value="3">3%</option>
										<option value="5">5%</option>
										<option value="7">7%</option>
										<option value="10">>10%</option>
                                    </select>
								 </div></div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="card-header" id="headingThree">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Account information </button>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="row">
						<div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>channels</label>
                                    <select data-name="channels" class="form-control select2" multiple name="channel_filter" id="channel_id_search">
                                        @foreach ($filterData['socialCoverage'] as $key => $socialCov)
                                            <option value={{ $socialCov['key'] }}> {{ $socialCov['value'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Interests</label>
                                    <select data-name="Interests" class="form-control select2" multiple name="interests_filter" placeholder="Select"
                                        id="interests_id_search">
                                        @foreach ($filterData['interests'] as $interest)
                                            <option value={{ $interest->id }}> {{ $interest->interest  }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            @inject('category', 'App\Models\InfluencerClassification')
                            @php
                                $categories = $category->whereStatus('category')->get();
                            @endphp
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Categories</label>
                                    <div class="multiple_select_classification">
                                        <select data-name="category" name="category_ids[]" id="category" multiple="multiple" class="select2">
                                            @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Account Type</label>
                                    <select data-name="Account Type" class="form-control select2 " name="accountStatus_filter" id="accountStatus_id_search">
                                        <option value=""> Select </option>
                                        @foreach ($filterData['accountType'] as $key => $accountType)
                                            <option value={{ $accountType['id'] }}> {{ $accountType['title'] }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @inject('allStatus', 'App\Models\InfluencerClassification')
                            @php
                                $sta = $allStatus->whereStatus('classification')->get(['id','name']);
                            @endphp
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>classifictions</label>
                                    <div class="multiple_select_classification">
                                        <select  data-name="classification" name="classification_ids[]" class="select2" id="chkveg" multiple="multiple">
                                            @foreach ($sta as $stat)
                                            <option value="{{ $stat->id }}">{{ $stat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

							<div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Without Classification</label>
                                    <select data-name="without Interests" class="form-control select2" multiple name="not_has_multi_classification" placeholder="Select"
                                        id="not_has_multi_classification">
                                          @foreach ($sta as $stat)
                                            <option value="{{ $stat->id }}">{{ $stat->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>

							<div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Has Voucher</label>
                                    <select data-name="Has Voucher" class="form-control" name="min_voucher"
                                            id="min_voucher">
                                        <option value="">Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-header" id="headingFour">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> Location </button>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Countries</label>
                                    <select data-name = "Countries" class="form-control select-to-get-other-options select2"  name="country_id" id="country_id_search"  data-other-id="#state_id_search" data-other-name="country_id" data-other-to-reset="#city_id_search" data-url="{{route('dashboard.getStatesListByCountryId')}}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputs mb-4" style="">
                                    <label>Government</label>
                                        <select class="form-control select-to-get-other-options select2" id="state_id_search" name="state_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2"  data-other-id="#city_id_search" data-other-name="state_id" data-url="{{route('dashboard.getCitiesListByStateId')}}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>City</label>
                                    <select class="form-control select2" id="city_id_search" name="city_id"
                                        data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputs mb-4">
                                    <label>Nationality</label>
                                    <select data-name="Nationality" class="form-control select2 " multiple name="nationality" id="nationality_id_search">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-header" id="headingFive" style="display: none;">
                        <button type="button" data-toggle="collapse" data-target="#collapseFive" aria-controls="collapseFive"> Companies Favorites/Unfavorites </button>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample"  style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="inputs mb-4">
                                    <label>Company</label>
                                    <select class="form-control" name="company" id="favourite-company">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="inputs mb-4">
                                    <label>Type</label>
                                    <select class="form-control select2" name="company_favourite_type" id="unfavourite-or-favourite-company">
                                        <option value="">Select type</option>
                                        <option value="favourite">Favourite</option>
                                        <option value="unfavourite">Unfavourite</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                </div>
                <div class="search_reset_btns">
                    <button class="btn btn-primary mt-3 mr-1 " id="filter"><i class="fab fa-searchengin"></i>
                        Search</button>
                    <button class="btn mt-3" id="reset_brand_filter_form"><i class="fas fa-retweet text-white"></i>
                        Reset</button>
                </div>
            </div>
        </div>
        <!-- //-------------------------------------------------------------------------------------------------------------------------- -->
        @elseif(Route::currentRoutename() == 'dashboard.brands.index')
        <div class="filter-form" id="filter-form">
            <div class="inputs mb-4">
                <label>Countries</label>
                <select data-filter="country_val" data-selected="Countries" class="form-control select2" id="all_country_id_search"
                    name="country_id_search" data-parsley-class-handler="#slWrapper2"
                    data-parsley-errors-container="#slErrorContainer2" multiple="multiple">

                    @foreach ($all_countries_data as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class=" inputs mb-4">
                <label>Company Status</label>
                <select class="form-control select2" name="status_id_search" id="status_id_search">
                    <option value="0" {{ isset($filterBrandStatus) ? ($filterBrandStatus == 0 ? 'selected' : '') : '' }}>
                        Pending
                    </option>
                    <option value="1" {{ isset($filterBrandStatus) ? ($filterBrandStatus == 1 ? 'selected' : '') : '' }}>
                        Active
                    </option>
                    <option value="2"{{ isset($filterBrandStatus) ? ($filterBrandStatus == 2 ? 'selected' : '') : '' }}>
                        Inactive
                    </option>
                    <option value="3" {{ isset($filterBrandStatus) ? ($filterBrandStatus == 3 ? 'selected' : '') : '' }}>
                        Rejected
                    </option>
                </select>
            </div>
            <div class=" inputs mb-4">
                <label>Campaign Status</label>
                <select class="form-control select2" name="campaign_id_search" id="campaign_id_search"
                    data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2"
                    multiple="multiple">
                    @foreach ($campaign_status as $status)
                        <option value="{{ $status->value }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class=" inputs mb-4">
                <label>Date</label>
                <div id="reportrange" class="form-control">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                    <input type="hidden" value="startDateSearch" id="startDateSearch" name="startDateSearch">
                    <input type="hidden" value="endDateSearch" id="endDateSearch" name="endDateSearch">
                  </div>
            </div>

            {{-- <div class=" inputs mb-4">
                <label>Headquarter</label>
                <select class="form-control select2" name="office_id_search" id="office_id_search"
                    data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
                    <option value="" selected>Select</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}">{{ $office->name }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div class="inputs mb-4">
                <label>Profile is completed</label>
                <select data-name="Completed" class="form-control select2" name="completed_profile_search" id="completed_profile_search">
                    <option value="" selected>Select</option>
                    <option value="1"> Completed </option>
                    <option value="2"> Uncompleted </option>
                </select>
            </div>

            <!-- <div class="inputs mb-4">
                <label>Pending</label>
                <select data-name="Completed" class="form-control select2" name="pending_search" id="pending_search">
                    <option value="" selected> Select </option>
                    <option value="1"> Group of brands </option>
                    <option value="2"> Branches </option>
                </select>
            </div> -->

            <!-- <div class="inputs mb-4">
                <label>Latest Collaboration</label>
                <select data-name="Completed" class="form-control select2" name="lastest_collaboration_search" id="lastest_collaboration_search">
                    <option value="" selected> Select </option>
                    <option value="0"> Month </option>
                    <option value="1"> 3 Month </option>
                    <option value="2"> 6 Month </option>
                    <option value="3"> A Year </option>
                </select>
            </div> -->

            <div class="search_reset_btns">
                <button type="button" class="btn btn-primary mt-3 mr-1" id="filter"><i
                        class="fab fa-searchengin" ></i> Search</button>
                <button class="btn btn-danger mt-3" id="rest"><i class="fas fa-retweet"></i> Reset</button>
            </div>
        </div>


        @elseif(Route::currentRoutename() == 'dashboard.sub-brands.index')
        <div class="filter-form" id="filter-form">
            <div class="mb-4 inputs">
                <label>Countries</label>
                <select class="mySelect2 form-control select2" name="country_id_search[]" id="country_id_search">
                    <option></option>
                    @foreach (countries() as $key => $country)
                        <option value="{{ $key }}">{{ $country }}</option>
                    @endforeach
                </select>
            </div>

            <div class="inputs mb-4  filter-input">
                <label class="form-label">Companies</label>
                {!! Form::select('brands_status[]', all_brands(), null, [
                    'class' => 'mySelect2 form-control select2 ',
                    'data-show-subtext' => 'true',
                    'data-live-search' => 'true',
                    'id' => 'brands_status',
                    'placeholder' => 'Select',
                ]) !!}
            </div>
            <div class="inputs mb-4  filter-input">
                <label class="form-label">Status</label>
                {!! Form::select('status_id_search', status(), null, [
                    'class' => 'mySelect2 form-control select2 ',
                    'id' => 'status_id_search',
                    'placeholder' => 'Select',
                ]) !!}
            </div>
            <div class=" inputs mb-4 filter-input">
                <label>Date</label>
                <div id="reportrange" class="form-control">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                    <input type="hidden" value="" id="startDateSearch" name="startDateSearch">
                    <input type="hidden" value="" id="endDateSearch" name="endDateSearch">
                </div>
            </div>

            <div class="search_reset_btns">
                <button type="button" class="btn btn-primary mt-3 mr-1" id="filter">
                    <i class="fab fa-searchengin mr-1"></i>Search
                </button>

                <button type="button" class="btn btn-primary mt-3 mr-1" id="reset_sub_brand">
                    <i class="fab fa-searchengin mr-1"></i>Reset
                </button>
            </div>
        </div>
    @elseif(Route::currentRoutename() == 'dashboard.branches.index')
        <div class="filter-form" id="filter-form">
            <div class="inputs mb-4 filter-input">
                <label class="form-label">Countries</label>
                {!! Form::select('country_id_search', countries(), null, [
                    'class' => 'form-control select2 ',
                    'placeholder' => 'select country',
                    'onchange' => 'getBrand(event)',
                    'data-show-subtext' => 'true',
                    'data-live-search' => 'true',
                    'id' => 'country_id_search',
                ]) !!}
            </div>
            <div class="inputs mb-4 filter-input">
                <label class="form-label">brands</label>
                {!! Form::select('brand_id', brands(), null, [
                    'class' => 'form-control select2 ',
                    'placeholder' => 'select',
                    'onchange' => 'getsubBrands(event)',
                    'data-show-subtext' => 'true',
                    'data-live-search' => 'true',
                    'id' => 'brand_id_search',
                ]) !!}
            </div>
            <div class="inputs mb-4 filter-input">
                {{-- subBrands() --}}
                <label class="form-label">Group Of Brand</label>
                {!! Form::select('subbrand_id', [], null, [
                    'class' => 'form-control select2 ',
                    'placeholder' => 'select sub brand',
                    'data-show-subtext' => 'true',
                    'data-live-search' => 'true',
                    'id' => 'subbrand_id_search',
                ]) !!}
            </div>
            <div class="inputs mb-4 filter-input">
                <label class="form-label">status</label>
                {!! Form::select('status_id_search', status(), null, [
                    'class' => 'form-control select2 select_input',
                    'id' => 'status_id_search',
                    'placeholder' => 'select',
                ]) !!}
            </div>
            {{-- <div class="inputs filter-input" > --}}
            {{-- <label class="form-label">city</label> --}}
            {{-- {!! Form::text('city',null,['class' =>'form-control text_input','placeholder'=> 'Enter City','id'=>'city_search' ]) !!} --}}
            {{-- </div> --}}
            <div class=" inputs mb-4 filter-input">
                <label>Date</label>
                <div id="reportrange" class="form-control">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                    <input type="hidden" value="" id="startDateSearch" name="startDateSearch">
                    <input type="hidden" value="" id="endDateSearch" name="endDateSearch">
                </div>
            </div>
            <div class="search_reset_btns">
                <button type="button" class="btn btn_search btn-primary mt-3 mr-1" id="go_search">
                    <i class="fab fa-searchengin mr-1"></i>Search
                </button>
                <button type="button" class="btn btn_search btn-primary mt-3 mr-1" id="reset_branches">
                    <i class="fab fa-searchengin mr-1"></i>Reset
                </button>

                {{-- <button class="btn btn-danger mt-3" id="rest" ><i class="fas fa-retweet  mr-1"></i>Reset</button> --}}
            </div>
        </div>
        @elseif(Route::currentRoutename() == 'dashboard.campaigns.index')

        <section class="filter-form" id="filterSection">
            <div class="mb-4 inputs">
                <label>Countries</label>
                {!! Form::select('country_id_search[]', countries(), null, [
                    'class' => 'form-control select2 ',
                    'data-show-subtext' => 'true',
                    'data-live-search' => 'true',
                    'id' => 'country_id_search',
                    'multiple',
                ]) !!}
            </div>
            <div class="mb-4 inputs">
                <label>Status</label>
                <select class="form-control select2" name="campaign_status_search" id="campaign_status_search">
                    <option selected readonly disabled>Select</option>
                    @foreach ($status as $camp_status)
                        <option value="{{ $camp_status->value }}">{{ $camp_status->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4  inputs">
                <label>Type</label>
                <select class="form-control select2" name="campaign_type_search" id="campaign_type_search">
                    <option selected readonly disabled>Select</option>

                    @foreach ($types as $type)
                        <option value="{{ $loop->index }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4  inputs">
                <label>Date</label>
                <div id="reportrange" class="form-control">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                    <input type="hidden" value="startDateSearch" id="startDateSearch" name="startDateSearch">
                    <input type="hidden" value="endDateSearch" id="endDateSearch" name="endDateSearch">
                </div>
            </div>
            <div class="search_reset_btns" style="margin-top:29.2px">
                <button class="btn btn_search hvr-sweep-to-right mr-1" id="go_search"><i
                        class="fab fa-searchengin mr-1"></i> Search</button>
                <button class="btn text-white hvr-sweep-to-right" id="rest"><i class="fas fa-retweet"></i> Reset</button>
            </div>
        </section>
    @elseif(Route::currentRoutename() == 'dashboard.operations.index')
        <div class="filter-form" id="filter-form">
            <div class="" class="inputs filter-input">
                <label class="form-label">status</label>
                {!! Form::select('status_id_search', status(), null, [
                    'class' => 'form-control select2 ',
                    'id' => 'status_id_search',
                    'placeholder' => 'Select',
                ]) !!}
            </div>
            <div class="  mt-2 inputs filter-input">
                <label>Date</label>
                <div id="reportrange" class="form-control">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                    <input type="hidden" value="" id="startDateSearch" name="startDateSearch">
                    <input type="hidden" value="" id="endDateSearch" name="endDateSearch">
                </div>
            </div>
            <div class="search_reset_btns">
                <button type="button" class="btn btn_search mt-3 mr-1" id="go_search">
                    <i class="fab fa-searchengin mr-1"></i>Search
                </button>
            </div>

        </div>
    @elseif(Route::currentRoutename() == 'dashboard.admins.index')
        <div class="filter-form" id="filter-form">
            <div class="inputs">
                <label class="form-label">Status</label>
                {!! Form::select('status_id_search', status(), null, [
                    'class' => 'form-control select2 ',
                    'id' => 'status_id_search',
                    'placeholder' => 'Select',
                ]) !!}
            </div>
            <div class="inputs">
                <label>Date</label>
                <div id="reportrange" class="form-control">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                    <input type="hidden" value="" id="startDateSearch" name="startDateSearch">
                    <input type="hidden" value="" id="endDateSearch" name="endDateSearch">
                </div>
            </div>
            <div class="search_reset_btns">
                <button type="button" class="btn btn-success btn_search mt-3 mr-1" id="go_search">
                <i class="fas fa-search"></i> Search
                </button>
                <button type="button" class="btn btn_search btn-primary mt-3 mr-1" id="reset_admins">
                <i class="far fa-times-circle"></i> Reset
                </button>
            </div>
        </div>
    @elseif(Route::currentRoutename() == 'dashboard.sales.index')
        <div class="filter-form" id="filter-form">
            <div class="inputs filter-input">
                <label class="form-label">status</label>
                {!! Form::select('status_id_search', status(), null, [
                    'class' => 'form-control select2 ',
                    'id' => 'status_id_search',
                    'placeholder' => 'select',
                ]) !!}
            </div>
            <div class=" inputs filter-input">
                <label>Date</label>
                <div id="reportrange" class="form-control">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                    <input type="hidden" value="" id="startDateSearch" name="startDateSearch">
                    <input type="hidden" value="" id="endDateSearch" name="endDateSearch">
                </div>
            </div>
            <div class="search_reset_btns  mt-3">
                <button type="button" class="btn btn-success btn_search mt-3 mr-1" id="go_search">
                    <i class="fab fa-searchengin mr-1"></i>Search
                </button>
                <button type="button" class="btn btn_search btn-primary mt-3 mr-1" id="reset_sales">
                    <i class="fab fa-searchengin mr-1"></i>Reset
                </button>
            </div>

        </div>
    @endif
    @push('js')
    <script src="https://unpkg.com/bootstrap-multiselect@0.9.13/dist/js/bootstrap-multiselect.js"></script>
        <script>
            $(document).ready(function() {
                $("#favourite-company").select2({
                    ajax: {
                        url: "/dashboard/allbrands/0",
                        dataType: 'json',
                        delay: 250,
                        data: function (term, page) {
                            return {
                                q: term, // search term
                                page_limit: 10,
                                page: page
                            };
                        },
                        processResults: function (data, params) {
                            // parse the data and format it into Select2 options
                            var options = data.results;

                            // return the formatted options
                            return {
                                results: options
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1 // set the minimum number of characters for a search term
                });
            });

 $(function() {
     // $('#favourite-company').select2(
     //     {
     //         placeholder: "Select Companies",
     //         minimumInputLength: 1,
     //         multiple: true,
     //         ajax: {
     //             url: "/dashboard/allbrands/0",
     //             dataType: 'json',
     //             quietMillis: 100,
     //             data: function (term, page) {
     //                 return {
     //                     q: term,
     //                     page_limit: 10,
     //                     page: page //you need to send page number or your script do not know witch results to skip
     //                 };
     //             },
     //             results: function (data, page)
     //             {
     //                 var more = (page * 10) < data.total;
     //                 return { results: data.results, more: more };
     //             },formatResult: Repoformat,
     //             formatSelection: Repoformat,
     //             escapeMarkup: function (m) { return m; },
     //             dropdownCssClass: "bigdrop"
     //         }
     //     });

// $('#chkveg').multiselect({
// allSelectedText: 'All Classification Already Selected',
// numberDisplayed: 10,
// });
// $('#not_multi_classification').multiselect({
// allSelectedText: 'All Classification Already Selected',
//
// })
// $('#category').multiselect({
// allSelectedText: 'All Classification Already Selected',
// numberDisplayed: 10,
// });
});
$('#lang').select2();

 var checkList = document.getElementById('list1');

            $(document).ready(function() {
                if($('#country_id_search').length){
                    document.getElementById('country_id_search').multiple
                }
                if($('#all_country_id_search').length){
                    document.getElementById('all_country_id_search').multiple
                }

                $('#nationality_id_search').select2({
                    placeholder: 'Select',
                    ajax: {
                        url: '{{ url('/dashboard/get_nationalities') }}',
                        type: "get",
                        dataType: 'json',
                        delay: 150,
                        data: function(params) {
                            return {
                                '_token': '{{ csrf_token() }}',
                                search: params.term // search term
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: $.map(response['data'], function(item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });

                $('#country_id_search').select2({

                    placeholder: 'Select',
                    ajax: {
                        url: '{{ url('/dashboard/get_countries') }}',
                        type: "get",
                        dataType: 'json',
                        delay: 150,
                        data: function(params) {
                            return {
                                '_token': '{{ csrf_token() }}',
                                search: params.term // search term
                            };
                        },
                        processResults: function(response) {
                            $('#state_id').html('');
                            $('#city_id').html('');
                            return {
                                results: $.map(response['data'], function(item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });


            // $('#state_id_search').select2({
            // placeholder: 'Select',
            //     ajax: {
            //         url: '{{ url('/dashboard/get_governorate') }}',
            //         type: "get",
            //         dataType: 'json',
            //         delay: 150,
            //         data: function(params) {
            //             return {
            //                 '_token': '{{ csrf_token() }}',
            //                 search: params.term, // search term
            //                 country_id: $('#country_id_search').val()
            //             };
            //         },
            //         processResults: function(response) {
            //             return {
            //                 results: $.map(response['data'], function(item) {
            //                     return {
            //                         text: item.name,
            //                         id: item.id
            //                     }
            //                 })
            //             };
            //         },
            //         cache: true
            //     }
            // });

                $('#check_status').select2({
                    placeholder: 'Select',
                    ajax: {
                        url: '{{ url('/dashboard/get_status') }}',
                        type: "get",
                        dataType: 'json',
                        delay: 150,
                        data: function(params) {
                            return {
                                '_token': '{{ csrf_token() }}',
                                search: params.term // search term
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: $.map(response['data'], function(item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });

            });




 $(document).on('click','#reset_brand_filter_form',function() {
     if ($('#filter-form').find("select".length > 0)) {
         $('#filter-form').find("select").each(function() {
             $(this).val(null).trigger("change");
         });
     }
     $('#reportrange span').empty();
     $('#startDateSearch').val('');
     $('#endDateSearch').val('');
     $('.badges_container_multiple').html('');
     $('#influencer_filter_form input').val('');
     $('#influencer_filter_form select').val('').trigger('change');
     influe_tabels.ajax.reload();
 })

            let country_id = null

            function getBrand(event) {
                country_id = event.target.value;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    contentType: "application/json; charset=utf-8",
                    url: `/dashboard/get-brands-by-country/${country_id}`,
                    corssDomain: true,
                    dataType: "json",
                    success: function(data) {
                        let brands = data.data;
                        $("#brand_id_search").html('')
                        $("#brand_id_search").append(`
                            <option value=""></option>`);
                        brands.forEach((brand) => {
                            $("#brand_id_search").append(`
                            <option value="${brand.id}">${brand.name}</option>
                        `)
                        })
                    },
                    error: function(data) {

                    }
                });
            }

            function getsubBrands(event) {
                let brand_id = event.target.value;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    contentType: "application/json; charset=utf-8",
                    url: `/dashboard/get-subbrand-by-brand/${country_id}/${brand_id}`,
                    corssDomain: true,
                    dataType: "json",
                    success: function(data) {
                        let subbrands = data.data;
                        $("#subbrand_id_search").html('')
                        $("#subbrand_id_search").append(`
                            <option value=""></option>`);
                        subbrands.forEach((subbrand) => {
                            $("#subbrand_id_search").append(`
                            <option value="${subbrand.id}">${subbrand.name}</option>
                        `)
                        })
                    },
                    error: function(data) {

                    }
                });

            }
        </script>
    @endPush


