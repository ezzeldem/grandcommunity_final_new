@extends('admin.dashboard.layouts.app')
@section('title','Create An Account')
@section('style')
<style>
.field-icon {
  float: right;
  margin-right: 16px;
  margin-top: -44px;
  position: relative;
  color:black;
  z-index: 2;
  cursor: pointer;
}

.container{
  padding-top:50px;
  margin: auto;
}
</style>
@stop


@section('content')
    @php
        $routes =  [
            ['route'=>route('dashboard.operations.index'),'name'=>'Operations']
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
                    {!! Form::open(['route' => 'dashboard.operations.store','method'=>'post','data-parsley-validate'=>'','novalidate'=>'','files'=>true, 'class'=>'create_page']) !!}
                    @include('admin.dashboard.operations.form')
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


 function togglepassword() {
  var x = document.getElementById("pwd");
  if (x.type === "password") {
    x.type = "text";
  } else {
    
    x.type = "password";
  }
}
    </script>

<script>

//ShowPassword
$('.fa-eye').on('click', function(e) {
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

