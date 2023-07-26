@extends('admin.dashboard.layouts.app')
@section('title','Edit Company')
@section('style')
<style>
.select2-results__options {
  background: var(--main-bg-color) !important;
}

.switch_parent input[type='checkbox'] {
  display: block;
  opacity: 0;
}

.switch_parent .switch {
  position: relative;
  width: 50px;
  height: 25px;
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
  /* background: #009900; */
}

.switch_parent input[type='checkbox']:checked+.switch:after {
  left: auto;
  right: 2px;
}

/*.select2-container--default .select2-selection--single, .select2-container--default{*/
/*    width: 100px !important;*/
/*}*/
</style>
@stop

@section('page-header')
@php
$routes = [
['route'=>route('dashboard.brands.index'),'name'=>'Companies']
];
@endphp
@include('admin.dashboard.layouts.includes.breadcrumb',$routes)
@stop
@section('content')

<div class="row row-sm">
  <div class="col-xl-12">
    <div class="card mg-b-20">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
          <h4 class="card-title mg-b-0">@yield('title')</h4>
        </div>
      </div>


      <div class="card-body">
        <form class="create_page" action="{{route('dashboard.brands.update',$brand->id)}}" method="post"
          enctype="multipart/form-data" data-parsley-validate="" novalidate="" id="createUpdate">
          @csrf
          @method('PUT')
          <input class="form-control" value="{{$brand->id}}" name="id" type="hidden">
          <input class="form-control" value="{{$brand->user_id}}" name="user_id" type="hidden">
          @include('admin.dashboard.brands.form',$brand)
        </form>
      </div>
    </div>
  </div>
</div>


@stop

@section('js')
@include('admin.dashboard.layouts.includes.general.scripts.phone_calling')
@include('admin.dashboard.layouts.includes.general.scripts.brand_create')
@stop