@extends('admin.dashboard.layouts.app')

@section('title', 'Home')

@section('style')
    @include('admin.dashboard.layouts.includes.general.styles.index')
    <style>
        .card_statics_div {
            height: 200px !important;
            position: relative;
            overflow: hidden;
            width: auto;
            height: auto;
        }

        .info-stats3 {
            min-height: 72px !important;
        }

        .card_details .slimScrollDiv {
            height: 500px !important;
        }

        .card_details .customScroll5 {
            height: 500px !important;
        }
    </style>
@stop
@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="t-header">Welcome {{auth()->user()->name}}</h4>
                    </div>
               
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
    
@endsection
