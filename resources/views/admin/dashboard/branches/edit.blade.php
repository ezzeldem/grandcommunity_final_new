@extends('admin.dashboard.layouts.app')
@section('title','edit Branches')
@section('style')
    <!--- Internal Sweet-Alert css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css"/>
@stop

@section('page-header')
    @php
        $routes =  [
            ['route'=>route('dashboard.branches.index'),'name'=>'branches']
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
                    {!! Form::model($branch,['route' => ['dashboard.branches.update',$branch->id],'class'=>'create_page','method'=>'put','data-parsley-validate'=>'','id'=>'sub_brand_form','files'=>true]) !!}
                    @include('admin.dashboard.branches.form',$branch)
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <script>
        let branches = $('#table_branches').data('branches');
    </script>
    <script src="{{asset('js/branches_crud.js')}}"></script>
    <script>
        $('#sub_brand_form').submit(function (){
            $('#branches').val(localStorage.getItem('branches'))
        })
        $(`#country_id,#subbrand_id,#status`).select2({
            placeholder: "Select ....",
            allowClear: true,
            maximumSelectionLength: 4,
        });
    </script>
@stop

