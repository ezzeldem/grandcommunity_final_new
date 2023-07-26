@php
$selectedCountry = isset($influencer)?$influencer->country:null;
$selectedState = isset($influencer)?$influencer->state:null;
@endphp
<div class="col-md-12">
  <div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="grand-gray-box">
        <i class="fa-solid fa-note-sticky"></i>
        <h4 class="title">
          Basic Information
        </h4>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="grand-gray-box">
        <i class="fa-solid fa-copy"></i>
        <h4 class="title">
          Classification
        </h4>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="grand-gray-box">
        <i class="fa-solid fa-children"></i>
        <h4 class="title">
          Marital Status
        </h4>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="grand-gray-box">
        <i class="fa-solid fa-link"></i>
        <h4 class="title">
          Authentication
        </h4>
      </div>
    </div>
  </div>
</div>
<div class="col-12 social_media_card accordion create_form" id="accordionExample">
  <!-- <h5 class="mt-3"><i class="fas fa-link"></i> General</h5>
    <div class="btns_filter_section">
        <a href="#Information">
            <img src="{{asset('assets/img/vector.png')}}" alt="">
            <span> Basic Info </span>
        </a>
        <a href="#Number">
            <img src="{{asset('assets/img/icons8-phone-50.png')}}" alt="">
            <span> Phone Number </span>
        </a>
        <a href="#AddNumber">
            <img src="{{asset('assets/img/icons8-phone-call-64.png')}}" alt="">
            <span> Additional phone number </span>
        </a>
        <a href="#Media">
            <img src="{{asset('assets/img/icons8-media-64.png')}}" alt="">
            <span> Social media </span>
        </a>
        <a href="#class">
            <img src="{{asset('assets/img/vector-w.png')}}" alt="">
            <span> Classification </span>
        </a>
        <a href="#Martial">
            <img src="{{asset('assets/img/vector-q.png')}}" alt="">
            <span> Martial status </span>
        </a>
        <a href="#Auth">
            <img src="{{asset('assets/img/vector-e.png')}}" alt="">
            <span> Martial status </span>
        </a>
    </div> -->
  <!-- <hr> -->
  <div class="row justify-content-center">
    <div class="col-12 mt-4">
      <div class="grand-content-box">
        <div class="row justify-content-center">
          <div class="col-md-12 col-12 mb-4 title_form" id="Information">
            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
              data-target="#collapseInformation" aria-expanded="true" aria-controls="collapseInformation">
              Information
            </button>
            <!-- <h6> <i class="far fa-user mr-2"></i> Information  </h6> -->
          </div>
          <div id="collapseInformation" class="collapse show" aria-labelledby="Information"
            data-parent="#accordionExample">
            <div class="row justify-content-center">
              <div class="col-md-12 col-12 mt-4">
                <div class="profile-avatar mb-5">
                  <ul>
                    <li> <img
                        src="{{  isset($influencer) && !empty($influencer->image) ? $influencer->image : asset('/assets/img/avatar_logo.png') }}"
                        id="imgLogo" alt=""> </li>
                    <li class="edit">
                      <i class="far fa-edit"></i>
                      <input type="file" name="image" id="inputFile" value="{{ old('fileReader') }}"
                        class="@if ($errors->has('image')) parsley-error @endif"
                        accept="image/x-png,image/gif,image/jpeg">
                    </li>
                    {{-- @error('image')
                                    <span class="error-msg-input">{{ $message }}</span>
                    @enderror --}}
                  </ul>
                  <p> Upload new photo </p>
                </div>
              </div>
              <div class="col-md-8 col-12">
                <div class="row">
                  <div class="col-xl-6 mt-4 name_sec">
                    <div class="form-group mg-b-0">
                      <label class="form-label">Name: <span>*</span> </label>
                      <input class="form-control  @if ($errors->has('name')) parsley-error @endif "
                        value="{{ isset($influencer) ? old('name',$influencer->name) : old('name') }}" name="name"
                        placeholder="Enter Name" type="text">
                      @error('name')
                      <span class="error-msg-input fdesfdrgtdr">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-xl-6 mt-4">
                    <div class="form-group nationality_sec">
                      <label class="form-label">Nationality:
                        <span>*</span>
                      </label>
                      <select class="form-control select2 @if ($errors->has('nationality')) parsley-error @endif"
                        id="nationality" name="nationality" data-parsley-class-handler="#slWrapper2"
                        data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                        @if (empty(old('nationality')))
                        <option disabled selected> Select</option>
                        @endif
                        @foreach ($nationalities as $nationality)
                        <option value="{{ $nationality->id }}"
                          {{ isset($influencer) && old('nationality',$influencer->nationality) == $nationality->id ? 'selected' : (old('nationality') == $nationality->id ? 'selected' : '') }}>
                          {{ $nationality->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                    @error('nationality')
                    <span class="error-msg-input">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="col-xl-6 mt-4">
                    <div class="form-group country_sec">
                      <label class="form-label">Country: <span>*</span></label>
                      <select
                        class="form-control select-to-get-other-options select2 @if ($errors->has('country_id')) parsley-error @endif"
                        id="country_id" name="country_id" data-parsley-class-handler="#slWrapper2"
                        data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select"
                        data-other-id="#state_id" data-other-name="country_id" data-other-to-reset="#city_id"
                        data-url="{{route('dashboard.getStatesListByCountryId')}}">
                        @if (empty(old('country_id')))
                        <option disabled selected> Select</option>
                        @endif
                        @foreach ($all_countries_data as $country)
                        <option value="{{ $country->id }}"
                          {{ isset($influencer) && old('country_id',$influencer->country_id) == $country->id ? 'selected' : (old('nationality') == $country->id ? 'selected' : '') }}>
                          {{ $country->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                    @error('country_id')
                    <span class="error-msg-input">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="col-xl-6 state mt-4">
                    <div class="form-group government_sec">
                      <label class="form-label">Government:
                        <!-- <span>*</span> -->
                      </label>
                      <select
                        class="form-control select-to-get-other-options select2 @if ($errors->has('state_id')) parsley-error @endif"
                        id="state_id" name="state_id" data-parsley-class-handler="#slWrapper2"
                        data-parsley-errors-container="#slErrorContainer2" data-other-id="#city_id"
                        data-other-name="state_id" data-url="{{route('dashboard.getCitiesListByStateId')}}">
                        @if (empty(old('state_id', isset($influencer->state_id))))
                        <option disabled selected> Select</option>
                        @endif
                        @if($selectedCountry)
                        @foreach($selectedCountry->states as $state)
                        <option value="{{$state->id}}" @if((old('state_id', $influencer->state_id) == $state->id) )
                          selected
                          @endif>{{$state->name}}</option>
                        @endforeach
                        @endif
                      </select>
                      </label>
                    </div>
                    @error('state_id')
                    <span class="error-msg-input">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="col-xl-6 city mt-4">
                    <div class="form-group">
                      <label class="form-label">City:
                        <!-- <span>*</span> -->
                      </label>
                      <select class="form-control select2  @if ($errors->has('city_id')) parsley-error @endif"
                        id="city_id" name="city_id" data-parsley-class-handler="#slWrapper2"
                        data-parsley-errors-container="#slErrorContainer2">
                        @if (empty(old('city_id', isset($influencer->city_id))))
                        <option disabled selected> Select</option>
                        @endif
                        @if($selectedState)
                        @foreach($selectedState->cities as $city)
                        <option value="{{$city->id}}" @if((old('city_id', $influencer->city_id) == $city->id) ) selected
                          @endif>{{$city->name}}</option>
                        @endforeach
                        @endif
                      </select>
                      @error('city_id')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-xl-6 mt-4">
                    <div class="form-group">
                      <label class="form-label">Gender: <span>*</span></label>
                      <select id="influencer_gender"
                        class="form-control select2 @if ($errors->has('gender')) parsley-error @endif" name="gender"
                        data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2"
                        data-placeholder="Select">
                        <option label="Select" disabled selected></option>
                        <option value=1 @if(old('gender', isset($influencer) && $influencer->gender) == 1) selected
                          @endif>Male</option>
                        <option value=0 @if(old('gender', isset($influencer) && $influencer->gender) == 0) selected
                          @endif>Female</option>
                      </select>
                      @error('gender')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-xl-6 mt-4">
                    <div class="form-group">
                      <label class="form-label">Date Of Birth: <span>*</span></label>
                      <input class="form-control @if ($errors->has('date_of_birth')) parsley-error @endif"
                        value="{{ isset($influencer) ? old('date_of_birth',$influencer->date_of_birth?->format('Y-m-d')) : old('date_of_birth') }}"
                        name="date_of_birth" placeholder="Enter Date OF Birth" type="date"
                        max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                      @error('date_of_birth')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-xl-6 mt-4">
                    <div class="form-group">
                      <label class="form-label">Address: </label>
                      <textarea class="form-control @if ($errors->has('address')) parsley-error @endif" name="address"
                        rows="4" placeholder="Enter Address">{{old('address',$influencer->address??null)}}</textarea>
                      @error('address')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- {{-- <div class="col-xl-4  col-md-6 col-xs-12">
            <div class="form-group ">
                    <label class="form-label" >Instagram <span>*</span></label>
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style=" border: none; background: #202020; "><i style="color: #fff;" class="fab fa-instagram"></i></span>
                <input onkeyup="this.value=removeSpaces(this.value);" type="text" name="insta_uname" placeholder="Enter Instagram Username" class="form-control @if ($errors->has('insta_uname')) parsley-error @endif" value="{{ isset($influencer) ? old('name',$influencer->insta_uname) :  old('insta_uname') }}">
            </div>
            @error('insta_uname')
                <span class="error-msg-input">{{ $message }}</span>
            @enderror
        </div> </div> --}} -->
    <div class="col-12 mt-4">
      <div class="grand-content-box">
        <div class="row justify-content-center">
          <div class="col-md-12 col-12 mb-4 title_form" id="Number">
            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
              data-target="#collapseNumber" aria-expanded="true" aria-controls="collapseNumber">
              Phone number
            </button>
            <!-- <h6> <i class="fas fa-phone mr-2"></i> Phone number:  </h6> -->
          </div>
          <div id="collapseNumber" class="collapse show" aria-labelledby="Number" data-parent="#accordionExample"
            style="width:100%">
            <div class="row  justify-content-center">
              <div class="col-md-8 col-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group main_phone_num">
                      <label class="form-label">Main Phone Number: <span>*</span></label>
                      <div class="input-group-prepend">
                        <select class="input-group-text country_code select2" name="main_phone_code"
                          data-placeholder="Code" style="width:100px !important;">
                          <option></option>
                          @foreach ($all_countries_data as $country)
                          <option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}"
                            {{ isset($influencer) && $influencer->user->code ==$country->phonecode ? 'selected' : (!empty(old('main_phone_code')) && old('main_phone_code') == $country->phonecode ? 'selected' : '' )}}>
                            (+)
                            {{ $country->phonecode }}
                          </option>
                          @endforeach
                        </select>
                        <input style="width:200%;margin-top:2px;"
                          class="form-control @if ($errors->has('main_phone')) parsley-error @endif"
                          value="{{ isset($influencer) ? old('main_phone',$influencer->user->phone) : old('main_phone')  }}"
                          id="main_phone" name="main_phone" placeholder="Enter Main Phone Number" type="number">
                      </div>
                      @error('main_phone_code')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                      @error('main_phone')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group mt-4">
                      <div class="switch_parent">
                        <input type="checkbox" id="switch-if-same-as-whatsapp" class="switch_toggle togBtn"
                          name="phone_same_as_whatsapp" value="1" @if(isset($influencer) &&
                          !empty($influencer->user->phone)
                        && $influencer->whats_number === $influencer->user->phone) checked @endif>
                        <label class="switch" for="switch-if-same-as-whatsapp" title="inactive"></label><span
                          style="color:#A27929;margin:2px 0px 0px 3px;">whatsapp is the same as phone</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6" id="whatsappSection" data-phone="{{$influencer->whats_number??null}}"
                    data-code="{{$influencer->code_whats??null}}">
                    <div class="form-group main_phone_num">
                      <label class="form-label">WhatsApp Phone Number:
                        <!-- <span>*</span> -->
                      </label>
                      <div class="input-group-prepend">
                        <select class="input-group-text country_code select2" name="whatsapp_code"
                          data-placeholder="Code" style="width:100px;">
                          <option></option>
                          @foreach ($all_countries_data as $country)
                          <option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}"
                            {{ isset($influencer) && $influencer->code_whats ==$country->phonecode ? 'selected' : (!empty(old('whatsapp_code')) && old('whatsapp_code') == $country->phonecode ? 'selected' : '' )}}>
                            (+)
                            {{ $country->phonecode }}
                          </option>
                          @endforeach
                        </select>
                        <input style="width:200%;margin-top:2px;"
                          class="form-control phoneInput @if ($errors->has('whats_number')) parsley-error @endif"
                          value="{{ isset($influencer) ? old('whats_number',$influencer->whats_number) : old('whats_number') }}"
                          name="whats_number" placeholder="Enter WhatsApp Phone Number" type="number">
                      </div>
                      @error('whats_number')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                      @error('whatsapp_code')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-md-6 col-xs-12" id="collapseNumber" class="collapse show"
            aria-labelledby="Information" data-parent="#accordionExample"></div>
        </div>
      </div>
    </div>
    <!-- Aditional Phones -->
    <div class="col-12 mt-4">
      <div class="grand-content-box">
        <div class="row justify-content-center">
          <div class="col-12 mb-4 title_form" id="AddNumber">
            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
              data-target="#collapseAddNumber" aria-expanded="true" aria-controls="collapseAddNumber">
              Additional Phone number
            </button>
            <!-- <h6> <i class="fas fa-phone mr-2"></i> Phone number:  </h6> -->
          </div>
          <div id="collapseAddNumber" class="collapse show" aria-labelledby="AddNumber" data-parent="#accordionExample"
            style="width:100%">
            <div class="row justify-content-center">
              <div class="col-md-8 col-12 main_phone_num">
                @php
                if(isset($influencer)) {
                $phonesNumbers = $influencer->InfluencerPhones;
                } else {
                $phonesNumbers = [];
                }
                $typePhone = $staticData['typePhone'];
                @endphp
                @include('admin.dashboard.layouts.includes.phones', [
                'phoneNumbers' => $phonesNumbers,
                'typePhone' => $typePhone
                ])
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-md-6 col-xs-12" id="collapseNumber" class="collapse show"
            aria-labelledby="Information" data-parent="#accordionExample"></div>
        </div>
      </div>
    </div>
    <!-- =================================== Social Media ===============================-->
    <div class="col-md-12">
      <div class="row justify-content-center">
        <div class="col-12  social_media_card">
          <div class="grand-content-box">
            <div class="row justify-content-center">
              <div class="col-12 mb-4 title_form" id="Media">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                  data-target="#collapseMedia" aria-expanded="true" aria-controls="collapseMedia">
                  Social Media

                </button>
                <!-- <h6> <i class="fas fa-phone mr-2"></i> Phone number:  </h6> -->
              </div>
              <div id="collapseMedia" class="collapse show" aria-labelledby="Media" data-parent="#accordionExample"
                style="width:100%">
                <div class="row justify-content-center">
                  <div class="col-md-8 col-12">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="allSocails">
                          @php
                          if(isset($influencer)) {
                          $socialMedia = $influencer->socialMedia;
                          } else {
                          $socialMedia = [];
                          }
                          @endphp
                          @include('admin.dashboard.layouts.includes.main_social_media', $socialMedia)
                        </div>
                        <div class="col-md-4">
                          <div style="margin-top:10px;"><button type="button" id="#add_social_input"
                              class="#add_social_input btn seeMore hvr-sweep-to-right"
                              onClick="addSocialMediaSelect();"><i class="fas fa-plus"></i></button></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <!-- =================================== Phones ===============================-->
    <!-- <div class="clearfix"></div>
        <div class="col-xl-6 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Address [Arabic]: </label>
                <textarea class="form-control @if ($errors->has('address')) parsley-error @endif" name="address_ar" rows="4" placeholder="Enter Address">{{old('address_ar',$influencer->address_ar??null)}}</textarea>
                @error('address')
                    <span class="error-msg-input">{{ $message }}</span>
                @enderror
            </div>
        </div> -->
    <hr>
    <!-- =================================== Phones ===============================-->

    <div class="col-12  mt-2">
      <div class="grand-content-box">
        <div class="row justify-content-center">
          <div class="col-12 mb-4 title_form" id="Class">
            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
              data-target="#collapseClass" aria-expanded="true" aria-controls="collapseClass">
              Classification

            </button>
            <!-- <h6> <i class="fas fa-phone mr-2"></i> Phone number:  </h6> -->
          </div>
          @inject('allStatus', 'App\Models\InfluencerClassification')
          @php
          $sta = $allStatus->whereStatus('classification')->get();
          @endphp
          <div id="collapseClass" class="collapse show" aria-labelledby="Class" data-parent="#accordionExample"
            style="width:100%">
            <div class="row justify-content-center">
              <div class="col-md-8 col-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group multiple_select_classification">
                      <label class="form-label">Classification:</label>
                      <select name="classification_ids[]" multiselect-max-items="5" id="chkveg" multiple="multiple"
                        class="form-control select2" data-placeholder="Select One Or More">
                        @foreach ($sta as $stat)
                        <option value="{{ $stat->id }}"
                          {{isset($influencer) && !empty($influencer->classification_ids) && is_array($influencer->classification_ids) && in_array($stat->id,$influencer->classification_ids) ? 'selected' : ''}}>
                          {{ $stat->name}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Category:</label>
                      <select class="form-control select2  @if ($errors->has('category_ids')) parsley-error @endif"
                        id="category_id" name="category_ids[]" data-parsley-class-handler="#slWrapper2"
                        data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More"
                        multiple>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                          {{ isset($influencer) && !empty($influencer->category_ids) && in_array($category->id,$influencer->category_ids) ? 'selected' : '' }}>
                          {{ $category->name}}
                        </option>
                        @endforeach
                      </select>
                      @error('category_ids')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Interests:</label>
                      <select class="form-control select2 @if ($errors->has('interest')) parsley-error @endif" multiple
                        name="interest[]" id="interest" data-parsley-class-handler="#slWrapper2"
                        data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
                        @foreach ($interests as $interest)
                        <option value={{ $interest->id }}
                          {{ isset($influencer) && !empty($influencer->interest) && in_array($interest->id,$influencer->interest) ? 'selected' : '' }}>
                          {{ $interest->interest}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Job:</label>
                      <select class="form-control  @if ($errors->has('job')) parsley-error @endif" id="job" name="job"
                        data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2"
                        data-placeholder="Select One Or More">
                        @if (empty(old('job')))
                        <option disabled selected> Select</option>
                        @endif
                        @foreach ($jobs as $job)
                        <option value="{{ $job->id }}"
                          {{ isset($influencer) && $influencer->job == $job->id ? 'selected' : (old('job') == $job->id ? 'selected' : '' ) }}>
                          {{ $job->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Lifestyle:</label>
                      <select class="form-control  @if($errors->has('ethink_category'))  parsley-error @endif"
                        id="ethink_category" name="ethink_category" data-parsley-class-handler="#slWrapper2"
                        data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                        @if(empty( old('ethink_category')))
                        <option disabled selected> Select</option>
                        @endif
                        @foreach($staticData['ethinkCategory'] as $key=>$ethink)
                        <option value="{{$ethink['id']}}"
                          {{isset($influencer) && $influencer->ethink_category == $ethink['id'] ? "selected" : ( old('ethink_category')==$ethink['id']? "selected":"")}}>
                          {{$ethink['title']}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Languages:
                        <!-- <span>*</span> -->
                      </label>
                      <select class="form-control select2 @if ($errors->has('lang')) parsley-error @endif" multiple
                        id="lang" name="lang[]" data-parsley-class-handler="#slWrapper2"
                        data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
                        @foreach ($languages as $lang)
                        <option value={{ $lang->id }}
                          {{ isset($influencer) && !empty($influencer->lang) && in_array($lang->id,$influencer->lang) ? 'selected' : (collect(old('lang'))->contains($lang->id) ? 'selected' : '') }}>
                          {{ $lang->name }}
                        </option>
                        @endforeach
                      </select>
                      @error('lang')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Account Type: {{$influencer->account_type??null}}</label>
                      <select class="form-control  @if ($errors->has('account_type')) parsley-error @endif"
                        id="account_type" name="account_type" data-parsley-class-handler="#slWrapper2"
                        data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                        @if (empty(old('account_type')))
                        <option disabled selected> Select</option>
                        @endif
                        @foreach ($staticData['accountType'] as $key => $account_type)
                        <option value="{{ $account_type['id'] }}"
                          {{ isset($influencer) && $account_type['id']==$influencer->account_type ? 'selected' : (old('account_type') ==  $account_type['id'] ? 'selected' : '' )}}>
                          {{ $account_type['title'] }}
                        </option>
                        @endforeach
                      </select>
                      @error('account_type')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  {{-- <div class="col-md-6">--}}
                  {{-- <div class="form-group">--}}
                  {{-- <label class="form-label">Citizenship:</label>--}}
                  {{-- <select class="form-control  @if ($errors->has('citizen_status')) parsley-error @endif" id="citizen_status" name="citizen_status" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">--}}
                  {{-- @if (empty(old('citizen_status')))--}}
                  {{-- <option disabled selected> Select</option>--}}
                  {{-- @endif--}}
                  {{-- @foreach ($staticData['citizenStatus'] as $key => $citizen_status)--}}
                  {{-- <option value="{{ $citizen_status['id'] }}"
                  {{ isset($influencer) && $citizen_status['id'] ==$influencer->citizen_status ? "selected" : (old('citizen_status') == $citizen_status['id'] ? 'selected' : '') }}>--}}
                  {{-- {{ $citizen_status['title'] }}--}}
                  {{-- </option>--}}
                  {{-- @endforeach--}}
                  {{-- </select>--}}
                  {{-- @error('citizen_status')--}}
                  {{-- <span class="error-msg-input">{{ $message }}</span>--}}
                  {{-- @enderror--}}
                  {{-- </div>--}}
                  {{-- </div>--}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Coverage Channels: </label>
                      <select class="form-control select2 @if ($errors->has('coverage_channel')) parsley-error @endif"
                        id="channel" name="channel_ids[]" data-parsley-class-handler="#slWrapper2"
                        data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" multiple>
                        @foreach($channels as $channel)
                        <option value="{{ $channel->id }}"
                          {{ isset($influencer) &&!empty($influencer->coverage_channel) && in_array($channel->id,$influencer->coverage_channel) ? 'selected' : '' }}>
                          {{ $channel->title }}
                        </option>
                        @endforeach
                      </select>
                      @error('coverage_channel')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Website: </label>
                      <div class="input-group-prepend">
                        <input class="form-control @if ($errors->has('website_uname')) parsley-error @endif"
                          value="{{ isset($influencer) ? $influencer->website_uname  : old('website_uname') }}"
                          name="website_uname" placeholder="Enter Website URL" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 state">
                    <div class="form-group">
                      <label class="form-label">Attitude:
                        <!-- <span>*</span> -->
                      </label>
                      <select class="form-control parsley-error" id="attitude_id" name="attitude_id"
                        data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
                        @foreach($attitude as $attit)
                        <option value="{{$attit['id']}}" @if(old('attitude_id', $influencer->attitude_id??null) ==
                          $attit['id']) selected @endif>{{$attit['name']}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 mt-4">
                    <div class="form-group">
                      <div class="input-group-prepend has_voucher">
                        <div class="pretty p-default">
                          <input type="checkbox" name="has_voucher"
                            class="form-contr ol @if ($errors->has('has_voucher')) parsley-error @endif" value="1"
                            @if(old("has_voucher", isset($influencer) && $influencer->has_voucher)) checked @endif>
                          <div class="state">
                            <label class="form-check-label " for="defaultCheck1">
                              Has Voucher
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-12  social_media_card">
      <div class="grand-content-box">
        <div class="row justify-content-center">
          <div class="col-md-12 col-12 mb-4 title_form" id="Martial">
            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
              data-target="#collapseMartial" aria-expanded="true" aria-controls="collapseMartial">
              Marital Status

            </button>
            <!-- <h6> <i class="fas fa-phone mr-2"></i> Phone number:  </h6> -->
          </div>
          <div id="collapseMartial" class="collapse show" aria-labelledby="Martial" data-parent="#accordionExample"
            style="width:100%">
            <div class="row justify-content-center">

              <div class="col-md-12 col-12">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group martial_status">
                      @foreach ($socialStatus as $social)
                      <div class="form-check-inline">
                        <div class="pretty p-default p-round">
                          <input type="radio" class="form-check-input" name="marital_status" @if(old('marital_status',
                            isset($influencer->marital_status)?($influencer->marital_status?:1):1) == $social['id'])
                          checked
                          @endif value="{{ $social['id'] }}" onchange="socialType('{{ $social['id'] }}')">
                          <div class="state">

                            <label data-type="{{ $social['id'] }}">

                              {{ $social['name'] }}
                            </label>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                    @error('marital_status')
                    <span class="error-msg-input">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="col-md-4" @if ( empty(old('marital_status', $influencer->marital_status??1)) ||
                    old('marital_status', $influencer->marital_status??1) == 1) style="display: none;" @endif>
                    <label for="lang">Children Number: <span>*</span> </label>
                    <input class="form-control" type="number" id="children_num"
                      value="{{ isset($influencer) ? old('children_num', $influencer->children_num) : old('children_num') }}"
                      onkeypress="diableChars(event)" name="children_num" min="1" max="15">
                    @error('children_num')
                    <span class="error-msg-input">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="col-lg-8 col-md-8  col-xs-12" id="children_info" @if(!$errors->has('children_info'))
                    style="display: none" @endif>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="alert alert-danger">You should add alldsadsad information of children</div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12" id="childrenContainer">
                    @if(isset($influencer) && !empty($influencer->ChildrenInfluencer))
                    @foreach($influencer->ChildrenInfluencer as $key => $children)
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-4 mb-3">
                            <label for="child_name"
                              style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Children
                              Name </label>
                            <input type="text" name="childname[{{$loop->index}}]" value="{{$children['child_name']}}"
                              placeholder="Children Name " class="form-control">
                          </div>
                          <div class="col-md-4 mb-3">
                            <label for="DOB">Children Date Of Birth</label>
                            <input type="date" name="childdob[{{$loop->index}}]" value="{{@$children['child_dob']}}"
                              class="form-control" max="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                          </div>
                          <div class="col-md-4 mb-3">
                            <label for="childgender"
                              style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Children
                              Gender</label>
                            <select class="input-group-text childrenGender select2" placeholder="Children Type"
                              name="childgender[{{$loop->index}}]">
                              <option value="male" @if(isset($children['child_gender']) &&
                                $children['child_gender']=="male" ) selected @endif>Male</option>
                              <option value="female" @if(isset($children['child_gender']) &&
                                $children['child_gender']=="female" ) selected @endif>Female</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <input type="hidden" name="influencer_id"> -->
        </div>
      </div>
    </div>

    <div class="col-12 mt-4">
      <div class="grand-content-box">
        <div class="row justify-content-center">
          <div class="col-12 mb-4 title_form" id="Auth">
            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
              data-target="#authentication-tab" aria-expanded="true" aria-controls="authentication-tab">
              Authentication

            </button>
            <!-- <h6> <i class="fas fa-phone mr-2"></i> Phone number:  </h6> -->
          </div>
          <div id="authentication-tab" class="collapse show" aria-labelledby="Auth" data-parent="#accordionExample"
            style="width:100%">
            <div class="row justify-content-center">
              <div class="col-md-8 col-12">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-label">Username: <span>*</span></label>
                      <input onkeyup="this.value=removeSpaces(this.value);"
                        class="form-control @if ($errors->has('user_name')) parsley-error @endif"
                        value="{{ isset($influencer) ? old('user_name',$influencer->user->user_name) : old('user_name') }}"
                        name="user_name" placeholder="Enter Username" type="text">
                      @error('user_name')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Email: <span>*</span></label>
                      <input onkeyup="this.value=removeSpaces(this.value);"
                        class="form-control  @if ($errors->has('email')) parsley-error @endif"
                        value="{{ isset($influencer) ? old('user_name',$influencer->user->email) : old('email') }}"
                        name="email" placeholder="Enter Email" type="text">
                      @error('email')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Password: <span>*</span></label>
                      <i class="fas fa-eye"></i>
                      <input class="form-control @if ($errors->has('password')) parsley-error @endif"
                        value="{{  old('password') }}" name="password" placeholder="Enter Password" type="password">
                      @error('password')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Status:
                        <span>*</span>
                      </label>
                      <select class="form-control select2 @if ($errors->has('active')) parsley-error @endif"
                        id="status_infl" value="{{ old('active') }}" name="active"
                        data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2"
                        data-placeholder="Select">
                        <option value=""> Select</option>
                        @foreach ($statInflue as $social_class)
                        <option value="{{ $social_class['id'] }}"
                          {{isset($influencer) && $influencer->active ==  $social_class['id'] ? 'selected' : ''}}>
                          {{ $social_class['name'] }}
                        </option>
                        @endforeach
                      </select>
                      @error('active')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-xl-6  licence_check">

                    <span style="font-size: 12px;color:#fff"> <label class="form-label"> Check: </label>
                      <!-- <span style="color:red">*</span>  -->
                    </span>
                    <div class="d-flex mt-4">




                      <div class="pretty p-default">
                        <input type="checkbox" name="licence"
                          class="form-contr ol @if ($errors->has('licence')) parsley-error @endif" value="1"
                          @if(old("licence", isset($influencer) && $influencer->licence)) checked @endif>
                        <div class="state">
                          <label class="form-check-label " for="defaultCheck1">
                            licence
                          </label>
                        </div>
                      </div>


                      <div class="pretty p-default">
                        <input type="checkbox" name="v_by_g"
                          class="form-contr ol @if ($errors->has('v_by_g')) parsley-error @endif" value="1"
                          @if(old("v_by_g", isset($influencer) && $influencer->v_by_g)) checked @endif>
                        <div class="state">
                          <label class="form-check-label " for="defaultCheck1">
                            v_by_g
                          </label>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="col-md-6 databindOnlyDelivery" @if(isset($influencer) && $influencer->active == "7")
                    style="display:block;" @else style="display:none;" @endif>
                    <div class="form-group">
                      <label class="form-label">Country Visit: <span>*</span></label>
                      <select
                        class="form-control  @if ($errors->has('country_visited_outofcountry')) parsley-error @endif"
                        id="country_visited_outofcountry" name="country_visited_outofcountry"
                        data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2"
                        data-placeholder="Select" @if (empty(old('country_visited_outofcountry'))) <option disabled
                        selected>
                        Select</option>
                        @endif
                      </select>
                      @error('country_visited_outofcountry')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-4 databindOnlyDelivery" @if(isset($influencer) && $influencer->active == "7")
                    style="display:block;" @else style="display:none;" @endif>
                    <div class="form-group">
                      <label class="form-label">Returned Date: </label>
                      <input class="form-control @if ($errors->has('influencer_return_date')) parsley-error @endif"
                        value="{{ isset($influencer)  && !empty($influencer->influencer_return_date) ? $influencer->influencer_return_date->format('Y-m-d') :  old('influencer_return_date') }}"
                        name="influencer_return_date" placeholder="Enter Date" type="date"
                        min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                      @error('influencer_return_date')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-4 mt-4">
                    <div class="form-group">
                      <label class="form-label">Account Expiration Date: </label>
                      <input class="form-control @if ($errors->has('expirations_date')) parsley-error @endif"
                        value="{{ isset($influencer) ? old('expirations_date',$influencer->expirations_date) : old('expirations_date') }}"
                        name="expirations_date" placeholder="Enter Date" type="date"
                        min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                      @error('expirations_date')
                      <span class="error-msg-input">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Password Confirmation: <span>*</span></label>
                <i class="fas fa-eye"></i>
                <input class="form-control  @if ($errors->has('password_confirmation')) parsley-error @endif" value="{{ old('password_confirmation') }}"
    name="password_confirmation" placeholder="Re-enter Password" type="password">
    @error('password_confirmation')
    <span class="error-msg-input">{{ $message }}</span>
    @enderror
  </div>
</div> --}}
<!--  Social Status -->
<input type="hidden" name="id" value="{{ isset($influencer) ? $influencer->id : '' }}" />
<input type="hidden" name="user_id" value="{{ isset($influencer) ? $influencer->user_id : '' }}" />
<div class="col-12 text-left save button-box">
  <button class="btn btn-primary pd-x-20 mg-t-10 mt-3" style="width: 100px" type="submit">
    <i class="far fa-save"></i> Save
  </button>
</div>

@push('js')
<script>
function removeSpaces(string) {
  return string.split(' ').join('');
}

$(function() {
  $("#inputFile").change(function() {
    readURL(this);
  });
});


function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      //alert(e.target.result);
      $('#imgLogo').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
</script>
<script>
$(".select2").select2();
</script>
@endpush
