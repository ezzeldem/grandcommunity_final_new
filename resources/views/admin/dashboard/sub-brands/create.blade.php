@extends('admin.dashboard.layouts.app')
@section('title','Create Brand')
@section('style')
    <!--- Internal Sweet-Alert css-->
    <!-- select 2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css"/>
@stop

@section('page-header')
    @php
        $routes =  [
            ['route'=>route('dashboard.sub-brands.index'),'name'=>'Brands']
        ];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb',$routes)
@stop
@section('content')
    <div class="row row-sm ">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title')</h4>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => ['dashboard.sub-brands.store'],'method'=>'post','data-parsley-validate'=>'','id'=>'createUpdate','files'=>true,'class'=>'create_page'] ) !!}
                    @include('admin.dashboard.sub-brands.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @include('admin.dashboard.sub-brands.branchModal')
    </div>
@stop

@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
{{--    <script src="{{asset('assets/js/form-validation.js')}}"></script>}">--}}
    <script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <!-- <script>
        let branches = [];
        $('#mydeletebtn').hide();
        $('#table_branches').hide();
    </script> -->
    <!-- <script src="{{asset('js/branches_crud.js')}}"></script> -->
    <!-- <script>
        $('#sub_brand_form').submit(function (){
            $('#branches').val(localStorage.getItem('branches'))
        })
        $(`#country_id,#brand_id,
            #preferred_gender,#status,
            #branch_country_id,#branch_status`).select2({
            placeholder: "Select",
            allowClear: true,
            maximumSelectionLength: 4,
        });
    </script> -->
@stop

