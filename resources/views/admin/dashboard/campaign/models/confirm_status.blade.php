
<div class="modal fade effect-newspaper show" id="camp_status" tabindex="-1" role="dialog" aria-labelledby="camp_status"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="camp_status">
                   Campaign Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form style="display:flex;align-items :center ; gap :20px" action="{{  url('dashboard/influe/import') }}" method="POST"  id="camp_status">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-sm-12 col-md-12" >
                       <label> Status</label>
                            <select class="form-control">
                                <option>Visit</option>
                                <option>Not Visit</option>
                                <option>pending</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-12" >
                       <label> Check in Visit Date</label>
                            <input type="date" class="form-control" >
                        </div>
                        <div class="col-sm-12 col-md-12" >
                       <label> Branch</label>
                            <select class="form-control">
                                <option>Visit</option>
                                <option>Not Visit</option>
                                <option>Confirm</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <div class="btn">
                    <button type="button" id="action_camp_status" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready( function () {

            // $(document).on('click', '#import_excel_btn', function (e) {
            //     let import_excel = $('#import_excel').val();
            //     if (import_excel == '' || import_excel == null) {
            //         e.preventDefault();
            //         Swal.fire("Cancelled", "Please Choose Excel File!", "warning");
            //     } else {
            //         $('#submit_import_form').submit();
            //     }
            // });


        })
    </script>
@endpush
