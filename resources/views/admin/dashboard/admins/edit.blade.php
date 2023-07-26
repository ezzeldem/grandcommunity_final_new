@extends('admin.dashboard.layouts.app')
@section('title','Edit Admin')
@section('style')

@stop

@section('page-header')
    @php
        $routes =  [
            ['route'=>route('dashboard.admins.index'),'name'=>'admins']
        ];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb',$routes)
@stop
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mg-b-0">@yield('title')</h4>
                    </div>
                </div>

                <div class="card-body">

                    {!! Form::model($admin,['route' => ['dashboard.admins.update',$admin->id], 'class'=>'create_page', 'method'=>'put','data-parsley-validate'=>'','novalidate'=>'','files'=>true]) !!}
                    @include('admin.dashboard.admins.form',$admin)
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script>
        $(`#role_id,#active`).select2({
            placeholder: "Select",
            allowClear: true,
            maximumSelectionLength: 4,
        });
    </script>
@stop

