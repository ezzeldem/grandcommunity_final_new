@extends('admin.dashboard.layouts.app')
@section('title','Create An Account')
@section('style')

@stop


@section('content')
    @php
        $routes =  [
            ['route'=>route('dashboard.community.index'),'name'=>'Community']
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
                    {!! Form::open(['route' => 'dashboard.community.store','method'=>'post','data-parsley-validate'=>'','novalidate'=>'','files'=>true, 'class'=>'create_page']) !!}
                    @include('admin.dashboard.communities.form')
                    {!! Form::close() !!}
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

