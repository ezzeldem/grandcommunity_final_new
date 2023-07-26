@extends('admin.dashboard.layouts.app')
@section('title','Create An Account')
@section('style')
    <!--- Internal Sweet-Alert css-->
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <style>


.container{
  padding-top:50px;
  margin: auto;
}
</style>
@stop

@section('page-header')
    @php
        $routes =  [
            ['route'=>route('dashboard.sales.index'),'name'=>'Sales']
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
                {!! Form::open(['route' => 'dashboard.sales.store','method'=>'post','data-parsley-validate'=>'','novalidate'=>'','files'=>true, 'class'=>'create_page']) !!}
                @include('admin.dashboard.sales.form')
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
    <script>
        //ShowPassword
        $('.fa-eye').on('click', function(e) {
            console.log("jhhgikhij");
            input = $(this).parent().children('.form-control');
            inputType = input.attr('type');
            if (inputType == "password") {
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });
    </script>
@stop

