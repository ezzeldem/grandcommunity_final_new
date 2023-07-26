{{-- Edit all  --}}
<div class="modal fade" id="edit_all"  role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    Edit Companies
                </h5>
                <button type="button" class="close" id="mod_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input class="text" type="hidden" id="influe_all_id" name="influe_all_id" value=''>
                <div class="form-group">
                    <label class="form-label">Status: </label>
                    <select class="form-control " id="bulk_active"  name="bulk_active" data-parsley-class-handler="#slWrapper2"  data-placeholder="Choose one">
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Expiration Date: </label>
                    <input class="form-control" name="bulk_expirations_date" id="bulk_expirations_date" placeholder="Enter Date" min="{{\Carbon\Carbon::tomorrow()->format('Y-m-d')}}" type="date">
                </div>
                <div class="form-group">
                    <label class="form-label">Countries: </label>
                    <select width="100%" class="form-control select2 @if($errors->has('country_id'))  parsley-error @endif" id="country_id" name="country_id[]" data-parsley-class-handler="#slWrapper2" data-parsley-errors-container="#slErrorContainer2" data-placeholder="Select One Or More" multiple="multiple">
                        @foreach($all_countries_data as  $country)
                            <option value="{{$country->id}}" {{ (collect(old('country_id'))->contains($country->id)) ? 'selected':'' }} >{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn Delete hvr-sweep-to-right"
                        data-dismiss="modal" id="mod_close">Close</button>
                <button type="button" id="submit_edit_all" class="btn Active hvr-sweep-to-right">Edit</button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
       $('.select2').select2();

        $(document).on('click','#submit_edit_all',function (){
            let selected_ids =  $('input[id="influe_all_id"]').val();
            let bulk_active =  $('#bulk_active').val();
            let bulk_countries =  $('#country_id').val();
            let bulk_expirations_date =  $('#bulk_expirations_date').val();
                $.ajax({
                    type: 'POST',
                    headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url: '{{route('dashboard.edit_all')}}',
                    data: {selected_ids:selected_ids,bulk_active:bulk_active,bulk_expirations_date:bulk_expirations_date,bulk_countries:bulk_countries},
                    dataType: 'json',
                    success: function (data) {
                        console.log(11111111111)
                        if(data.data){
                            $('#edit_all').modal('hide')
                            $("#bulk_active").val("").trigger("change")
                            $("#bulk_expirations_date").val("").trigger("change")
                            $("#country_id").val("").trigger("change")
                            Swal.fire("Updated!", "Update Successfully!", "success");
                            brand_tabels.ajax.reload();
                            for (let statictic in data.data){
                                let elId = data.data[statictic].id;
                                $(`#${elId}`).find('.counter-value').text(data.data[statictic].count)
                                console.log($(`#${elId}`).find('.counter-value').text(data.data[statictic].count))
                            }
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
        });

        //CLOSE BUTTON
        $(document).on('click','#mod_close',function(){
                $('#edit_all').modal('hide')
        })
    </script>
@endpush
