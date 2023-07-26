@extends('admin.dashboard.layouts.app')
@section('title','Edit Influencer Profile')
@section('style')
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.css')}}">
    <!--- Internal Sweet-Alert css-->
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--- Internal Sweet-Alert css-->
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: test-field;
        }
        .switch_parent input[type='checkbox']{
            display: block;
            opacity: 0;
        }
        .switch_parent .switch{
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
        .switch_parent .switch:after{
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
        .switch_parent input[type='checkbox']:checked + .switch{
            background: #009900;
        }
        .switch_parent input[type='checkbox']:checked + .switch:after{
            left: auto;
            right: 2px;
        }
        .select2-results__options{
            background: var(--main-bg-color);
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

@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Edit Influencer Profile</h2>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@stop
@section('content')

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Edit Influencer Profile</h4>
                        <a href="{{route('dashboard.influences.index')}}" class="btn mt-2 mb-2 pb-2" style="color:#fff"><i class="fas fa-long-arrow-alt-left"></i> Back </a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="create_page" action="{{route('dashboard.influences.update',$influencer->id)}}"  method="post" data-parsley-validate="" novalidate="" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="row row-sm">
                            <div class="col-12 social_media_card">
                               <h5 class="mt-3"><i class="fas fa-link"></i> General</h5>
                                 <hr>
                                  <div class="row">
                        <input type="hidden" name="id" value="{{$influencer->id}}" >
                        <input type="hidden" name="user_id" value="{{$influencer->user_id}}" >

                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group mg-b-0">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Name: <span class="text-danger">*</span></label>
                                    <input class="form-control  @if($errors->has('name'))  parsley-error @endif " value="{{old('name',$influencer->name)}}" name="name" placeholder="Enter Name" type="text" >
                                    @error('name')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Image: </label>
                                    <div class="custom-file">
                                        <input type="file" value="{{old('fileReader')}}" name="image" class="custom-file-input @if($errors->has('image'))  parsley-error @endif" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                    @error('image')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Instagram: <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="" class="fab fa-instagram"></i></span>
                                    </div>
                                    <input
                                     onkeyup="this.value=removeSpaces(this.value);"
                                     class="form-control @if($errors->has('insta_uname'))  parsley-error @endif" value="{{ old('insta_uname',$influencer->insta_uname)}}" name="insta_uname" placeholder="Enter Instagram Username" type="text">
                                    @error('insta_uname')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Nationality: <span class="text-danger">*</span></label>
                                    <select class="form-control  @if($errors->has('nationality'))  parsley-error @endif" id="nationality" name="nationality" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one or more" >
                                        <option disabled selected> Select Nationality....</option>

                                        @foreach($nationalities as $nationality)
                                            <option value="{{$nationality->id}}"
                                                    {{old('nationality')==$nationality->id? "selected":""}}
                                                    @if($nationality->id ==$influencer->nationality ) selected @endif
                                            >{{$nationality->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('nationality')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>





                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Country: <span class="text-danger">*</span></label>
                                    <select class="form-control  @if($errors->has('country_id'))  parsley-error @endif" id="country_id" name="country_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one or more" >
                                        <option disabled selected> Select Country....</option>
                                        @foreach($countries_active as $country)
                                        <option value="{{$country->id}}" {{old('country_id')==$country->id? "selected":""}} @if($country->id ==(integer)$influencer->country_id ) selected @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12 state"  >
                                <div class="form-group">


                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Government: <span class="text-danger">*</span></label>
                                    <select class="form-control  @if($errors->has('state_id'))  parsley-error @endif" id="state_id" name="state_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" >
                                        @if(isset($influencer->country))
                                            @if(!empty($influencer->country->states()))
                                                @foreach($influencer->country->states()->get() as $state)
                                                    <option value="{{$state->id}}" @if($influencer->state_id == $state->id ) selected @endif>{{$state->name}}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                    @error('state_id')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12 city"  >
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">City: <span class="text-danger">*</span></label>
                                    <select class="form-control  @if($errors->has('city_id'))  parsley-error @endif" id="city_id" name="city_id" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" >
                                       @if($influencer->country)
                                        @foreach($influencer->country->cities()->get() as $city)
                                            <option value="{{$city->id}}" @if($influencer->city_id == $city->id || old('city_id') ==$city->id ) selected="selected" @endif>{{$city->name}}</option>
                                        @endforeach
                                       @endif
                                    </select>
                                    @error('city_id')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12 main-toggle-group-demo">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; "> WhatsApp is activated with the same number: <span class="text-danger">*</span></label>
                                    <div class="switch_parent"  >
                                        <input type="checkbox" name="whatsapp_toggle" id="switch" class="switch_toggle main-toggle  togBtn " @if(!empty($influencer->user->phone) && $influencer->whats_number === $influencer->user->phone) checked @endif  ></input>
                                        <label class="switch" for="switch" title="inactive"></label>
                                    </div>
                                            {{--                                    <div class="main-toggle main-toggle-dark @if($influencer->whats_number === $influencer->user->phone) on @endif" id="togBtn">--}}
                                            {{--                                        <span></span>--}}
                                            {{--                                    </div>--}}
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12" id="whatsappSection" @if($influencer->whats_number === $influencer->user->phone) style="display:none;" @endif >
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">WhatsApp Phone Number: <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="input-group">
                                            <div class="input-group-prepend custom-1 col-3">
                                                <select class="input-group-text country_code select2" name="whatsapp_code" data-placeholder="Code" style="width:200px;">
                                                    @foreach($countries_active as $country)
                                                        <option></option>
                                                        <option value="{{$country->phonecode}}"  data-flag="{{$country->code}}"  @if((isset($influencer->code_whats) && $influencer->code_whats==$country->phonecode) || ( !empty(old('whatsapp_code')) && old('whatsapp_code')==$country->phonecode ) ) selected @endif  > (+){{$country->phonecode}} </option>
                                                    @endforeach
                                                </select>
                                                @error('whatsapp_code')
                                                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                            @error('whats_number')
                                                <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                            </div>
                                            <div class="col-9">
                                                <input class="form-control phoneInput @if($errors->has('whats_number'))  parsley-error @endif" value="{{old('whats_number',$influencer->whats_number)}}" name="whats_number" placeholder="Enter WhatsApp Phone Number" type="number" onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-12 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Phone Number:</label>
                                    <div class="row allPhones">

                                        @if(old('phone'))
                                            @for( $i =0; $i < count(old('phone')); $i++)
                                                <div class="inputs" style="display: flex;width: 100% !important;align-items: center;gap: 25px" min="0">
                                                    <div class="input-group-prepend " style="width: 150px;">
                                                        <div class="type_phone">
                                                            <select class="input-group-text" name="phone_type[]" data-placeholder="Code" style="width:73px;">
                                                                @foreach ($staticData['typePhone'] as $key => $typephone)

                                                                <option value="{{$typephone['id']}}"
                                                                {{ !empty(old('phone_type')[$i]) && old('phone_type')[$i] == $typephone['id'] ? 'selected' : '' }}>{{$typephone['title']}}</option>
                                                               @endforeach
                                                            </select>
                                                        </div>

                                                        <select class="input-group-text country_code select2" name="phone_code[]" data-placeholder="Code" style="width:200px;">
                                                            <option></option>
                                                            @foreach($countries_active as $country)
                                                                <option value="{{$country->phonecode}}" data-flag="{{$country->code}}" {{ (!empty(old('phone_code')[$i]) && old('phone_code')[$i]==$country->phonecode) ? 'selected':'' }} > (+){{$country->phonecode}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input style="margin-top: 0px !important;height: 34px !important;margin-left: 20px;" type="text" value="{{ old('phone.'.$i)}}"  placeholder="Enter Phone Number" type="number" min="0"  name="phone[]" class=" phoneInput form-control  @if($errors->has('phone.*'))  parsley-success @endif">

                                                    <a href="javascript:void(0)" onClick="deleteBranch(this)" class="deleterr btn btn-danger mb-3" ><i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            @endfor
                                        @endif

                                        @if(!old('phone'))
                                            @if($influencer->InfluencerPhones)
                                                @foreach($influencer->InfluencerPhones as $key=>$phones)
                                                    @if(!is_null($phones))

                                                    <div class="col-12">
                                                        <div class="inputs" style="display: flex;width: 100% !important;align-items: flex-start;justify-content:flex-start;gap: 25px">
                                                            <div class="input-group  ">
                                                                <div class="input-group-prepend type_phone_div custom-3">

                                                                    <div class="type_phone">
                                                                        <select class="input-group-text" name="phone_type[]" data-placeholder="Code" style="width:73px;">
                                                                            @foreach ($staticData['typePhone'] as $key => $typephone)
                                                                            <option value="{{$typephone['id']}}" {{$typephone['id'] == $phones->type ? 'selected': '' }}>{{$typephone['title']}}</option>
                                                                           @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <select class="input-group-text country_code select2" name="phone_code[]" data-placeholder="Code" style="width:78px;!important">
                                                                        @foreach($countries_active as $country)
                                                                            <option value="{{$country->phonecode}}" data-flag="{{$country->code}}" {{($country->phonecode  == $phones->code)  ? 'selected' : ''}} > (+){{$country->phonecode}} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <input  style="margin-top: 0 !important;height: 34px !important;margin-right: 20px" class="form-control @if($errors->has('phone.*'))  parsley-error @endif" value="{{$phones->phone}}" name="phone[]" placeholder="Enter Phone" type="number" min="0">
                                                            </div>
                                                            <a href="javascript:void(0)" onClick="deleteBranch(this)" class="deleterr btn btn-danger mb-2" ><i class="fas fa-trash-alt"></i></a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <div class="col-12">
                                                    <div class="inputs" style="display: flex;width: 100% !important;align-items: flex-start;justify-content:flex-start;gap: 25px">
                                                        <div class="input-group  mb-3 align-items-end">
                                                            <div class="input-group-prepend custom-3">
                                                                <select class="input-group-text country_code select2" name="phone_code[]" data-placeholder="Code" style="width:78px;!important">
                                                                    <option></option>
                                                                    @foreach($countries_active as $country)
                                                                        <option value="{{$country->phonecode}}" data-flag="{{$country->code}}"  @if( !empty(old('phone_code')) && (old('phone_code')== $country->phonecode) ) selected @endif > (+){{$country->phonecode}} </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <input class="form-control @if($errors->has('phone.*'))  parsley-error @endif" value="{{old('phone.*')}}" name="phone[]" placeholder="Enter Phone" type="number" min="0">
                                                        </div>
                                                        <a href="javascript:void(0)" onClick="deleteBranch(this)" class="deleterr btn mb-2" ><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        <div class="col-2">
                                            <button type="button" id="add_phone_input" class="add_phone_input btn"><i class="fas fa-plus"></i></button>
                                        </div>

                                    </div>
                                    @error('phone_code.*')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                    @error('phone.*')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Main Phone Number: <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="input-group">
                                            <div class="input-group-prepend custom-1 col-3">
                                                <select class="input-group-text country_code" name="main_phone_code" data-placeholder="Code" style="width:200px;">
                                                    @foreach($countries_active as $country)
                                                        @if(!is_null($influencer->user))
                                                            <option value="{{$country->phonecode}}"  data-flag="{{ $country?->code }}" @if(isset($country->phonecode) && $influencer->user->code == $country->phonecode) selected @endif> (+){{$country->phonecode}} </option>
                                                        @else
                                                            <option value="{{$country->phonecode}}"  data-flag="{{ $country?->code }}" @if(isset($country->phonecode) ) selected @endif> (+){{$country->phonecode}} </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="inputs col-9">
                                                @if(!is_null($influencer->user))
                                                    <input class="form-control @if($errors->has('main_phone'))  parsley-error @endif" value="{{old('main_phone',$influencer->user->phone)}}" name="main_phone" placeholder="Enter Main Phone Number" type="number" onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109">
                                                @else
                                                    <input class="form-control @if($errors->has('main_phone'))  parsley-error @endif" value="{{old('main_phone',$influencer->whats_number)}}" name="main_phone" placeholder="Enter Main Phone Number" type="number" onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @error('main_phone_code')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                    @error('main_phone')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Gender: <span class="text-danger">*</span></label>
                                    <select class="form-control select2 @if($errors->has('gender'))  parsley-error @endif" value="{{old('gender')}}" name="gender" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select">
                                        <option label="Choose one" disabled selected></option>
                                        <option value=1 @if($influencer ->gender==1) selected @endif {{old('gender')==1 ? "selected" : ""}}>Male</option>
                                        <option value=0 @if($influencer ->gender=="0") selected @endif {{old('gender')=="0" ? "selected" : ""}}>Female</option>
                                    </select>
                                    @error('gender')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Date Of Birth: <span class="text-danger">*</span></label>
                                    <input class="form-control @if($errors->has('date_of_birth'))  parsley-error @endif" value="{{old('date_of_birth',$influencer->date_of_birth?->format('Y-m-d'))}}" name="date_of_birth" placeholder="Enter Date OF Birth" type="date" max="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                                    @error('date_of_birth')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Address <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <textarea class="form-control @if($errors->has('address'))  parsley-error @endif" value="" name="address" placeholder="Enter Address" type="text">
                                                {{$influencer->address ?? ''}}
                                            </textarea>
                                        </div>
                                    </div>
                                    @error('address')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                           </div>
                      </div>
                 </div>
                        <hr/>

                        {{-- <div class="col-12 social_media_card"> --}}
                            <h5 class="mt-3"><i class="fas fa-link"></i> Advanced</h5>
                              <hr>
                               <div class="row">
                                @inject('allStatus', 'App\Models\InfluencerClassification')
                                @php
                                    $classifi = $allStatus->get(['id','name']);

                                @endphp

                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div style="padding:22px 0" class="multiple_select_classification">
                                        <select name="classification_ids[]" id="chkveg" multiple="multiple">
                                                @foreach ($classifi as $class)
                                            <option value="{{ $class->id }}"  {{$influencer->classification_ids != null && in_array($class->id,$influencer->classification_ids) ? 'selected' : '' }}> {{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Job:</label>
                                        <select class="form-control  @if($errors->has('job'))  parsley-error @endif" id="job" name="job" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                            <option disabled selected> Select</option>
                                        @foreach($jobs as $job)
                                                <option value="{{$job->id}}"
                                                        {{old('job')==$job->id? "selected":""}}
                                                        @if($job->id ==$influencer->job ) selected @endif
                                                >{{$job->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('job')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Interests: <span class="text-danger">*</span></label>
                                        <select class="form-control select2 @if($errors->has('interest'))  parsley-error @endif"  multiple  name="interest[]"  id="interest" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
                                            @foreach($interests as $interest)
                                                <option value={{$interest->id}} {{ (  collect(old('interest'))->contains($interest->id) || collect($influencer->interest)->contains($interest->id) ) ? 'selected':'' }}>{{$interest->interest }}</option>
                                            @endforeach
                                        </select>
                                        @error('interest')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Lifestyle:</label>
                                        <select class="form-control  @if($errors->has('ethink_category'))  parsley-error @endif" id="ethink_category" name="ethink_category" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" >
                                            <option disabled selected>Select</option>
                                            @foreach($staticData['ethinkCategory'] as $key=>$ethink)
                                                <option value="{{$ethink['id']}}"
                                                        {{old('ethink_category') == $ethink['id']? "selected":""}}
                                                        @if($ethink['id'] ==$influencer->ethink_category ) selected @endif
                                                >{{$ethink['title']}}</option>
                                            @endforeach
                                        </select>
                                        @error('ethink_category')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Languages: <span class="text-danger">*</span></label>
                                        <select class="form-control select2 @if($errors->has('lang'))  parsley-error @endif" multiple  id="lang" name="lang[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
                                            @foreach($languages as $lang)
                                                <option value={{$lang->id}} {{ (collect(old('lang'))->contains($lang->id) || in_array($lang->id,$influencer->lang)) ? 'selected':'' }}>{{$lang->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('lang')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Account Type:</label>
                                        <select class="form-control  @if($errors->has('account_type'))  parsley-error @endif" id="account_status" name="account_type" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                            <option disabled selected> Select</option>
                                            @foreach($staticData['accountType'] as $key=>$account_type)
                                                <option value="{{$account_type['id']}}"
                                                        {{old('account_type')==$key? "selected":""}}
                                                        @if($account_type['id'] ==$influencer->account_type ) selected @endif
                                                >{{$account_type['title']}}</option>
                                            @endforeach
                                        </select>
                                        @error('account_type')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Citizenship:</label>
                                        <select class="form-control  @if($errors->has('citizen_status'))  parsley-error @endif" id="citizen_status" name="citizen_status" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                            <option disabled selected> Select</option>
                                            @foreach($staticData['citizenStatus'] as $key=>$citizen_status)
                                                <option value="{{$key}}"
                                                        {{old('citizen_status')==$citizen_status['id']? "selected":""}}
                                                        @if($citizen_status['id'] ==$influencer->citizen_status ) selected @endif
                                                >{{$citizen_status['title']}}</option>
                                            @endforeach
                                        </select>
                                        @error('citizen_status')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>



                            {{-- <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Social Class:</label>
                                    <select class="form-control  @if($errors->has('social_class'))  parsley-error @endif" id="social_class" name="social_class" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                        <option disabled selected> Select</option>
                                        @foreach($staticData['socialClass'] as $key=>$social_class)
                                            <option value="{{$social_class['id']}}"
                                                    {{old('social_class')==$social_class['id']? "selected":""}}
                                                    @if($social_class['id'] ==$influencer->social_class) selected @endif
                                            >{{$social_class['title']}}</option>
                                        @endforeach
                                    </select>
                                    @error('social_class')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div> --}}

                            @inject('category', 'App\Models\Category')
                            @php
                                $categories = $category->get();
                            @endphp

                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Category:</label>
                                    <select id="category_id" class="form-control select2 @if($errors->has('status'))  parsley-error @endif" id="status" name="category_ids[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select" multiple="multiple">
                                        <option disabled >Select </option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->getAttributes()['title']}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_ids')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>




                            <div class="col-12 social_status_card">
                                <h5><i class="fas fa-link"></i>Marital Status</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                        <div class="form-group">
                                            @foreach($socialStatus as $social)
                                                <div class="form-check-inline _input__checkbox">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="marital_status" value="{{$social['id']}}" onchange="socialType('{{$social['id']}}')" @if(old('marital_status', $influencer->marital_status) == $social['id']) checked @endif  >
                                                        {{$social['name']}}
                                                    </label>
                                                </div>
                                            @endforeach
                                            @error('password')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12" @if ( $influencer->social_type == 1 || empty($influencer->children_num) ) style="display: none;" @endif>
                                        <label for="lang" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Children Number</label>
                                        <input class="form-control" type="number" id="children_num" value="{{old('children_num', $influencer->children_num)}}"  onkeypress="diableChars(event)" name="children_num" min="1" max="15" style="width: 180px">
                                        @error('children_num')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12" id="childrenContainer">

                                        @if(!empty($influencer->ChildrenInfluencer))
                                            @foreach($influencer->ChildrenInfluencer as $key => $children)

                                                <div class="row">
                                                    <div class="col-md-12" >
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="child_name" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Children Name </label>
                                                                <input type="text" name="child_name[]" value="{{$children['child_name']}}" placeholder="Children Name " class="form-control">
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label for="DOB">Children Date Of Birth</label>
                                                                <input type="date" name="child_dob[]" value="{{@$children['child_dob']}}" class="form-control"  max="{{\Carbon\Carbon::today()->format('Y-m-d')}}" >
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="gender" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Children Gender</label>
                                                                <select class="input-group-text childrenGender select2" placeholder="Children Type" name="child_gender[]">
                                                                    <option value="male" @if(isset($children['gender']) && $children['gender'] == "male") selected @endif>Male</option>
                                                                    <option value="female"  @if(isset($children['gender']) &&  $children['gender'] == "female") selected @endif >Female</option>
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




                            {{-- <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Shares Coverage As Posts:</label>
                                    <select class="form-control  @if($errors->has('share'))  parsley-error @endif" id="share" name="share" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                        <option disabled selected> Select</option>
                                        @foreach($staticData['share'] as $key=>$share)
                                            <option value="{{$key}}"
                                                    {{old('share')==$key? "selected":""}}
                                                    @if($key ==$influencer->share ) selected @endif
                                            >{{$share}}</option>
                                        @endforeach
                                    </select>
                                    @error('share')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div> --}}



                               </div>
                            </div>

                        <hr/>


                        <div class="col-12 social_media_card">
                            <h5 class="mt-3"><i class="fas fa-link"></i> More</h5>
                              <hr>
                               <div class="row">




                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Min Voucher:</label>
                                        <select class="form-control  @if($errors->has('min_voucher'))  parsley-error @endif" id="min_voucher" name="min_voucher" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                            <option disabled selected> Select</option>
                                            @for($i=10;$i<=1000;$i+=10)
                                                <option value="{{$i}}"
                                                        {{old('min_voucher')==$i? "selected":""}}
                                                        @if($i ==$influencer->min_voucher) selected @endif
                                                >{{$i}}</option>
                                            @endfor
                                        </select>
                                        @error('min_voucher')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Rating:</label>
                                        <select class="form-control  @if($errors->has('rating'))  parsley-error @endif" id="rating" name="rating" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                            <option disabled selected> Select</option>
                                            @foreach($staticData['rating'] as $key=>$rating)
                                                <option value="{{$key}}"
                                                        {{old('rating')==$key? "selected":""}}
                                                        @if($key ==$influencer->rating ) selected @endif
                                                >{{$rating}}</option>
                                            @endforeach
                                        </select>
                                        @error('rating')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Coverage Rating:</label>
                                        <select class="form-control  @if($errors->has('coverage_rating'))  parsley-error @endif" id="coverage_rating" name="coverage_rating" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                            <option disabled selected> Select Coverage Rating....</option>
                                            @foreach($staticData['coverageRating'] as $key=>$coverage_rating)
                                                <option value="{{$key}}"
                                                        {{old('coverage_rating')==$coverage_rating['id']? "selected":""}}
                                                        @if($key ==$influencer->coverage_rating ) selected @endif
                                                >{{$coverage_rating['title']}}</option>
                                            @endforeach
                                        </select>
                                        @error('coverage_rating')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Chat Response Speed:</label>
                                        <select class="form-control  @if($errors->has('chat_response_speed'))  parsley-error @endif" id="chat_response_speed" name="chat_response_speed" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                            <option disabled selected> Select</option>
                                            @foreach($staticData['chatResponseSpeed'] as $key=>$chat_response_speed)
                                                <option value=" {{$chat_response_speed['id'] }}"
                                                        {{old('chat_response_speed')==$chat_response_speed['id'] ? "selected":""}}
                                                        @if($chat_response_speed['id']  ==$influencer->chat_response_speed ) selected @endif
                                                >{{$chat_response_speed['title']}}</option>
                                            @endforeach
                                        </select>
                                        @error('chat_response_speed')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Behavior:</label>
                                        <select class="form-control  @if($errors->has('behavior'))  parsley-error @endif" id="behavior" name="behavior" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                            <option disabled selected> Select</option>
                                            @foreach($staticData['behavior'] as $key=>$behavior)
                                                <option value="{{$behavior['id']}}"
                                                        {{old('behavior')==$behavior['id']? "selected":""}}
                                                        @if($behavior['id'] ==$influencer->behavior ) selected @endif
                                                >{{$behavior['title']}}</option>
                                            @endforeach
                                        </select>
                                        @error('behavior')
                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                        @enderror
                                    </div>
                                </div>


                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Match Campaigns: </label>
                                    <select class="form-control select2 @if($errors->has('match_campaign'))  parsley-error @endif" multiple  id="match_campaign" name="match_campaign[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one or more">
                                        @foreach($staticData['matchCampaigns'] as $matchCamp)
                                            <option value={{$matchCamp->id}} {{ (collect(old('match_campaign'))->contains($matchCamp->id) || collect($influencer->match_campaign)->contains($matchCamp->id) ) ? 'selected':'' }}>{{$matchCamp->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('match_campaign')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Platforms: </label>
                                    <select class="form-control select2 @if($errors->has('social_coverage'))  parsley-error @endif" multiple  id="social_coverage" name="social_coverage[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More">
                                        @foreach($staticData['socialCoverage'] as $key=>$socialCov)
                                            <option value={{$key}} {{ (collect(old('social_coverage'))->contains($key) || collect($influencer->social_coverage)->contains($key) ) ? 'selected':'' }}>{{$socialCov}}</option>
                                        @endforeach
                                    </select>
                                    @error('social_coverage')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div> --}}

{{--
                            <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" style=" margin: 0.2rem 0rem; min-width: 100%; gap: 10px; font-size: 0.9rem; margin-bottom: 0.6rem; ">Agrees To All Campaign Types:</label>
                                    <select class="form-control  @if($errors->has('recommended_any_camp'))  parsley-error @endif" id="recommended_any_camp" name="recommended_any_camp" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Choose one" >
                                        <option disabled selected> Select</option>
                                        @foreach($staticData['recommendedAnyCamp'] as $key=>$recom)
                                            <option value="{{$key}}"
                                                    {{old('recommended_any_camp')==$key? "selected":""}}
                                                    @if($key ==$influencer->recommended_any_camp) selected @endif
                                            >{{$recom}}</option>
                                        @endforeach
                                    </select>
                                    @error('recommended_any_camp')
                                    <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div> --}}



















                            <div class="col-12 social_media_card">
                                <h5><i class="fas fa-link"></i> Authentication</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Username: <span class="text-danger">*</span></label>
                                            <input
                                            onkeyup="this.value=removeSpaces(this.value);"
                                            class="form-control @if($errors->has('user_name'))  parsley-error @endif" value="{{old('user_name',$influencer->user->user_name)}}" name="user_name" placeholder="Enter Username" type="text">
                                            @error('user_name')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Email: <span class="text-danger">*</span></label>
                                            <input
                                            onkeyup="this.value=removeSpaces(this.value);"
                                             class="form-control  @if($errors->has('email'))  parsley-error @endif" value="{{old('email',$influencer->user->email)}}" name="email" placeholder="Enter Email" type="email">
                                            @error('email')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Password: </label>
                                            <input class="form-control @if($errors->has('password'))  parsley-error @endif"  value="{{old('password')}}" name="password" placeholder="Enter Password" type="password">
                                            @error('password')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Password Confirmation: </label>
                                            <input class="form-control  @if($errors->has('password_confirmation'))  parsley-error @endif" value="" name="password_confirmation" placeholder="Re-enter Password" type="password">
                                            @error('password_confirmation')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Status: <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @if($errors->has('active'))  parsley-error @endif" value="{{old('active', $influencer->active)}}" name="active" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" id="status_infl" data-placeholder="Select One">
                                                <option label="Choose one" disabled selected>
                                                </option>
                                                @foreach ($statInflue as $social_class)
                                                <option value="{{ $social_class['id'] }}"  {{ old('active') == $social_class['id'] || $influencer->active ==  $social_class['id'] ? 'selected' : '' }}> {{ $social_class['name'] }} </option>
                                                 @endforeach
                                            </select>
                                            @error('active')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12 databindOnlyDelivery">
                                        <div class="form-group">
                                            <label class="form-label">Country Visit: <span class="text-danger">*</span></label>
                                            <select
                                                class="form-control  @if ($errors->has('country_visited_outofcountry')) parsley-error @endif"
                                                id="visit_country_id" name="country_visited_outofcountry" data-parsley-class-handler="#slWrapper2"
                                                data-parsley-errors-container="#slErrorContainer2"
                                                data-placeholder="Select<">
                                                @if (empty(old('country_visited_outofcountry')))
                                                    <option disabled selected> Select</option>
                                                @endif
                                                @foreach ($countries_active as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ old('country_visited_outofcountry') == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}</option>
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
                                                    <input
                                                        class="form-control @if ($errors->has('influencer_return_date')) parsley-error @endif"
                                                        value="{{ old('influencer_return_date') }}" name="influencer_return_date"
                                                        placeholder="Enter Date" type="date"
                                                        min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                                                    @error('influencer_return_date')
                                                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-11">
                                                            <li class="parsley-required">{{ $message }}</li>
                                                        </ul>
                                                    @enderror
                                                </div>


                                        </div>
                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Account Expiration Date: <span class="text-danger">*</span></label>
                                            <input class="form-control @if($errors->has('expirations_date'))  parsley-error @endif" value="{{old('expirations_date',$influencer->expirations_date)}}" name="expirations_date" placeholder="Enter Date " type="date" min="{{\Carbon\Carbon::tomorrow()->format('Y-m-d')}}">
                                            @error('expirations_date')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--  Social Status -->

                            {{-- Social Media  --}}
                            <div class="col-12 social_media_card">
                                <h5><i class="fas fa-link"></i> Social Links</h5>
                                <hr>
                                <div class="row">

                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                        <label class="form-label">Facebook: </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color:#fff" class="fab fa-facebook"></i></span>
                                            </div>
                                            <input class="form-control @if($errors->has('facebook_uname'))  parsley-error @endif" value="{{old('facebook_uname',$influencer->facebook_uname) }}" name="facebook_uname" placeholder="Enter Facebook Username" type="text">
                                            @error('facebook_uname')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                        <label class="form-label">Youtube: </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color:#fff" class="fab fa-youtube"></i></span>
                                            </div>
                                            <input class="form-control @if($errors->has('youtube_uname'))  parsley-error @endif" value="{{old('youtube_uname',$influencer->youtube_uname) }}" name="youtube_uname" placeholder="Enter Youtube Username" type="text">
                                            @error('youtube_uname')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                        <label class="form-label">TikTok: </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color:#fff" class="fas fa-icons"></i></span>
                                            </div>
                                            <input class="form-control @if($errors->has('tiktok_uname'))  parsley-error @endif" value="{{old('tiktok_uname',$influencer->tiktok_uname) }}" name="tiktok_uname" placeholder="Enter Tik Tok Username" type="text">
                                            @error('tiktok_uname')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                        <label class="form-label">Snapchat: </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color:#fff" class="fab fa-snapchat"></i></span>
                                            </div>
                                            <input class="form-control @if($errors->has('snapchat_uname'))  parsley-error @endif" value="{{ $influencer->snapchat_uname}}" name="snapchat_uname" placeholder="Enter Snapchat Username" type="text">
                                            @error('snapchat_uname')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                        <label class="form-label">Twitter: </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color:#fff" class="fab fa-twitter"></i></span>
                                            </div>
                                            <input class="form-control @if($errors->has('twitter_uname'))  parsley-error @endif" value="{{ $influencer->twitter_uname}}" name="twitter_uname" placeholder="Enter Twitter Username" type="text">
                                            @error('twitter_uname')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6  col-md-6 col-xs-12">
                                        <label class="form-label">Website: </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1" style="border: none;background: #202020;"><i style="color:#fff" class="fas fa-globe"></i></span>
                                            </div>
                                            <input class="form-control @if($errors->has('website_uname'))  parsley-error @endif" value="{{old('website_uname',  $influencer->website_uname)}}" name="website_uname" placeholder="Enter Website URL" type="url">
                                            @error('website_uname')
                                            <ul class="parsley-errors-list filled text-danger" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                            @enderror
                                        </div>
                                    </div>



                                </div>

                            </div>
                        </div>
                    </div>

                            <div class="col-12"><button style="width: 150px;" class="btn btn-primary pd-x-20 mg-t-10" type="submit"> <i class="far fa-save"></i> Save </button></div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="https://unpkg.com/bootstrap-multiselect@0.9.13/dist/js/bootstrap-multiselect.js"></script>

    {{-- <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script> --}}



{{--    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>--}}
{{--    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>--}}
    <script>

$(document).ready(function(){
    $(".databindOnlyDelivery").hide();
});

$('#status_infl').on('change',function(){
    $(".databindOnlyDelivery").hide();
    console.log(4243);
    var selected = [];
    valuesele = $('#status_infl').find(":selected").val();
    if(valuesele == 7){
        $(".databindOnlyDelivery").show();

     }


    });


$('#category_id').on('change',function(){
     for (var option of document.getElementById('category_id').options){
               option.removeAttribute('disabled');
            }
    var selected = [];
    for (var option of document.getElementById('category_id').options)
    {
      if (option.selected) {selected.push(option.value);}
      console.log(selected)
    }
    if(selected.includes("7") || selected.includes("8")){
        if(selected.includes("9") || selected.includes("10") || selected.includes("11") ||selected.includes("12")){
           for (var option of document.getElementById('category_id').options){
               option.setAttribute('disabled',true);
            }
        }


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


        let code_phone_val = 1;
        let subbrand_phone_val = 1;
        //Toggle
        const MainPhoneCode = $('select[name="main_phone_code"]').val()
        const MainPhone = $('input[name="main_phone"]').val()

        if(!MainPhone && MainPhone!=null ){
            $('#whatsappSection').show();
            subbrand_phone_val = 0;
            code_phone_val=0
            checkToggleWhatsapp();
        }



        $('[name="main_phone_code"]').on('change',function (){

            if($(this).val() != null && $(this).val() !=''){
                code_phone_val = 1;
            }else{
                code_phone_val = 0;
            }
            checkToggleWhatsapp();
        })
        $('[name="main_phone"]').on('input',function (){
            if($(this).val() != null && $(this).val() !=''){
                subbrand_phone_val = 1;
            }else{
                subbrand_phone_val = 0;
            }
            checkToggleWhatsapp();
        })

        function checkToggleWhatsapp(){

            if(code_phone_val == 1 && subbrand_phone_val == 1){
                $('.togBtn').attr('disabled',false)
            }else{
                $('.togBtn').attr('disabled',true)
            }
        }





        @if((!empty(old('whats_number'))&& old('whatsapp_code')==old('main_phone_code')) && (!empty(old('whats_number'))&& old('whats_number')==old('main_phone')))
            $(".togBtn").prop('checked',true);
            $(".togBtn").prop('disabled',false);
            let switchStatus = true
            hideShowWhatsappInput(switchStatus)
        @endif

        $('.main-toggle').on('click', function() {
            if($(this).attr('checked')){
                $(this).attr('checked',false);
            }else{
                $(this).attr('checked',true);
            }
        })

        $(".togBtn").on('click', function() {
            var switchStatus = false;
            if ($(this).is(":checked")){
                switchStatus = !switchStatus;
            }else{
                if(!($("#whatsappSection input").val() != ''))
                    switchStatus = !switchStatus;
            }
            hideShowWhatsappInput(switchStatus)
        });

        function hideShowWhatsappInput(switchStatus){
            if(switchStatus){
                $("#whatsappSection input").val($('input[name="main_phone"]').val());
                $('#whatsappSection select').val($('select[name="main_phone_code"]').val()).trigger('change');
                $("#whatsappSection").fadeOut(500);
            }else{
                $("#whatsappSection input").val('');
                $('#whatsappSection select').val('').trigger('change');
                $("#whatsappSection").fadeIn(500);
            }
        }

        function diableChars(event){
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)  )  {
                event.preventDefault();
                return false;
            }
        }
        function format(item, state) {
            if (!item.id) {
                return item.text;
            }
            var flag= item.element.attributes[1];
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
        function formatState (state) {
            if (!state.id) {
                return state.text;
            }
            var flag= state.element.attributes[1].value;
            var baseUrl = "https://hatscripts.github.io/circle-flags/flags/";
            var $state = $(
                '<span><img class="img-flag" width="22"/> <span></span></span>'
            );
            $state.find("img").attr("src", baseUrl + "/" + flag.toLowerCase() + ".svg");
            return $state;
        };

        $('.phoneInput').on('keypress', function (event) {
            diableChars(event)
        });

        var i =1;
        $("#add_phone_input").click(function(event){
            event.preventDefault()
            let selectData = `
            <div class="input-group-prepend type_phone_div custom-2 col-3">
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
                <select class="input-group-text country_code select2" name="phone_code[]" data-placeholder="Code" style="width:400px;"> <option></option>`
            @foreach($countries_active as $country)
                selectData+= '<option value="{{$country->phonecode}}" data-flag="{{$country->code}}"  > (+){{$country->phonecode}} </option>'
            @endforeach

            $(".allPhones").append('<div class="col-12"><div class="inputs " style="display: flex;width: 60% !important;align-items: center;gap: 25px"><div class="input-group mb-3 align-items-end">' +selectData +
                '</select> </div>  <input  style="margin-top: 0 !important;height: 34px !important;" min="0" class=" form-control phoneInput" onkeypress="diableChars(event)"  placeholder="Enter Phone" type="number" name="phone[]" > </div>' +
                ' <a href="javascript:void(0)" onClick="deleteBranch(this)" class="deleterr btn mb-2" >' +
                '<i class="fas fa-trash-alt"></i></a></div>');
            selectCountry()
            i = i+1;

        });

        function selectCountry(){
            $('.country_code').select2({
                placeholder: "🌍 Global.....",
                allowClear: true,
                templateResult: function(item) {
                    return format(item, false);
                },
                templateSelection:function(state) {
                    return formatState(state, false);
                },
            });
        }
        selectCountry()

        function deleteBranch(e) {
            $(e).parents(".inputs").remove();
            if($(e).children(".input-group-prepend"))
                $(e).children(".input-group-prepend").remove();
            else
                $(e).parents(".inputs").children('.input-group-prepend').first().remove()
        }
        $('#country_id').select2({
            placeholder: "Select ",
            allowClear: true
        });
        $('#nationality').select2({
            placeholder: "Select ",
            allowClear: true
        });
        $('#status').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#recommended_any_camp').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#job').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#account_status').select2({
            placeholder: "Select",
            allowClear: true
        });

        $('#hijab').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#category_id').select2();
        $('#coverage_rating').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#face').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#speak').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#fake').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#share').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#citizen_status').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#rating').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#social_class').select2({
            placeholder: "Select",
            allowClear: true
        });

        $('#match_campaign').select2({
            placeholder: "Select",
            allowClear: true
        });

        $('#min_voucher').select2({
            placeholder: "Select",
            allowClear: true
        });

        $('#social_coverage').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#behavior').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#main_phone_code').trigger('change')
        $('#city_id').select2({
            placeholder: "Select",
            allowClear: true
        });

        $('#chat_response_speed').select2({
            placeholder: "Select",
            allowClear: true
        });

        $('#ethink_category').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#interest').select2({
            placeholder: "Select",
            allowClear: true
        });
        $('#lang').select2({
            placeholder: "Select",
            allowClear: true
        });

        if($("#country_id").val()){
            getStateData($("#country_id").val())
            @if(!empty(old('state_id')))
            getCity("{{old('state_id')}}")
            @endif

        }else if($("#state_id").val()){
            getCity("{{old('state_id')}}")
        }

        $("#country_id").change(function() {
            getStateData($(this).val())
        });
        $("#state_id").change(function() {
            getCity($(this).val())
        });

        function getStateData(val){
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url:  "/dashboard/state/"+val,
                corssDomain: true,
                dataType: "json",
                success: function (data) {
                    $('.state').show()
                    var listItems = ""
                    let edit_state = "{{$influencer->state_id}}"
                    @if(empty(old('state_id')) && !($influencer->state_id))
                        listItems = "<option value=''>Select State ....</option>";
                    @endif
                    $.each(data.data,function(key,value){
                        let oldState = null
                        @if(!empty(old('state_id')) || ($influencer->state_id))
                            oldState = "{{old('state_id')}}"
                        if(oldState == value.id || edit_state == value.id)
                                listItems += "<option value='" + value.id + "' selected >" + value.name + "</option>";
                            else
                                listItems+= "<option value='" + value.id + "'>" + value.name + "</option>";
                        @else
                            listItems += "<option value='" + value.id + "' >" + value.name + "</option>";
                        @endif
                    });
                    $("#state_id").html(listItems);
                },

                error : function(data) {

                }
            });
        }

        function getCity(val){
            $.ajax({
                type: "GET",
                contentType: "application/json; charset=utf-8",
                url:  "/dashboard/city/"+val,
                corssDomain: true,
                dataType: "json",
                success: function (data) {
                    console.log('ddddd',data.data)

                    $('.city').show()
                    var listItems = "";
                    @if(empty(old('city_id')))
                        listItems = "<option value=''>Select City ....</option>";
                    @endif
                    $.each(data.data,function(key,value){
                        let oldCity = null
                        @if(!empty(old('city_id')))
                            oldCity = "{{old('city_id')}}"
                        if(oldCity == value.id )
                        {
                            listItems += "<option value='" + key + "' selected >" + value + "</option>";
                        }
                        else{
                            listItems+= "<option value='" + key + "'>" + value + "</option>";
                        }
                        @else
                            listItems+= "<option value='" + key + "'>" + value + "</option>";
                        @endif
                    });
                    $("#city_id").html(listItems);
                },

                error : function(data) {

                }
            });
        }
        function socialType(type){
            $("#children_num").val('')
            $("#childrenContainer .row").html('')
            if(type != 1){
                $("#children_num").parent().slideDown(500)
            }else{
                $("#children_num").parent().slideUp(500)
            }
        }

        function childrenContainer(numberOfChildren){
            for(let children =0 ; children < numberOfChildren; children++){
                $("#childrenContainer").append(`
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="child_name">Children Name </label>
                                    <input type="text" name="children[${children}][name]" placeholder="Children Name " class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="DOB">Children Date Of Birth</label>
                                    <input type="date" name="children[${children}][DOB]" class="form-control"  max="{{\Carbon\Carbon::today()->format('Y-m-d')}}" >
                                </div>
                                <div class="col-md-4">
                                    <label for="gender">Children Gender</label>
                                    <select class="input-group-text childrenGender select2" placeholder="Children Type" name="children[${children}][gender]">
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

        $("#children_num").off().on('change', function (event) {
            $("#childrenContainer").html('')
            event.preventDefault()
            let numberOfChildren = event.target.value;
            childrenContainer(numberOfChildren)
            $(".childrenGender").select2({
                placeholder: "Select Children Gender ....",
                allowClear: true
            });
        })
        $(".childrenGender").select2({
            placeholder: "Select Children Gender ....",
            allowClear: true
        });

        // $('#main_phone_code').select2({
        //     placeholder: "Code....",
        //     allowClear: true
        // });


    </script>
@stop

