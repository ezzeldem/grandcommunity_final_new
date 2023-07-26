@extends('admin.dashboard.layouts.app')

@section('title','Settings')

@section('style')
@include('admin.dashboard.layouts.includes.general.styles.index')

<style>
    .btn-group,
    .btn-group-vertical {
        display: flex !important;
        margin-bottom: 10px !important;
        width: fit-content !important;
    }

    .dropdown-menu span {
        cursor: pointer;
    }

    input[type='file'] {
        line-height: 1 !important;
    }


    .list-social-scrap {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        flex-direction: row;
        background-color: #0F0F0F;
        padding: 10px 0px 0 0;
    }

    .list-social-scrap .nav_main li {
        height: 40px;
        padding: 0 20px 0 0;
    }

    .list-social-scrap.nav_main li .nav-link {
        background-color: transparent !important;
        margin-bottom: 0 !important;
    }

    .list-social-scrap.nav-pills .nav-link.active {
        background-color: transparent !important;
        border-bottom: 1px solid var(--border-color);
    }
    #basic-addon1{
        background: #202020;
        border: none;
        height: auto !important;
    }
</style>
@endsection

@section('page-header')
@include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Settings'])
@stop

@section('content')
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                @include('admin.dashboard.setting.tabs')
            </div>

            <div class="card-body">
                <form class="create_page create_form" action="{{route('dashboard.setting.store')}}" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                    @csrf
                    <div class="row row-sm">

                        <input class="form-control" value="{{isset($setting->id) ? $setting->id : ''}}" name="id" type="hidden">

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Company Name (En): <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-building"></i></span>
                                </div>
                                <input class="form-control  @if($errors->has('company_name'))  parsley-error @endif " value="{{isset($setting->company_name) ? $setting->company_name : ''}}" name="company_name" placeholder="Enter Company Name" type="text">
                                @error('company_name')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Company Name (Ar): <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-building"></i></span>
                                </div>
                                <input class="form-control  @if($errors->has('company_name_ar'))  parsley-error @endif " value="{{isset($setting->company_name_ar) ? $setting->company_name_ar : ''}}" name="company_name_ar" placeholder="Enter Company Name Ar" type="text">
                                @error('company_name_ar')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Company Logo: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-images"></i></span>
                                </div>
                                <input class="form-control @if($errors->has('image'))  parsley-error @endif" value="{{old('image')}}" name="image" type="file">
                                @error('image')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Home Image: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="c" class="fas fa-images"></i></span>
                                </div> <input class="form-control @if($errors->has('homepage_pic'))  parsley-error @endif" value="{{old('homepage_pic')}}" name="homepage_pic" type="file">
                                @error('homepage_pic')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Influencers Count: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fab fa-bandcamp"></i></span>
                                </div>
                                <input class="form-control  @if($errors->has('influencers_count'))  parsley-error @endif " value="{{isset($setting->influencers_count) ? $setting->influencers_count : ''}}" name="influencers_count" placeholder="Enter Influencers Count" type="number">
                                @error('influencers_count')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Campaigns Count: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-mortar-pestle"></i></span>
                                </div>
                                <input class="form-control  @if($errors->has('campaign_count'))  parsley-error @endif " value="{{isset($setting->campaign_count) ? $setting->campaign_count : ''}}" name="campaign_count" placeholder="Enter Campaigns Count" type="number">
                                @error('campaign_count')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Countries Count: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-globe-africa"></i></span>
                                </div>
                                <input class="form-control  @if($errors->has('country_count'))  parsley-error @endif " value="{{isset($setting->country_count) ? $setting->country_count : ''}}" name="country_count" placeholder="Enter Countries Count" type="number">
                                @error('country_count')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Account Verification Limit: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1" style="font-weight: bold;">Days</span>
                                </div>
                                <input class="form-control  @if($errors->has('account_verification_limit'))  parsley-error @endif " value="{{isset($setting->account_verification_limit) ? $setting->account_verification_limit : ''}}" name="account_verification_limit" placeholder="Enter Limit" type="number">
                                @error('account_verification_limit')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Google Play: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fab fa-google-play"></i></span>
                                </div>
                                <input class="form-control @if($errors->has('google_play'))  parsley-error @endif" value="{{isset($setting->google_play) ? $setting->google_play : ''}}" name="google_play" placeholder="Enter Goggle Play" type="text">
                                @error('google_play')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">App Store: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fab fa-app-store"></i></span>
                                </div>
                                <input class="form-control @if($errors->has('app_store'))  parsley-error @endif" value="{{isset($setting->app_store) ? $setting->app_store : ''}}" name="app_store" placeholder="Enter App Store" type="text">
                                @error('app_store')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Phone: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fa fa-phone"></i></span>
                                </div>
                                <input class="form-control @if($errors->has('phone'))  parsley-error @endif" value="{{isset($setting->phone) ? $setting->phone : ''}}" name="phone" placeholder="Enter Phone" type="number">
                                @error('phone')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Email: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fa fa-envelope"></i></span>
                                </div>
                                <input class="form-control @if($errors->has('email'))  parsley-error @endif" value="{{isset($setting->email) ? $setting->email : ''}}" name="email" placeholder="Enter Email" type="text">
                                @error('email')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Loaction: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-thumbtack"></i></span>
                                </div>
                                <input class="form-control @if($errors->has('location'))  parsley-error @endif" value="{{isset($setting->location) ? $setting->location : ''}}" name="location" placeholder="Enter Location" type="text">
                                @error('location')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Slogan (En): <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-heading"></i></span>
                                </div>
                                <input class="form-control @if($errors->has('slogan'))  parsley-error @endif" value="{{isset($setting->slogan) ? $setting->slogan : ''}}" name="slogan" placeholder="Enter Slogan En" type="text">
                                @error('slogan')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Slogan (Ar): <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-heading"></i></span>
                                </div>
                                <input class="form-control @if($errors->has('slogan'))  parsley-error @endif" value="{{isset($setting->slogan_ar) ? $setting->slogan_ar : ''}}" name="slogan_ar" placeholder="Enter Slogan Ar" type="text">
                                @error('slogan')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Send Mail: <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-check-double"></i></span>
                                </div>
                                <input style="width: 26px;height: 18px;align-self: center;accent-color: #a27929; cursor:pointer;" class="form-control send_mail @if($errors->has('send_mail'))  parsley-error @endif" {{($setting->send_mail==1)?'checked':''}} name="send_mail" type="checkbox">
                                @error('send_mail')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Description (Ar): <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-audio-description"></i></span>
                                </div>
                                <textarea style="height: 75px;resize: none;" class="form-control @if($errors->has('desc_ar'))  parsley-error @endif" name="desc_ar" placeholder="Enter Description Ar">{{isset($setting->desc_ar) ? $setting->desc_ar : ''}}</textarea>
                                @error('desc_ar')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-xs-12">
                            <label class="form-label">Description (En): <span class="tx-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-audio-description"></i></span>
                                </div>
                                <textarea style="height: 75px;resize: none;" class="form-control @if($errors->has('desc_en'))  parsley-error @endif" name="desc_en" placeholder="Enter Description En">{{isset($setting->desc_en) ? $setting->desc_en : ''}}</textarea>
                                @error('desc_en')
                                <ul class="parsley-errors-list filled" id="parsley-id-11">
                                    <li class="parsley-required">{{$message}}</li>
                                </ul>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 social_media_card">
                            <h5><i class="fas fa-link"></i> Social Media</h5>
                            <hr>
                            <div class="row">

                                <div class="col-lg-4 col-md-6 col-xs-12">
                                    <label class="form-label">Facebook: <span class="tx-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="" class="fab fa-facebook"></i></span>
                                        </div>
                                        <input class="form-control @if($errors->has('facebook'))  parsley-error @endif" value="{{isset($setting->facebook) ? $setting->facebook : ''}}" name="facebook" placeholder="Enter Facebook username" type="text">
                                        @error('facebook')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                                            <li class="parsley-required">{{$message}}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-xs-12">
                                    <label class="form-label">Twitter: <span class="tx-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="" class="fab fa-twitter"></i></span>
                                        </div>
                                        <input class="form-control @if($errors->has('twitter'))  parsley-error @endif" value="{{isset($setting->twitter) ? $setting->twitter : ''}}" name="twitter" placeholder="Enter Twitter username" type="text">
                                        @error('twitter')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                                            <li class="parsley-required">{{$message}}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-xs-12">
                                    <label class="form-label">Instagram: <span class="tx-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="" class="fab fa-instagram"></i></span>
                                        </div>
                                        <input class="form-control @if($errors->has('instagram'))  parsley-error @endif" value="{{isset($setting->instagram) ? $setting->instagram : ''}}" name="instagram" placeholder="Enter Instagram username" type="text">
                                        @error('instagram')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                                            <li class="parsley-required">{{$message}}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-xs-12">
                                    <label class="form-label">Snapchat: <span class="tx-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="" class="fab fa-snapchat"></i></span>
                                        </div>
                                        <input class="form-control @if($errors->has('snapchat'))  parsley-error @endif" value="{{isset($setting->snapchat) ? $setting->snapchat : ''}}" name="snapchat" placeholder="Enter Snapchat username" type="text">
                                        @error('snapchat')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                                            <li class="parsley-required">{{$message}}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-xs-12">
                                    <label class="form-label">LinkedIn: <span class="tx-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="" class="fab fa-linkedin-in"></i></span>
                                        </div>
                                        <input class="form-control @if($errors->has('linkedin'))  parsley-error @endif" value="{{isset($setting->linkedin) ? $setting->linkedin : ''}}" name="linkedin" placeholder="Enter Linked In username" type="text">
                                        @error('linkedin')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                                            <li class="parsley-required">{{$message}}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-xs-12">
                                    <label class="form-label">Pinterset: <span class="tx-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="" class="fab fa-pinterest"></i></span>
                                        </div>
                                        <input class="form-control @if($errors->has('pinterset'))  parsley-error @endif" value="{{isset($setting->pinterset) ? $setting->pinterset : ''}}" name="pinterset" placeholder="Enter Pinterset username" type="text">
                                        @error('pinterset')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                                            <li class="parsley-required">{{$message}}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-xs-12">
                                    <label class="form-label">Youtube: <span class="tx-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="" class="fab fa-youtube"></i></span>
                                        </div>
                                        <input class="form-control @if($errors->has('youtube'))  parsley-error @endif" value="{{isset($setting->youtube) ? $setting->youtube : ''}}" name="youtube" placeholder="Enter Youtube username" type="text">
                                        @error('youtube')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                                            <li class="parsley-required">{{$message}}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-xs-12">
                                    <label class="form-label">Banner: <span class="tx-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i style="" class="fas fa-images"></i></span>
                                        </div>
                                        <input class="form-control @if($errors->has('banner'))  parsley-error @endif" value="{{old('banner')}}" name="banner" type="file">
                                        @error('banner')
                                        <ul class="parsley-errors-list filled" id="parsley-id-11">
                                            <li class="parsley-required">{{$message}}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12 text-right"><button style="width: 150px;" class="btn btn-primary pd-x-20 mg-t-10" type="submit"> <i class="far fa-save"></i> Save </button></div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
@include('admin.dashboard.layouts.includes.general.scripts.index')

alert(1);
@if(session()->has('successful_message'))
<script>
    swal("Good job!", "{{session()->get('successful_message')}}", "success");
</script>
@elseif(session()->has('error_message'))
<script>
    swal("Good job!", "{{session()->get('error_message')}}", "error");
</script>
@endif


@endsection
