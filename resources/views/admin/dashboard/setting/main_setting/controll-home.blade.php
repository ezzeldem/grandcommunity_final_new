@extends('admin.dashboard.layouts.app')

@section('title','Settings')

@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')

    <style>
        .btn-group, .btn-group-vertical{
            display: flex !important;
            margin-bottom: 10px !important;
            width: fit-content !important;
        }
        .dropdown-menu span{
            cursor: pointer;
        }
        input[type='file']{
            line-height: 1 !important;
        }

    </style>
@endsection

@section('page-header')
    @include('admin.dashboard.layouts.includes.index_statistics',['title'=>'Home Control'])
@stop

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    @include('admin.dashboard.setting.tabs')
                </div>

                <div class="card-body">
                    <form class="create_page" action="{{route('dashboard.update_setting')}}" method="post" enctype="multipart/form-data" data-parsley-validate="" novalidate="">
                        @csrf
                        <div class="row row-sm">

                            <input class="form-control" value="{{isset($setting->id) ? $setting->id : ''}}" name="id" type="hidden" >
<!--
                         <div class="col-lg-4 col-md-6 col-xs-12">
                                <label class="form-label">Slogan_En: <span class="tx-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i style="color: #0082fd;" class="fas fa-heading"></i></span>
                                    </div>
                                    <input class="form-control @if($errors->has('slogan'))  parsley-error @endif" value="{{isset($setting->slogan) ? $setting->slogan : ''}}" name="slogan" placeholder="Enter Slogan En" type="text">
                                    @error('slogan')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div> -->

                            <div class="col-lg-4 col-md-6 col-xs-12">
                                <label class="form-label">Social Media: <span class="tx-danger">*</span></label>
                                <div class="input-group mb-3">
                                <select class="form-select" id="social_id" name="social_id" aria-label="Default select example">
                                     @foreach($socials as $row)
                                     <option value="{{$row->id}}"  @if($setting->social_id == $row->id) selected @endif>{{$row->name}}</option>
                                     @endforeach
                                 </select>
                                    @error('social_id')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-6 col-xs-12">
                                <label class="form-label">Country: <span class="tx-danger">*</span></label>
                                <div class="input-group mb-3">
                                <select class="form-select" id="country_id" name="country_id[]" aria-label="Default select example"multiple>

                                     @foreach($countries as $row)
                                     <option value="{{$row->id}}" @if(isset($setting->country_id)&&in_array($row->id,$setting->country_id)) selected @endif>{{$row->name}}</option>
                                     @endforeach
                                    </select>
                                    @error('country_id')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-xs-12">
                                <label class="form-label">Status: <span class="tx-danger">*</span></label>
                                <div class="input-group mb-3">
                                <select class="form-select" id="status_id" name="status_id" aria-label="Default select example">
                                     @foreach($status as $row)

                                     <option value="{{$row->id}}" @if($setting->status_id == $row->id) selected @endif>{{$row->name}}</option>
                                     @endforeach
                                 </select>
                                    @error('status_id')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-xs-12">
                                <label class="form-label">Followers: <span class="tx-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i style="color: #0082fd;" class="fab fa-app-store"></i></span>
                                    </div>
                                    <input class="form-control @if($errors->has('followers'))  parsley-error @endif" value="{{isset($setting->followers) ? $setting->followers : ''}}" name="followers" placeholder="Enter App Followers Count" type="text">
                                    @error('followers')
                                    <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required">{{$message}}</li></ul>
                                    @enderror
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
<script>
    $(document).ready(function (){


    $("#social_id,#country_id,#status_id").select2({
            placeholder: "Select",
            allowClear: true,
            maximumSelectionLength: 4,
        })

    });
</script>


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
