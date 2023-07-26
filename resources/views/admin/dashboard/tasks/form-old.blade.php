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
