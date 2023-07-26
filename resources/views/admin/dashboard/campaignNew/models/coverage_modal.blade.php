<div class="modal fade effect-newspaper show" id="coverage_camp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                   Coverage
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <form style="display:flex;align-items :center ; gap :20px"  method="POST" enctype="multipart/form-data">

                    <div class="row mb-4">
                        <div class="col-sm-12 col-md-12" style="width: 478px;height: 182px">
                            @if($campaign->campaign_type==0||$campaign->campaign_type==2)
                            <label> Confirmation Visit </label>
                            <input type="text" name="confirmation_visit"  value="{{$campaign->confirmation_link}}" class="form-control" id="confirmation_visit" >
                                <small class="text-danger" id="err_visit_confirm"></small><br>
                                <label>Coverage Visit </label>
                            <input type="text" name="coverage_visit" class="form-control" value="{{$campaign->visit_coverage}}" id="coverage_visit" >
                                <small class="text-danger" id="err_visit_confirm_link"></small><br>
                             @elseif($campaign->campaign_type==1||$campaign->campaign_type==2)
                                <label>  Confirmation Delivery </label>
                            <input type="text" name="confirmation_delivery" value="{{$campaign->confirmation_delivery_link}}" class="form-control" id="confirmation_delivery" >
                            <label> Coverage Visit </label>
                            <input type="text" name="coverage_delivery" value="{{$campaign->delivery_coverage}}" class="form-control" id="coverage_delivery" >
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <div class="btn">
                    <button type="button" id="update_coverage_done" class="btn btn-success">Save</button>
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

            $(document).on('click', '#update_coverage_done', function (e) {
                $('#err_visit_confirm').empty()
                $('#err_visit_confirm_link').empty()
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        url: '/dashboard/camp-coverage-update',
                        data: {
                            "coverage_visit": $('#coverage_visit').val(),
                            "confirmation_link": $('#confirmation_visit').val(),
                            "delivery_coverage": $('#coverage_delivery').val(),
                            "confirmation_delivery_link": $('#confirmation_delivery').val(),
                            "type": "{{$campaign->campaign_type}}",
                            "id": "{{$campaign->id}}",
                            "_token":"{{csrf_token()}}"
                        },
                        success: (data) => {
                            Swal.fire("Updated!", "Data Updated Successfully!", "success");
                            $('#coverage_camp').modal('hide');
                        location.reload();
                        },
                        error: function (err) {
                            if (err.responseJSON.errors) {
                                if (err.responseJSON.errors.coverage_visit) {
                                    $('#err_visit_confirm_link').html(err.responseJSON.errors.coverage_visit)
                                }
                                if (err.responseJSON.errors.confirmation_link) {
                                    $('#err_visit_confirm').html(err.responseJSON.errors.confirmation_link)
                                }
                            }
                        }

                    });

            });
        })
    </script>
@endpush
