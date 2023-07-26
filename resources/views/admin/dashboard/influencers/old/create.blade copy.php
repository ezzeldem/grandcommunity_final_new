@extends('admin.dashboard.layouts.app')
@section('title', 'Create Influencer Account')
@section('style')



<!--- Internal Sweet-Alert css-->
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: test-field;
    }

    .form-label {
        margin-bottom: 5px;
    }

    .switch_parent input[type='checkbox'] {
        display: block;
        opacity: 0;
    }

    .switch_parent .switch {
        position: relative;
        width: 60px;
        height: 34px;
        display: inline-block;
        background: #666666;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s;
        -moz-transition: all 0.3s;
        -webkit-transition: all 0.3s;
    }

    .switch_parent .switch:after {
        content: "";
        position: absolute;
        left: 2px;
        top: 2px;
        width: 30px;
        height: 30px;
        background: #FFF;
        border-radius: 50%;
        box-shadow: 1px 3px 6px #666666;
    }

    .switch_parent input[type='checkbox']:checked+.switch {
        background: #009900;
    }

    .switch_parent input[type='checkbox']:checked+.switch:after {
        left: auto;
        right: 2px;
    }

    .select2-results__options {
        background: var(--main-bg-color) !important;
    }


    .multiselect {
        width: 200px;
    }

    .selectBox {
        position: relative;
    }

    .selectBox select {
        width: 100%;
        font-weight: bold;
    }

    .overSelect {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    #checkboxes {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxes label {
        display: block;
    }

    #checkboxes label:hover {
        background-color: #1e90ff;
    }





    .dropdown-check-list {
        display: inline-block;
    }

    .dropdown-check-list .anchor {
        position: relative;
        cursor: pointer;
        display: inline-block;
        padding: 5px 50px 5px 10px;
        border: 1px solid #ccc;
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

    .dropdown-check-list.visible .anchor {
        color: #0094ff;
    }

    .dropdown-check-list.visible .items {
        display: block;
    }

    .multiple_select_classification .btn-group {
        width: 100%;
        background-color: transparent !important;
    }

    .multiple_select_classification ul.multiselect-container {
        width: 100%;
        padding: 5px 10px;
        background: #111;
        border: 1px solid var(--border-color);
    }

    .multiple_select_classification li a,
    .multiple_select_classification li a:hover {
        color: #fff
    }
</style>
@stop

@section('content')

@php
$routes = [['route' => route('dashboard.influences.index'), 'name' => 'Influencers']];
@endphp
@include('admin.dashboard.layouts.includes.breadcrumb', $routes)

<div class="row gutters __addCampaign-container">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card ">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between" style=" align-items: center; ">
                    <h4 class="card-title mg-b-0" style=" margin: 0rem; ">Create New Influencer</h4>
                    <a href="{{ route('dashboard.influences.index') }}" class="btn mt-2 mb-2 pb-2" style="color: #fff;"><i class="fas fa-long-arrow-alt-left"></i> Back </a>
                </div>
            </div>

            <div class="card-body">
                <form class="create_page" action="{{ route('dashboard.influences.store') }}" method="post" data-parsley-validate="" novalidate="" enctype="multipart/form-data">
                    @csrf
                        <div class="col-12 social_media_card">
                            <h5 class="mt-3"><i class="fas fa-link"></i> General</h5>
                            <hr>
                            <div class="row">
                                <div class="col-xl-4 col-md-6 col-sm-12 ">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label">Name <span class="text-danger">*</span> </label>
                                            <input class="form-control  @if ($errors->has('name')) parsley-error @endif " value="{{ old('name') }}" name="name" placeholder="Enter Name" type="text">
                                        @error('name')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4  col-md-6 col-xs-12">
                                    <div class="form-group ">
									     <label class="form-label" >Instagram <span class="text-danger">*</span></label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1" style=" border: none; background: #202020; "><i style="color: #fff;" class="fab fa-instagram"></i></span>
                                        <input onkeyup="this.value=removeSpaces(this.value);" type="text" name="insta_uname" placeholder="Enter Instagram Username" class="form-control @if ($errors->has('insta_uname')) parsley-error @endif" value="{{ old('insta_uname') }}">
                                    </div>
                                    @error('insta_uname')
                                     <span class="error-msg-input">{{ $message }}</span>
                                    @enderror
                                </div> </div>
                                <div class="col-xl-4 col-md-6 col-xs-12">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label" >Image:</label>
                                        <div class="custom-file">
                                            <input type="file" value="{{ old('fileReader') }}" name="image" class="custom-file-input @if ($errors->has('image')) parsley-error @endif" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Select file</label>
                                        </div>
                                        @error('image')
										  <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-xl-4  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                            <select class="form-control  @if ($errors->has('nationality')) parsley-error @endif" id="nationality" name="nationality" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" >
                                                @foreach ($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}" {{ old('nationality') == $nationality->id ? 'selected' : '' }}>
                                                    {{ $nationality->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        @error('nationality')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 col-xs-12">
                                    <div class="form-group">
                                           <label class="form-label">Country <span class="text-danger">*</span></label>
                                            <select class="form-control  @if ($errors->has('country_id')) parsley-error @endif" id="country_id" name="country_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select<">
                                                @if (empty(old('country_id')))
                                                <option disabled selected> Select</option>
                                                @endif
                                                @foreach ($countries_active as $country)
                                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        @error('country_id')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4  col-md-6 col-xs-12 state">
                                    <div class="form-group">
									<label class="form-label">Government <span class="text-danger">*</span></label>
                                             <select class="form-control  @if ($errors->has('state_id')) parsley-error @endif" disabled id="state_id" name="state_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
                                            </select>
                                        </label>
                                        @error('state_id')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 col-xs-12 city">
                                    <div class="form-group">
									     <label class="form-label">City <span class="text-danger">*</span></label>
                                            <select class="form-control  @if ($errors->has('city_id')) parsley-error @endif" disabled id="city_id" name="city_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2">
                                            </select>
                                        @error('city_id')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

					<div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="form-label">Gender: <span class="text-danger">*</span></label>
                            <select id="influencer_gender" class="form-control select2 @if ($errors->has('gender')) parsley-error @endif" value="{{ old('gender') }}" name="gender" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                <option label="Select" disabled selected></option>
                                <option value=1 {{ old('gender') == 1 ? 'selected' : '' }}>Male</option>
                                <option value=0 {{ old('gender') == '0' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                            <span class="error-msg-input">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="form-label">Date Of Birth</label>
                            <input class="form-control @if ($errors->has('date_of_birth')) parsley-error @endif" value="{{ old('date_of_birth') }}" name="date_of_birth" placeholder="Enter Date OF Birth" type="date" max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                            @error('date_of_birth')
                            <span class="error-msg-input">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                                <div class="col-xl-4  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Main Phone Number: <span class="text-danger">*</span></label>

                                                <div class="input-group-prepend">
														<select class="input-group-text country_code select2" name="main_phone_code" data-placeholder="Code" style="width:200px;">
															<option></option>
															@foreach ($countries_active as $country)
															<option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}" {{ !empty(old('main_phone_code')) && old('main_phone_code') == $country->phonecode ? 'selected' : '' }}>
																{{ $country->phonecode }}
															</option>
															@endforeach
														</select>
                                                    <input style="width:200%;margin-top:3px;" class="form-control @if ($errors->has('main_phone')) parsley-error @endif" value="{{ old('main_phone') }}" name="main_phone" placeholder="Enter Main Phone Number" type="number" onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109">
                                                </div>
                                        @error('main_phone_code')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                        @error('main_phone')
                                        <span class="error-msg-input">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-xl-4 col-md-4 col-sm-4 col-12 main-toggle-group-demo" style="top:20px;">
                                    <div class="form-group">
                                        <div class="switch_parent">
                                            <input type="checkbox" id="switch" class="switch_toggle togBtn">
                                            <label class="switch" for="switch" title="inactive"></label><span style="color:#A27929;margin:2px 0px 0px 3px;">whatsapp is the same as phone</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-md-6 col-xs-12" id="whatsappSection">
                                    <div class="form-group">
                                        <label class="form-label">WhatsApp Phone Number: <span class="text-danger">*</span></label>
                                                <div class="input-group-prepend">
                                                    <select class="input-group-text country_code select2" name="whatsapp_code" data-placeholder="Code" style="width:200px;">
                                                        <option></option>
                                                        @foreach ($countries_active as $country)
                                                        <option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}" {{ !empty(old('whatsapp_code')) && old('whatsapp_code') == $country->phonecode ? 'selected' : '' }}>
                                                            {{ $country->phonecode }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <input style="width:200%;margin-top:3px;"  class="form-control phoneInput @if ($errors->has('whats_number')) parsley-error @endif" value="{{ old('whats_number') }}" name="whats_number" placeholder="Enter WhatsApp Phone Number" type="number">
                                                 </div>
													@error('whats_number')
													<span class="error-msg-input">{{ $message }}</span>
                                                    @enderror
                                                    @error('whatsapp_code')
													<span class="error-msg-input">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                    <div class="clearfix"></div>
                    <div class="col-xl-12 col-lg-6 col-md-4 col-sm-4 col-12">
                        <div class="form-group">
                            <label class="form-label">Phone Number: </label>
                            <div class="allPhones">
                                @if (old('phone'))
                                @for ($i = 0; $i < count(old('phone')); $i++)
								<div class="inputs " style="display: flex;width: 100%;align-items: center;gap: 25px;margin-top: -7px;max-width: 100%;width: 100% !important;" min="0">
                                    <div class="input-group-prepend">
                                            <select class="input-group-tex select2" name="phone_type[]" data-placeholder="Code" style="width:200px;margin-top:3px;">
                                                <option value="" disabled selected>Select</option>
                                                @foreach ($staticData['typePhone'] as $key => $typephone)
                                                <option value="{{$typephone['id']}}" {{ !empty(old('phone_type')[$i]) && old('phone_type')[$i] == $typephone['id'] ? 'selected' : '' }}>{{$typephone['title']}}</option>
                                                @endforeach
                                            </select>
                                        <select class="input-group-text country_code select2" name="phone_code[]" data-placeholder="Code" style="width:200px;">
                                            <option></option>
                                            @foreach ($countries_active as $country)
                                            <option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}" {{ !empty(old('phone_code')[$i]) && old('phone_code')[$i] == $country->phonecode ? 'selected' : '' }}>
                                                {{ $country->phonecode }}
                                            </option>
                                            @endforeach
                                        </select>

                                    <input type="text" value="{{ old('phone.' . $i) }}" placeholder="Enter Phone Number" style="width:200%;margin-top:3px;" type="number" min="0" name="phone[]" class=" phoneInput form-control   @if ($errors->has('phone.*')) parsley-success @endif">
									</div>
									<div style="margin-top:10px;">
										@if ($i != 0)
										<a href="javascript:void(0)" onClick="deleteBranch(this)" class="deleterr btn btn-danger mb-2"><i class="fas fa-trash-alt"></i></a>
										@endif
										@if ($i == 0)
										<button type="button" id="add_phone_input" class="add_phone_input btn seeMore hvr-sweep-to-right"><i class="fas fa-plus"></i></button>
										@endif
                                    </div>
                            </div>
                            @endfor
                            @endif
                            @if (!old('phone'))
							<div class="inputs " style="display: flex;width: 100%;align-items: center;gap: 25px;margin-top: -7px;max-width: 100%;width: 100% !important;" min="0">
                                <div class="input-group-prepend">
                                        <select class="input-group-text  select2" name="phone_type[]" data-placeholder="Code" style="width:200px;margin-top:3px;">
                                            <option>Select</option>
                                            @foreach ($staticData['typePhone'] as $key => $typephone)
                                            <option value="{{$typephone['id']}}">{{$typephone['title']}}</option>
                                            @endforeach
                                        </select>
                                    <select class="input-group-text country_code select2" name="phone_code[]" data-placeholder="Code" style="width:200px;">
                                        <option></option>
                                        @foreach ($countries_active as $country)
                                        <option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}">
                                            {{ $country->phonecode }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <input style="width:200%;margin-top:3px;" class="form-control phoneInput @if ($errors->has('phone.*')) parsley-error @endif" name="phone[]" min="0" placeholder="Enter Phone Number" type="number">
                                </div>
                                    <div style="margin-top:10px;"><button type="button" id="add_phone_input" class="add_phone_input btn seeMore hvr-sweep-to-right"><i class="fas fa-plus"></i>Add New</button></div>
                            </div>
                            @endif


                        </div>
                        @error('phone_code')
						<span class="error-msg-input">{{ $message }}</span>
                        @enderror

                        @error('phone_type')
					        <span class="error-msg-input">{{ $message }}</span>
                        @enderror
                        @error('phone.*')
						<span class="error-msg-input">{{ $message }}</span>
                        @enderror
                    </div>

            </div>


            <div class="col-xl-6 col-lg-6  col-md-6 col-xs-12">
                <div class="form-group">
                    <label class="form-label" >Address [English]</label>
                            <textarea class="form-control @if ($errors->has('address')) parsley-error @endif" name="address" rows="4" value="" placeholder="Enter Address" type="text">
                            {{{old('address') }}}
                            </textarea>
                    @error('address')
					<span class="error-msg-input">{{ $message }}</span>
                    @enderror
                </div>
            </div>


			<div class="col-xl-6 col-lg-6  col-md-6 col-xs-12">
                <div class="form-group">
                    <label class="form-label" >Address [Arabic]</label>
                            <textarea class="form-control @if ($errors->has('address')) parsley-error @endif" name="address" rows="4" value="" placeholder="Enter Address" type="text">
                            {{{old('address') }}}
                            </textarea>
                    @error('address')
					<span class="error-msg-input">{{ $message }}</span>
                    @enderror
                </div>
            </div>


    </div>
<hr>

<div class="col-12 social_media_card">
    <h5 class="mt-3"><i class="fas fa-link"></i> Advanced</h5>
    <hr>
    <div class="row">
        @inject('allStatus', 'App\Models\InfluencerClassification')
        @php
        $sta = $allStatus->get();

        @endphp
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group multiple_select_classification">
			<label class="form-label">Classification</label>
                <select name="classification_ids[]" multiselect-max-items="5" id="chkveg" multiple="multiple">
                    @foreach ($sta as $stat)
                    <option value="{{ $stat->id }}">{{ $stat->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Job:</label>
                <select class="form-control  @if ($errors->has('job')) parsley-error @endif" id="job" name="job" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
                    @if (empty(old('job')))
                    <option disabled selected> Select</option>
                    @endif
                    @foreach ($jobs as $job)
                    <option value="{{ $job->id }}" {{ old('job') == $job->id ? 'selected' : '' }}>{{ $job->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Interests</label>
                <select class="form-control select2 @if ($errors->has('interest')) parsley-error @endif" multiple name="interest[]" id="interest" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
                    @foreach ($interests as $interest)
                    <option value={{ $interest->id }} {{ collect(old('interest'))->contains($interest->id) ? 'selected' : '' }}>
                        {{ $interest->interest}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Lifestyle:</label>
                <select class="form-control  @if($errors->has('ethink_category'))  parsley-error @endif" id="ethink_category" name="ethink_category" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                    @if(empty( old('ethink_category')))
                    <option disabled selected> Select</option>
                    @endif
                    @foreach($staticData['ethinkCategory'] as $key=>$ethink)
                    <option value="{{$ethink['id']}}" {{old('ethink_category')==$ethink['id']? "selected":""}}>{{$ethink['title']}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        {{-- <div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Shares Coverage As Posts:</label>
                                        <select
                                            class="form-control  @if ($errors->has('share')) parsley-error @endif"
                                            id="share" name="share" data-parsley-class-handler="#slWrapper2"
                                            data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                            @if (empty(old('share')))
                                                <option disabled selected> Select</option>
                                            @endif
                                            @foreach ($staticData['share'] as $key => $share)
                                                <option value="{{ $key }}"
        {{ old('share') == $key ? 'selected' : '' }}>
        {{ $share }}</option>
        @endforeach
        </select>
        @error('share')
        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
            <li class="parsley-required">{{ $message }}</li>
        </ul>
        @enderror
    </div>
</div> --}}

<div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
        <label class="form-label">Languages: <span class="text-danger">*</span></label>
        <select class="form-control select2 @if ($errors->has('lang')) parsley-error @endif" multiple id="lang" name="lang[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
            @foreach ($languages as $lang)

            <option value={{ $lang->id }} {{ collect(old('lang'))->contains($lang->id) ? 'selected' : '' }}>
                {{ $lang->name }}
            </option>
            @endforeach
        </select>
        @error('lang')
        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
            <li class="parsley-required">{{ $message }}</li>
        </ul>
        @enderror
    </div>
</div>
<div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
    <div class="form-group">
        <label class="form-label">Account Type:</label>
        <select class="form-control  @if ($errors->has('account_type')) parsley-error @endif" id="account_type" name="account_type" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
            @if (empty(old('account_type')))
            <option disabled selected> Select</option>
            @endif
            @foreach ($staticData['accountType'] as $key => $account_type)
            <option value="{{ $account_type['id'] }}" {{ old('account_type') ==  $account_type['id'] ? 'selected' : '' }}>
                {{ $account_type['title'] }}
            </option>
            @endforeach
        </select>
        @error('account_type')
        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
            <li class="parsley-required">{{ $message }}</li>
        </ul>
        @enderror
    </div>
</div>
<div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
    <div class="form-group">
        <label class="form-label">Citizenship:</label>
        <select class="form-control  @if ($errors->has('citizen_status')) parsley-error @endif" id="citizen_status" name="citizen_status" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
            @if (empty(old('citizen_status')))
            <option disabled selected> Select</option>
            @endif
            @foreach ($staticData['citizenStatus'] as $key => $citizen_status)
            <option value="{{ $citizen_status['id'] }}" {{ old('citizen_status') == $citizen_status['id'] ? 'selected' : '' }}>
                {{ $citizen_status['title'] }}
            </option>
            @endforeach
        </select>
        @error('citizen_status')
        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
            <li class="parsley-required">{{ $message }}</li>
        </ul>
        @enderror
    </div>
</div>
{{-- <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label">Social Class:</label>
                                    <select class="form-control  @if ($errors->has('social_class')) parsley-error @endif"
                                        id="social_class" name="social_class" data-parsley-class-handler="#slWrapper2"
                                        data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                        @if (empty(old('social_class')))
                                            <option disabled selected> Select</option>
                                        @endif

                                        @foreach ($staticData['socialClass'] as $key => $social_class)
                                            <option value="{{ $social_class['id'] }}"
{{ old('social_class') == $social_class['id'] ? 'selected' : '' }}>{{ $social_class['title'] }}
</option>
@endforeach
</select>
@error('social_class')
<ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
    <li class="parsley-required">{{ $message }}</li>
</ul>
@enderror
</div>
</div> --}}

@inject('category', 'App\Models\Category')
@php
$categories = $category->get();
@endphp

<div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
    <div class="form-group">
        <label class="form-label">Category:</label>
        <select class="form-control select2  @if ($errors->has('category_ids')) parsley-error @endif" id="category_id" name="category_ids[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" multiple>

            @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_ids') == $category->id ? 'selected' : '' }}>{{ $category->getAttributes()['title']}}
            </option>
            @endforeach
        </select>
        @error('category_ids')
        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
            <li class="parsley-required">{{ $message }}</li>
        </ul>
        @enderror
    </div>
</div>

<div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
    <div class="form-group">
        <label class="form-label">Coverage Channels: </label>
        <select class="form-control select2 @if ($errors->has('coverage_channel')) parsley-error @endif" id="channel" name="channel_ids[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" multiple>
            @foreach($channels as $channel)
            <option value="{{ $channel->id }}" {{ old('coverage_channel') == $channel->id  ? 'selected' : '' }}>{{ $channel->name }}</option>
            @endforeach
        </select>
        @error('coverage_channel')
        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
            <li class="parsley-required">{{ $message }}</li>
        </ul>
        @enderror
    </div>
</div>

<input type="hidden" name="influencer_id">
<div class="col-12 social_status_card">
    <h5><i class="fas fa-link"></i> Marital Status</h5>
    <hr>
    <div class="row">
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">

            <div class="form-group">

                @foreach ($socialStatus as $social)
                <div class="form-check-inline">
                    <label class="form-check-label socialRadioType" data-type="{{ $social['id'] }}">
                        <input type="radio" class="form-check-input" name="marital_status" @if (!empty(old('marital_status')) && old('marital_status')==$social['id']) checked @endif value="{{ $social['id'] }}" onchange="socialType('{{ $social['id'] }}')">
                        {{ $social['name'] }}
                    </label>
                </div>
                @endforeach
                @error('marital_status')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12" @if (!old('children_num')) style="display: none;" @endif>
            <label for="lang">Children Number</label>
            <input class="form-control" type="number" id="children_num" value="{{ old('children_num') }}" onkeypress="diableChars(event)" name="children_num" min="1" max="15" style="width: 180px">
            @error('children_num')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                <li class="parsley-required">{{ $message }}</li>
            </ul>
            @enderror
        </div>
        <div class="col-lg-12 col-md-12  col-xs-12" id="childrenContainer">
        </div>
    </div>
</div>

</div>
</div>
<hr>

<div class="col-12 social_media_card">
    <h5 class="mt-3"><i class="fas fa-link"></i> More</h5>
    <hr>
    <div class="row">
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Min Voucher:</label>
                <select class="form-control  @if ($errors->has('min_voucher')) parsley-error @endif" id="min_voucher" name="min_voucher" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                    @if (empty(old('min_voucher')))
                    <option disabled selected> Select</option>
                    @endif
                    @for ($i = 10; $i <= 1000; $i +=10) <option value="{{ $i }}" {{ old('min_voucher') == $i ? 'selected' : '' }}>{{ $i }}
                        </option>
                        @endfor
                </select>
                @error('min_voucher')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Rating:</label>
                <select class="form-control  @if ($errors->has('rating')) parsley-error @endif" id="rating" name="rating" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                    @if (empty(old('rating')))
                    <option disabled selected> Select</option>
                    @endif
                    @foreach ($staticData['rating'] as $key => $rating)
                    <option value="{{ $key }}" {{ old('rating') == $key ? 'selected' : '' }}>
                        {{ $rating }}
                    </option>
                    @endforeach
                </select>
                @error('rating')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>



        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Coverage Rating:</label>
                <select class="form-control  @if ($errors->has('coverage_rating')) parsley-error @endif" id="coverage_rating" name="coverage_rating" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                    @if (empty(old('coverage_rating')))
                    <option disabled selected> Select</option>
                    @endif
                    @foreach ($staticData['coverageRating'] as $key => $coverage_rating)
                    <option value="{{ $coverage_rating['id'] }}" {{ old('coverage_rating') == $coverage_rating['id']? 'selected' : '' }}>
                        {{ $coverage_rating['title'] }}
                    </option>
                    @endforeach
                </select>
                @error('coverage_rating')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Chat Response Speed:</label>
                <select class="form-control  @if ($errors->has('chat_response_speed')) parsley-error @endif" id="chat_response_speed" name="chat_response_speed" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                    @if (empty(old('chat_response_speed')))
                    <option disabled selected> Select</option>
                    @endif
                    @foreach ($staticData['chatResponseSpeed'] as $key => $chat_response_speed)
                    <option value="{{ $chat_response_speed['id'] }}" {{ old('chat_response_speed') == $chat_response_speed['id']? 'selected' : '' }}>
                        {{ $chat_response_speed['title'] }}
                    </option>
                    @endforeach
                </select>
                @error('chat_response_speed')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>


        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Behavior:</label>
                <select class="form-control  @if ($errors->has('behavior')) parsley-error @endif" id="behavior" name="behavior" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                    @if (empty(old('behavior')))
                    <option disabled selected> Select </option>
                    @endif
                    @foreach ($staticData['behavior'] as $key => $behavior)
                    <option value="{{ $behavior['id'] }}" {{ old('behavior') == $behavior['id'] ? 'selected' : '' }}>{{ $behavior['title'] }}
                    </option>
                    @endforeach
                </select>
                @error('behavior')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>



        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Match Campaigns: </label>
                <select class="form-control select2 @if ($errors->has('match_campaign')) parsley-error @endif" multiple id="match_campaign" name="match_campaign[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
                    @foreach ($staticData['matchCampaigns'] as $matchCamp)
                    <option value={{ $matchCamp->id }} {{ collect(old('match_campaign'))->contains($matchCamp->id) ? 'selected' : '' }}>
                        {{ $matchCamp->name }}
                    </option>
                    @endforeach
                </select>
                @error('match_campaign')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        {{-- <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Platforms: </label>
                                        <select
                                            class="form-control select2 @if ($errors->has('social_coverage')) parsley-error @endif"
                                            multiple id="social_coverage" name="social_coverage[]"
                                            data-parsley-class-handler="#slWrapper2"
                                            data-parsley-errors-container="#slErrorContainer2"
                                            data-placeholder="Select One Or More">
                                            @foreach ($staticData['socialCoverage'] as $key => $socialCov)
                                                <option value={{ $socialCov['key'] }}
        {{ collect(old('social_coverage'))->contains($socialCov['key']) ? 'selected' : '' }}>
        {{ $socialCov['value'] }}</option>
        @endforeach
        </select>
        @error('social_coverage')
        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
            <li class="parsley-required">{{ $message }}</li>
        </ul>
        @enderror
    </div>

</div> --}}




{{--
                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Agrees To All Campaign Types:</label>
                                        <select
                                            class="form-control  @if ($errors->has('recommended_any_camp')) parsley-error @endif"
                                            id="recommended_any_camp" name="recommended_any_camp"
                                            data-parsley-class-handler="#slWrapper2"
                                            data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                            @if (empty(old('recommended_any_camp')))
                                                <option disabled selected> Select</option>
                                            @endif
                                            @foreach ($staticData['recommendedAnyCamp'] as $key => $recom)
                                                <option value="{{ $recom['id'] }}"
{{ old('recommended_any_camp') == $recom['id'] ? 'selected' : '' }}>
{{ $recom['title'] }}
</option>
@endforeach
</select>
@error('recommended_any_camp')
<ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
    <li class="parsley-required">{{ $message }}</li>
</ul>
@enderror
</div>
</div> --}}

<div class="col-12 social_media_card">
    <h5><i class="fas fa-link"></i> Authentication</h5>
    <hr>
    <div class="row">
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Username: <span class="text-danger">*</span></label>
                <input onkeyup="this.value=removeSpaces(this.value);" class="form-control @if ($errors->has('user_name')) parsley-error @endif" value="{{ old('user_name') }}" name="user_name" placeholder="Enter Username" type="text">
                @error('user_name')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Email: <span class="text-danger">*</span></label>
                <input onkeyup="this.value=removeSpaces(this.value);" class="form-control  @if ($errors->has('email')) parsley-error @endif" value="{{ old('email') }}" name="email" placeholder="Enter Email" type="text">
                @error('email')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Password: <span class="text-danger">*</span></label>
                <i class="fas fa-eye"></i>
                <input class="form-control @if ($errors->has('password')) parsley-error @endif" value="{{ old('password') }}" name="password" placeholder="Enter Password" type="password">
                @error('password')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Password Confirmation: <span class="text-danger">*</span></label>
                <i class="fas fa-eye"></i>
                <input class="form-control  @if ($errors->has('password_confirmation')) parsley-error @endif" value="{{ old('password_confirmation') }}" name="password_confirmation" placeholder="Re-enter Password" type="password">
                @error('password_confirmation')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Status: <span class="text-danger">*</span></label>
                <select class="form-control select2 @if ($errors->has('active')) parsley-error @endif" id="status_infl" value="{{ old('active') }}" name="active" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                    <!-- <option label="Select" disabled selected></option> -->
                    <option value=""> Select</option>



                    @foreach ($statInflue as $social_class)
                    <option value="{{ $social_class['id'] }}">{{ $social_class['name'] }} </option>
                    @endforeach

                </select>
                @error('active')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12 databindOnlyDelivery">
            <div class="form-group">
                <label class="form-label">Country Visit: <span class="text-danger">*</span></label>
                <select class="form-control  @if ($errors->has('country_visited_outofcountry')) parsley-error @endif" id="country_visited_outofcountry" name="country_visited_outofcountry" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select<">
                    @if (empty(old('country_visited_outofcountry')))
                    <option disabled selected> Select</option>
                    @endif
                    @foreach ($countries_active as $country)
                    <option value="{{ $country->id }}" {{ old('country_visited_outofcountry') == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                    @endforeach
                </select>
                @error('country_visited_outofcountry')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12 databindOnlyDelivery">

            <div class="form-group">
                <label class="form-label">Returned Date: </label>
                <input class="form-control @if ($errors->has('influencer_return_date')) parsley-error @endif" value="{{ old('influencer_return_date') }}" name="influencer_return_date" placeholder="Enter Date" type="date" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                @error('influencer_return_date')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>


        </div>

        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <div class="form-group">
                <label class="form-label">Account Expiration Date: </label>
                <input class="form-control @if ($errors->has('expirations_date')) parsley-error @endif" value="{{ old('expirations_date') }}" name="expirations_date" placeholder="Enter Date" type="date" min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                @error('expirations_date')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
    </div>
</div>
<!--  Social Status -->

<!--  Social Media -->
<div class="col-12 social_media_card">
    <h5 class="mt-3"><i class="fas fa-link"></i> Social Media</h5>
    <hr>
    <div class="row">

        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <label class="form-label">Facebook: </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color: #fff;" class="fab fa-facebook"></i></span>
                </div>
                <input type="text" name="facebook_uname" value="{{ old('facebook_uname') }}" placeholder="Enter Facebook Username" class="form-control @if ($errors->has('facebook_uname')) parsley-error @endif">
                @error('facebook_uname')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <label class="form-label">Youtube: </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color: #fff;" class="fab fa-youtube"></i></span>
                </div>
                <input type="text" name="youtube_uname " value="{{ old('youtube_uname ') }}" placeholder="Enter Youtube Username" class="form-control @if ($errors->has('youtube_uname ')) parsley-error @endif">
                @error('youtube_uname ')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>

        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <label class="form-label">TikTok: </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color: #fff;" class="fas fa-icons"></i></span>
                </div>
                <input class="form-control @if ($errors->has('tiktok_uname')) parsley-error @endif" value="{{ old('tiktok_uname') }}" name="tiktok_uname" placeholder="Enter TikTok Username" type="text">
                @error('tiktok_uname')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <label class="form-label">Snapchat:</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color: #fff;" class="fab fa-snapchat"></i></span>
                </div>
                <input class="form-control @if ($errors->has('snapchat_uname')) parsley-error @endif" value="{{ old('snapchat_uname') }}" name="snapchat_uname" placeholder="Enter Snapchat Username" type="text">
                @error('snapchat_uname')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <label class="form-label">Twitter: </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color: #fff;" class="fab fa-twitter"></i></span>
                </div>
                <input class="form-control @if ($errors->has('twitter_uname')) parsley-error @endif" value="{{ old('twitter_uname') }}" name="twitter_uname" placeholder="Enter Twitter Username" type="text">
                @error('twitter_uname')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>
        <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
            <label class="form-label">Website: </label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color: #fff;" class="fas fa-globe"></i></span>
                </div>
                <input class="form-control @if ($errors->has('website_uname')) parsley-error @endif" value="{{ old('website_uname') }}" name="website_uname" placeholder="Enter Website URL" type="url">
                @error('website_uname')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                    <li class="parsley-required">{{ $message }}</li>
                </ul>
                @enderror
            </div>
        </div>




        {{-- <div class="col-md-4 mt-3">
                                        <h6> CheckBox </h6>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                value="option1">
                                            <label class="form-check-label" for="inlineCheckbox1">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                value="option1">
                                            <label class="form-check-label" for="inlineCheckbox1">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                value="option1">
                                            <label class="form-check-label" for="inlineCheckbox1">3</label>
                                        </div>
                                    </div> --}}


    </div>
</div>

</div>
</div>
<div class="col-12 text-right"><button class="btn btn-primary pd-x-20 mg-t-10" style="width: 150px" type="submit"> <i class="far fa-save"></i> Save </button></div>

</div>
</form>
</div>
</div>
</div>
</div>
@stop

@section('js')


<script src="https://unpkg.com/bootstrap-multiselect@0.9.13/dist/js/bootstrap-multiselect.js"></script>

{{-- <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script> --}}
<script>
    $(document).ready(function() {
        $(".databindOnlyDelivery").hide();
    });

    $('#status_infl').on('change', function() {
        $(".databindOnlyDelivery").hide();
        console.log(4243);
        var selected = [];
        valuesele = $('#status_infl').find(":selected").val();
        if (valuesele == 7) {
            $(".databindOnlyDelivery").show();

        }


    });











    /////////////////////
    $('#category_id').on('change', function() {
        for (var option of document.getElementById('category_id').options) {
            option.removeAttribute('disabled');
        }
        var selected = [];
        for (var option of document.getElementById('category_id').options) {
            if (option.selected) {
                selected.push(option.value);
            }
            console.log(selected)
        }
        if (selected.includes("7") || selected.includes("8")) {
            if (selected.includes("9") || selected.includes("10") || selected.includes("11") || selected.includes("12")) {
                for (var option of document.getElementById('category_id').options) {
                    option.setAttribute('disabled', true);
                }
            }
        }
    });
    $('#chkveg').on('change', function() {

        var id = $(this).find(':selected').attr('id');
        console.log('sele_' + id);
        if (id) {
            var ele = $('#' + 'sele_' + id).hide()
            console.log(ele)
        }

    });


    $(function() {

        $('#chkveg').multiselect({
            allSelectedText: 'All Classification Already Selected',
            numberDisplayed: 10,
        });
    });

    function removeSpaces(string) {
        return string.split(' ').join('');
    }


    var expanded = false;

    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }

    let code_phone_val = 0;
    let subbrand_phone_val = 0;

    $('[name="main_phone_code"]').on('change', function() {
        if ($(this).val() != null && $(this).val() != '') {
            code_phone_val = 1;
        } else {
            code_phone_val = 0;
        }
        checkToggleWhatsapp();
    })
    $('[name="main_phone"]').on('input', function() {
        if ($(this).val() != null && $(this).val() != '') {
            subbrand_phone_val = 1;
        } else {
            subbrand_phone_val = 0;
        }
        checkToggleWhatsapp();
    })

    function checkToggleWhatsapp() {
        if (code_phone_val == 1 && subbrand_phone_val == 1) {
            $('.togBtn').attr('disabled', false)

        } else {
            $('.togBtn').attr('disabled', true)
        }
    }


    var switchStatus = false;
    @if(!empty(old('whatsapp_code')) && old('whatsapp_code') == old('main_phone_code'))
    $(".togBtn").addClass('on');
    $(".togBtn").prop('checked', true);
    $(".togBtn").prop('disabled', false);
    switchStatus = true
    hideShowWhatsappInput(switchStatus)
    @endif
    //Toggle

    $('.main-toggle').on('click', function() {
        $(this).toggleClass('on');
    })

    $(".togBtn").on('click', function() {
        if ($(this)[0].classList.contains("on"))
            switchStatus = !switchStatus;
        else
            switchStatus = !switchStatus;

        hideShowWhatsappInput(switchStatus)
    });

    function hideShowWhatsappInput(switchStatus) {

        if (switchStatus) {
            $("#whatsappSection input").val($('input[name="main_phone"]').val())
            $('#whatsappSection select').val($('select[name="main_phone_code"]').val()).trigger('change');
            $("#whatsappSection").fadeOut(500)
        } else {
            $("#whatsappSection input").val(null)
            $('#whatsappSection select').val(null).trigger('change');
            $("#whatsappSection").fadeIn(500)
        }
    }

    function diableChars(event) {
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }

    function format(item, state) {
        if (!item.id) {
            return item.text;
        }
        var flag = item.element.attributes[1];
        var countryUrl = "https://hatscripts.github.io/circle-flags/flags/";
        var url = state ? stateUrl : countryUrl;
        var img = $("<img>", {
            class: "img-flag-all",
            width: 18,
            src: url + flag.value.toLowerCase() + ".svg"
        });
        var span = $("<span>", {
            text: " " + item.text
        });
        span.prepend(img);
        return span;
    }

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        var flag = state.element.attributes[1].value;
        var baseUrl = "https://hatscripts.github.io/circle-flags/flags/";
        var $state = $(
            '<span><img class="img-flag" width="22"/> <span></span></span>'
        );
        $state.find("img").attr("src", baseUrl + "/" + flag.toLowerCase() + ".svg");
        return $state;
    };

    $('.phoneInput').on('keypress', function(event) {
        diableChars(event)
    });
    var i = 1;
	alert("ddddddddddddddddddddddddddddd");
    $("#add_phone_input").click(function(event) {
        event.preventDefault()
        let selectData =
            `<div class="input-group-prepend type_phone_div custom-2 col-3">

                    <div class="type_phone">
                    <select class="input-group-text" name="phone_type[]" id="phone_type_${i}" data-placeholder="Code" style="width:145px;" placeholder="select">
                        <option value="" disabled selected>Select</option>
                        @foreach ($staticData['typePhone'] as $key => $typephone)
                        selectData +=
                         '<option value="{{ $typephone['id'] }}">{{ $typephone['title'] }} </option>'
                        @endforeach
                        selectData +
                    </select>
                  </div>

                    <select class="input-group-text country_code select2" id="country_code_${i}" name="phone_code[]" data-placeholder="Code" style="width:400px;"> <option></option>`
        @foreach($countries_active as $country)
        selectData +=
            '<option value="{{ $country->phonecode }}" data-flag="{{ $country->code }}" > (+){{ $country->phonecode }} </option>'
        @endforeach
        $(".allPhones").append(
            '<div class="inputs inputs-margin" style="display: flex;width: 60% !important;align-items: flex-start;justify-content:flex-start;gap: 25px;margin-top: 10px">' +
            selectData +
            '</select> </div>  <input style="display:inline-block;margin-left: 12px;flex-basis: 80.5%;" min="0" class=" form-control phoneInput" onkeypress="diableChars(event)"  placeholder="Enter Phone Number" type="number" name="phone[]" >' +
            ' <a href="javascript:void(0)" onClick="deleteBranch(this)" class="deleterr btn btn-danger" >' +
            '<i class="fas fa-trash-alt" style="margin:0rem !important"></i></a></div>');
        selectCountry()
        i = i + 1;
    });


    function deleteBranch(e) {
        $(e).parents(".inputs").remove();
        if ($(e).children(".input-group-prepend"))
            $(e).children(".input-group-prepend").remove();
        else
            $(e).parents(".inputs").children('.input-group-prepend').first().remove()
    }
    $('.select2').select2({
        placeholder: "Select",
        allowClear: true,

    });

   
    function getStateData(val) {
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            url: "/dashboard/state/" + val,
            corssDomain: true,
            dataType: "json",
            success: function(data) {
                //$('.state').show()
                $('#state_id').prop('disabled', false);
                var listItems = ""
                @if(empty(old('state_id')))
                listItems = "<option value=''>Select </option>";
                @endif
                $.each(data.data, function(key, value) {
                    let oldState = null
                    @if(!empty(old('state_id')))
                    oldState = "{{ old('state_id') }}"
                    if (oldState == value.id)
                        listItems += "<option value='" + value.id + "' selected >" + value
                        .name + "</option>";
                    else
                        listItems += "<option value='" + value.id + "'>" + value.name +
                        "</option>";
                    @else
                    listItems += "<option value='" + value.id + "' >" + value.name +
                        "</option>";
                    @endif
                });
                $("#state_id").html(listItems);
            },

            error: function(data) {

            }
        });
    }

    function getCity(val) {
        log = console.log;
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            url: "/dashboard/city/" + val,
            corssDomain: true,
            dataType: "json",
            success: function(data) {


                $('#city_id').prop('disabled', false);
                var listItems = "";
                @if(empty(old('city_id')))
                listItems = "<option value=''>Select City </option>";
                @endif
                $.each(data.data, function(id, name) {
                    let oldCity = null
                    @if(!empty(old('city_id')))
                    oldCity = "{{ old('city_id') }}"
                    if (oldCity == id)
                        listItems += "<option value='" + id + "' selected >" + name +
                        "</option>";
                    else
                        listItems += "<option value='" + id + "'>" + name + "</option>";
                    @else
                    listItems += "<option value='" + id + "'>" + name + "</option>";
                    @endif
                });
                $("#city_id").html(listItems);
            },

            error: function(data) {

            }
        });
    }

    function socialType(type) {
        $("#children_num").val('')
        $("#childrenContainer .row").html('')
        if (type != 1) {
            $("#children_num").parent().slideDown(500)
        } else {
            $("#children_num").parent().slideUp(500)
        }
    }

    function childrenContainer(numberOfChildren) {

        for (let children = 0; children < numberOfChildren; children++) {

            $("#childrenContainer").append(`
                    <div class="row">

                    <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="child_name">Children Name </label>
                                    <input type="text" name="childname[]" placeholder="Children Name " class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="DOB">Children Date Of Birth</label>
                                    <input type="date" name="childdob[]" class="form-control"  max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" >
                                </div>
                                <div class="col-md-4" >
                                    <label for="gender" style="display:block">Children Gender</label>
                                    <select class="input-group-text childrenGender select2" placeholder="Children Type" name="childgender[]">
                                        <option value="" selected disabled>Children Type</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                `)
        }
    }
    $("#children_num").off().on('input', function(event) {

        $("#childrenContainer").html('')
        event.preventDefault()
        let numberOfChildren = event.target.value;
        childrenContainer(numberOfChildren)
        $(".childrenGender").select2({
            placeholder: "Select Children Gender ",
            allowClear: true
        });
    })
    $(document).on('change', '#influencer_gender', function() {
        let val_gander = $(this).val();
        $('.socialRadioType').each(function(i, element) {
            if (val_gander == 1) {
                if ($(element).attr('data-type') == 4) {
                    $(element).parent().hide()
                } else if ($(element).attr('data-type') == 3) {
                    $(element).parent().show()
                }
            } else {
                if ($(element).attr('data-type') == 3) {
                    $(element).parent().hide()
                } else if ($(element).attr('data-type') == 4) {
                    $(element).parent().show()
                }
            }
        })

    });
</script>

<script>
    //ShowPassword
    $('.fa-eye').on('click', function(e) {
        input = $(this).parent().children('.form-control');
        inputType = input.attr('type');
        if (inputType == "password") {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }
    });
</script>

@stop
