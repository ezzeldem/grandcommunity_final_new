@extends('admin.dashboard.layouts.app')
@section('title','Create FAQ')
@section('style')
    <!--- Internal Sweet-Alert css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>
        .panel-heading.note-toolbar{
            display: flex;
        }
        .note-btn.dropdown-toggle {
            background-color: #ecf0fa!important;
            color: #0b1426;
        }
    </style>
@stop

@section('page-header')
    @php
        $routes =  [
            ['route'=>route('dashboard.faqs.index'),'name'=>'Faqs']
        ];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb',$routes)
@stop
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    {!! Form::open(['route' => ['dashboard.faqs.store'],'method'=>'post','data-parsley-validate'=>'','id'=>'sub_brand_form','class'=>'create_page','files'=>true]) !!}
                    @include('admin.dashboard.faqs.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>

    <script  type="text/javascript" >
        $(document).ready(function() {

            $('.summernote').summernote({
                height:400
            });

            $(`#position,#status`).select2({
                placeholder: "Select",
                allowClear: true,
                maximumSelectionLength: 4,
            });
        });

    </script>
@stop

