<div class="modal fade" id="edit_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Edit Influencer
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input class="hidden" type="hidden" id="influe_all_id" name="influe_all_id" value=''>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <select class="form-control select2" data-placeholder="Chose number" data-allow-clear="true"  multiple="multiple" name="bulk_status" id="bulk_status" >
                                {{--  @foreach($status as $sta)
                                    <option value={{$sta->value}}> {{$sta->name}} </option>
                                @endforeach  --}}
                            </select>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-control " id="bulk_active"  name="bulk_active" data-parsley-class-handler="#slWrapper2"  data-placeholder="Choose one">
                                <option value="-1"> InActive </option>
                                <option value="1"> Active </option>
                                <option value="2"> Pending </option>
                                <option value="3"> Reject </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Expiration Date</label>
                            <input class="form-control" name="bulk_expirations_date" id="bulk_expirations_date" placeholder="Enter Date" type="date">
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn"
                        data-dismiss="modal">Close</button>
                <button type="button" id="submit_edit_all" class="btn">Edit</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).on('click','#submit_edit_all',function (){
            let selected_ids =  $('input[id="influe_all_id"]').val();
            let bulk_status =  $('#bulk_status').val();
            let bulk_active =  $('#bulk_active').val();
            let bulk_expirations_date =  $('#bulk_expirations_date').val();
            if( (bulk_status.length == 0 && bulk_active==null && bulk_expirations_date=='') ){
                Swal.fire('warning','Please Select at least one option to save ! ','warning')
            }else{
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.influe_edit_all')}}',
                    data: {selected_ids:selected_ids,bulk_active:bulk_active,bulk_status:bulk_status,bulk_expirations_date:bulk_expirations_date},
                    dataType: 'json',
                    success: function (data) {
                        if(data.data){
                            $('#edit_all').modal('hide')
                            $("#bulk_status").val("").trigger("change")
                            $("#bulk_active").val("").trigger("change")
                            $("#bulk_expirations_date").val("").trigger("change")
                            Swal.fire("Updated!", "Update Successfully!", "success");
                            influe_tabels.ajax.reload();
                            for (let statictic in data.data){
                                let elId = data.data[statictic].id;
                                $(`#${elId}`).find('.counter-value').text(data.data[statictic].count)
                            }
                        }

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        });
    </script>
@endpush
