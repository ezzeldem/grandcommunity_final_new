@extends('admin.dashboard.layouts.app')
@section('title','Edit Influencer Profile')
@section('style')
 @include('admin.dashboard.layouts.includes.general.styles.influencer_create')
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
                    <form class="create_page" action="{{route('dashboard.influences.update',$influencer->id)}}"  method="post" data-parsley-validate="" novalidate="" enctype="multipart/form-data"  id="createUpdate">
                        @method('put')
                        @csrf
						@include('admin.dashboard.influencers.form',$influencer)
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/curd.js') }}"></script>
    <script>
        $(".select2").select2();
    </script>
    <script>
        $('.select2').select2({
            placeholder: "Select",
            allowClear: true
        });

        $(".databindOnlyDelivery").hide();
    </script>
@include('admin.dashboard.layouts.includes.general.scripts.phone_calling')
@include('admin.dashboard.layouts.includes.general.scripts.influencer_create')
@stop
