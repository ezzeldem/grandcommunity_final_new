<div class="modal fade" id="edit_all_tasks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <div class="modal-header" style="align-items: center">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Edit
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <label class="form-label offset-1">Assign Status: <span class="text-danger">*</span></label>
                    <div class="d-flex justify-content-start align-items-start flex-wrap">
                        {!! Form::radio('assign_status', 0, true,['class' => 'assign_status', 'id' => 'individuals']) !!}
                        {!! Form::label('individuals', 'Individuals', ['class' => 'form-label mt-0 ml-2']) !!}
                    </div>
                    <div class="d-flex justify-content-start align-items-start flex-wrap">
                        {!! Form::radio('assign_status', 1, true,['class' => 'assign_status', 'id' => 'departments']) !!}
                        {!! Form::label('departments', 'Departments', ['class' => 'form-label mt-0 ml-2']) !!}
                    </div>
                        @error('assign_status')
                        <ul class="parsley-errors-list filled text-danger" id="parsley-id-5"><li class="parsley-required">{{$message}}</li></ul>
                    @enderror
                </div>
            </div>
           <div class="form-group">
            <label class="form-label d-block">Assign To: <span class="text-danger">*</span></label>
            {!! Form::select("assigned_to[]",isset($task)?$assigns:[],isset($task)?$task->assign_to:null,['class' =>'form-control select2'.($errors->has('assigned_to') ? 'parsley-error' : null),
                                'multiple'=>'multiple', 'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'assigned_to'])!!}
            @error('assigned_to')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-5"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
             </div>

        <div class="form-group">
            <label class="form-label">Status: <span class="text-danger">*</span></label>
            {!! Form::select("status",['0' => 'Resolved', '1' => 'Unresolved'],null,['class' =>'form-control '.($errors->has('status') ? 'parsley-error' : null),
                            'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'status','placeholder'=>'-- Select Status --'])!!}
            @error('status')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-5"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Priority: <span class="text-danger">*</span></label>
            {!! Form::select("priority",['0' => 'Top', '1' => 'High', '2' => 'Low'],null,['class' =>'form-control '.($errors->has('priority') ? 'parsley-error' : null),
                            'data-show-subtext'=>'true','data-live-search'=>'true','id' => 'priority','placeholder'=>'-- Select Priority --'])!!}
            @error('priority')
                <ul class="parsley-errors-list filled text-danger" id="parsley-id-5"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Start Date: <span class="text-danger">*</span></label>


            {!! Form::date('start_date', isset($task) ? $task->start_date : '', ['class' =>'form-control '.($errors->has('start_date') ? 'parsley-error' : null),'placeholder'=> 'Description','id'=>'start_date' ]) !!}
            @error('start_date')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-2"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
        <div class="form-group">
            <label class="form-label">End Date: <span class="text-danger">*</span></label>
            {!! Form::date('end_date',  isset($task) ? $task->end_date : '', ['class' =>'form-control '.($errors->has('end_date') ? 'parsley-error' : null),'placeholder'=> 'Description','id'=>'end_date' ]) !!}
            @error('end_date')
            <ul class="parsley-errors-list filled text-danger" id="parsley-id-3"><li class="parsley-required">{{$message}}</li></ul>
            @enderror
        </div>
            </div>

            <div class="modal-footer custom">
                <div class="left-side">
                    <button type="button" class="btn Delete hvr-sweep-to-right" data-dismiss="modal">Cancel</button>
                </div>
                <div class="divider"></div>
                <div class="right-side">
                    <button type="button" id="submit_edit_tasks" class="btn Active hvr-sweep-to-right">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .form-group {
        /* display: flex;
        align-items: center ; */
    }
    .form-group .form-label {
        flex-basis: 20%
    }
    .form-group .select2-container--default {
        width: 100% !important;
    }
</style>
<script>

            $('#assigned_to').select2({
                placeholder: 'Select an individual or department',
                'margin-top': '25px',
                ajax: {
                    url: '{{ route("dashboard.tasks.getAssignedStatus") }}',
                    type: "get",
                    dataType: 'json',
                    delay: 150,
                    data: function (params) {

                        return {
                        'assign_status': $('input[name=assign_status]:checked').val(),
                        '_token': '{{csrf_token()}}',
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

            $('#edit_All').on('click',function(){
                selectedIds = $("#exampleTbl td input.box1:checkbox:checked").map(function(){
                 return $(this).val();
                }).toArray();
                if(selectedIds.length > 0)
                    $('#edit_all_tasks').modal('show');
                    else
                    Swal.fire("error", "please select tasks", "error");

            });

                $('#submit_edit_tasks').on('click',function(){
                        var assign_to = [];
                    $("#assigned_to option:selected").each(function() {
                        assign_to.push(this.value);
                    });
              selectedIds = $("#exampleTbl td input.box1:checkbox:checked").map(function(){
                 return $(this).val();
                }).toArray();
                var priority = $('#priority').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var status = $('#status').val();
                var assign_status = $('#assign_status').val();

               $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: `{{route('dashboard.task.edit_all')}}`,
                    data: {
                        'selectedIds':selectedIds,
                        'user_id':assign_to,
                        'priority':priority,
                        'start_date':start_date,
                        'end_date':end_date,
                        'status':status,
                        'assign_status':assign_status,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if(data.status == 'success' ){
                            $('#edit_all_tasks').modal('hide')
                            Swal.fire("Updated!", data.message, "success");
                            tasksTbl.ajax.reload();
                        }
                    },
                    error: function (data) {

                    }
                });

            });


</script>
