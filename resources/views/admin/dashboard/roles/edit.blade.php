@extends('admin.dashboard.layouts.app')
@section('title','Edit Role')
@section('style')

@stop

@section('page-header')
    @php
        $routes =  [
            ['route'=>route('dashboard.roles.index'),'name'=>'Roles']
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
                        {{--                        <i class="mdi mdi-dots-horizontal text-gray"></i>--}}
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::model($role,['route' => ['dashboard.roles.update',$role->id],'method'=>'put','data-parsley-validate'=>'','novalidate'=>'','files'=>true]) !!}
                    @include('admin.dashboard.roles.form',$role)
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    @if(session()->has('err'))
       <div class="alert alert-success">
        {{ session()->get('err') }}
    </div>
    @endif
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>

    <script>
        $(`#type`).select2({
            placeholder: "Select",
            allowClear: true,
            maximumSelectionLength: 4,
        });
    </script>
@stop

