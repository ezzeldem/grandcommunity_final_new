@extends('admin.dashboard.layouts.app')
@section('title','Create A Role')
@section('style')
{{--<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">--}}
@stop


@section('content')
    @php
        $routes =  [
            ['route'=>route('dashboard.roles.index'),'name'=>'Roles']
        ];
    @endphp
    @include('admin.dashboard.layouts.includes.breadcrumb',$routes)
    <div class="row gutters">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">@yield('title')</h4>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'dashboard.roles.store','method'=>'post','data-parsley-validate'=>'','novalidate'=>'','files'=>true]) !!}
                    @include('admin.dashboard.roles.form')
                    {!! Form::close() !!}
                </div>
            </div>

    </div>
@stop

@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>

    @if(session()->has('err'))
    <script>
        Swal.fire(
            'Failed!',
            `{{ session()->get('err') }}`,
            'danger'
        )
    </script>
    @endif

    <script>
        $(`#type`).select2({
            placeholder: "Select",
            allowClear: true,
            maximumSelectionLength: 4,
        });
    </script>
@stop

