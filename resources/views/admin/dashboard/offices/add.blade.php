@extends('admin.dashboard.layouts.app')
@section('title','Add Office')
@section('style')
<!-- new -->
<style>
.field-icon {
  float: right;
  margin-right: 16px;
  margin-top: -44px;
  position: relative;
  color:black;
  z-index: 2;
  cursor: pointer;
}

.container{
  padding-top:50px;
  margin: auto;
}
</style>
@stop


@section('content')
    @php
        $routes =  [
            ['route'=>route('dashboard.offices.index'),'name'=>'Offices']
        ];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb',$routes)
    <div class="row gutters">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mg-b-0">@yield('title')</h4>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'dashboard.offices.store','method'=>'post','data-parsley-validate'=>'','novalidate'=>'','files'=>true, 'class'=>'create_page']) !!}
                    @include('admin.dashboard.offices.form')
                    {!! Form::close() !!}
                </div>
            </div>

    </div>
@stop

@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script>
        $(`#country`).select2({
            placeholder: "Select",
            allowClear: true,
            maximumSelectionLength: 4,
        });
    </script>
@stop

