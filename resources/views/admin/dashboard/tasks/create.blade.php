@extends('admin.dashboard.layouts.app')
@section('title','Create Task')
@section('style')

@stop


@section('content')
    @php
        $routes =  [
            ['route'=>route('dashboard.tasks.index'),'name'=>'Tasks']
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
                    {!!  Form::open(['route' => 'dashboard.store.task', 'method' => 'POST', 'data-parsley-validate'=>'','novalidate'=>'','files'=>true, 'class'=>'create_page', 'id' => 'Task_form']) !!}
                    @include('admin.dashboard.tasks.form')
                    {!! Form::close() !!}
                </div>
            </div>

    </div>
@stop

@push('js')
    <script>
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
    </script>
@endpush

