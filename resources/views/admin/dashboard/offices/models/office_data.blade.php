<div class="modal fade effect-newspaper show" id="OfficeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Add New Office
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{--  --- Form --- Inputs ---  --}}
                {!!  Form::open(['url' => null, 'method' => null, 'files' => true, 'id' => 'TaskForm']) !!}
                    @include('admin.dashboard.offices.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script>
        $(`#country`).select2({
            placeholder: "Select",
            allowClear: true,
            maximumSelectionLength: 4,
        });

        $('#TaskForm').on('submit', function(e){
            e.preventDefault();
            var requestUrl = $(this).attr('action');
            var requestType = $(this).attr('method');
            console.log(requestUrl, requestType, $(this).serialize());
            
            $.ajax({
                url: requestUrl,
                type:requestType,
                data:$(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(res){
                    if(res['status']){
                        officesTable.ajax.reload();
                        $('#OfficeModal').modal('hide');
                        //clear inputs data
                        $('#TaskForm').trigger('reset');
                        Swal.fire("Success", res['message'], "success");
                    }else{
                        Swal.fire("Error", res['message'], "error");
                    }
                },error:function(response){
                    console.log('error', response);
                }
            })
        });
    </script>
    //<script>
    //
    //        $('#assigned_to').select2({
    //            placeholder: 'Select an individual or department',
    //            ajax: {
    //                url: '{{ route("dashboard.operations.getAssignedStatus") }}',
    //                type: "get",
    //                dataType: 'json',
    //                delay: 150,
    //                data: function (params) {
    //                    return {
    //                    '_token': '{{csrf_token()}}',
    //                    'assign_status': $('input[name=assign_status]:checked', '#AddTaskForm').val(),
    //                    search: params.term // search term
    //                    };
    //                },
    //                processResults: function (response) {
    //                    return {
    //                        results:  $.map(response['data'], function (item) {
    //                            return {
    //                                text: item.name,
    //                                id: item.id
    //                            }
    //                        })
    //                    };
    //                },
    //                cache: true
    //            }
    //        });
    //</script>
@endpush
