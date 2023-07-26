@extends('admin.dashboard.layouts.app')
@section('title','Edit Account')
@section('page-header')
    @php
        $routes =  [ ['route'=>route('dashboard.sales.index'),'name'=>'Sales'] ];
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
                    {!! Form::model($sale,['route' => ['dashboard.sales.update',$sale->id],'method'=>'put','class'=>'create_page','data-parsley-validate'=>'','novalidate'=>'','files'=>true]) !!}
                    @include('admin.dashboard.sales.form',$sale)
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script>
        $(`#active,#role_id`).select2({
            placeholder: "Select",
            allowClear: true,
            maximumSelectionLength: 4,
        });
    </script>
@stop

