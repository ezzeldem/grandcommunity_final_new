@extends('admin.dashboard.layouts.app')
@section('title','Edit Task')
@section('style')

@stop

@section('page-header')
    @php
        $routes =  [
            ['route'=>route('dashboard.tasks.index'),'name'=>'Tasks']
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
                    {!! Form::model($task,['route' => ['dashboard.tasks.update',$task['id']],'class'=>'create_page', 'method'=>'put','data-parsley-validate'=>'','novalidate'=>'','files'=>true]) !!}
                        @include('admin.dashboard.tasks.form', $task)
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script>
        $(document).ready(function(){
            $('#assigned_to').select2({
                placeholder: 'Select an individual or department',
                ajax: {
                    url: '{{ route("dashboard.tasks.getAssignedStatus") }}',
                    type: "get",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                        '_token': '{{csrf_token()}}',
                        'assign_status': $('input[name=assign_status]:checked', '#Task_form').val(),
                        search: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results:  $.map(response['data'], function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        

        });

    
        
    </script>
@stop

