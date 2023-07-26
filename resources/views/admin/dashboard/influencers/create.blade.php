@extends('admin.dashboard.layouts.app')
@section('title', 'Create Influencer Account')
@section('style')
@include('admin.dashboard.layouts.includes.general.styles.influencer_create')
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
          <a href="{{ route('dashboard.influences.index') }}" class="btn mt-2 mb-2 pb-2" style="color: #fff;"><i
              class="fas fa-long-arrow-alt-left"></i> Back </a>
        </div>
      </div>

      <div class="card-body">
        <form class="create_page" action="{{ route('dashboard.influences.store') }}" method="post"
          data-parsley-validate="" novalidate="" enctype="multipart/form-data" id="createUpdate">
          @csrf
          @include('admin.dashboard.influencers.form')
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
