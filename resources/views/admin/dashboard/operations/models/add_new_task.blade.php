<div class="modal fade effect-newspaper show" id="OperationTasks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Add New Task
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{--  --- Form --- Inputs ---  --}}
                {!!  Form::open(['url' => '', 'method' => 'POST', 'files' => true, 'id' => 'AddTaskForm']) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="form-label">Description: <span class="text-danger">*</span></label>
                        {!! Form::textarea('description', null, ['class' =>'form-control '.($errors->has('description') ? 'parsley-error' : null),'placeholder'=> 'Description','id'=>'description' ]) !!}
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Start Date: <span class="text-danger">*</span></label>
                            {!! Form::date('start_date', null, ['class' =>'form-control datepicker'.($errors->has('start_date') ? 'parsley-error' : null),'placeholder'=> 'Description','id'=>'start_date' ]) !!}
                        </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="form-label">End Date: <span class="text-danger">*</span></label>
                        {!! Form::date('end_date', null, ['class' =>'form-control datepicker'.($errors->has('end_date') ? 'parsley-error' : null),'placeholder'=> 'Description','id'=>'end_date' ]) !!}
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="form-label">Priority: <span class="text-danger">*</span></label>
                        {!! Form::select("priority",['0' => 'Top', '1' => 'High', '2' => 'Low'],null,['class' =>'form-control '.($errors->has('priority') ? 'parsley-error' : null),
                                        'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'priority','placeholder'=>'-- Select Priority --'])!!}
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="form-label">Status: <span class="text-danger">*</span></label>
                        {!! Form::select("status",['0' => 'Resolved', '1' => 'Unresolved'],null,['class' =>'form-control '.($errors->has('status') ? 'parsley-error' : null),
                                        'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'status','placeholder'=>'-- Select Status --'])!!}
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <div class="">
                            <label class="form-label offset-1">Assign Status: <span class="text-danger">*</span></label>
                            <div class="">
                                {!! Form::radio('assign_status', 0, true,['class' => 'col-md-1 mb-1 assign_status', 'id' => 'individuals']) !!}
                                {!! Form::label('individuals', 'Individuals', ['class' => 'form-label col-2']) !!}
                            </div>
                            <div class="">
                                {!! Form::radio('assign_status', 1, true,['class' => 'col-md-1 mb-1 assign_status', 'id' => 'departments']) !!}
                                {!! Form::label('departments', 'Departments', ['class' => 'form-label col-2']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12" >
                    <div class="form-group">
                        <label class="form-label">Assign To: <span class="text-danger">*</span></label>
                        {!! Form::select("assigned_to",[],null,['class' =>'form-control select2'.($errors->has('assigned_to') ? 'parsley-error' : null),
                                         'multiple'=>'multiple', 'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'assigned_to','placeholder'=>'-- Assign to an individual or a department --'])!!}
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        @isset($operation)
                        <a href="{{url($operation->file)}}" download>
                            <label class="form-label">Click Here To Download</label>
                        </a>
                        @endisset
                        <label class="form-label">File: <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            {!! Form::file('file',['class'=>'custom-file-input '.($errors->has('file') ? 'parsley-error' : null),'id'=>'file']) !!}
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit('Save', [ "id" => "submit_addInflueToGroup", "class" => "btn" ]) !!}
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
            $('#assigned_to').select2({
                placeholder: 'Select an individual or department',
                ajax: {
                    url: '{{ route("dashboard.operations.getAssignedStatus") }}',
                    type: "get",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {
                        return {
                        '_token': '{{csrf_token()}}',
                        'assign_status': $('input[name=assign_status]:checked', '#AddTaskForm').val(),
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
