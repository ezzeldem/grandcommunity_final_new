
<div class="modal fade effect-newspaper show" id="camp_complain" tabindex="-1" role="dialog" aria-labelledby="camp_complain"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="camp_complain">
                   Complain
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-sm-12 col-md-12" >
                        <label>Complain</label>
                        {!! Form::textarea('complain', null, ['class'=>'form-control', 'id'=>'complain_text', 'style'=>'height: 130px;resize: unset;']) !!}
                    </div>
                    <input type="hidden" id="get_influ_id" value="">
                    <div class="col-sm-12 col-md-12 mt-2" id="complainStatusDiv" style="display:none;">
                        <button class="btn btn-danger change_status" data-status="0" id="unResolvedBtn">Un-Resolved</button>
                        <button class="btn btn-success change_status" data-status="1" id="ResolvedBtn">Resolved</button>
                        <button class="btn btn-primary" id="editComplain">Edit Complain</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center !important;">
                <div class="btn">
                    <button type="button" id="action_camp_complain" class="btn">Add Complain</button>
                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready( function () {

            //Get Complain Data Influencer
            let editStatus = false

            $(document).on('click','.openModalComplain',function(){
                editStatus = false
                $('#complain_text').val('');
                $('#get_influ_id').val($(this).attr('data-id'))

                var influ_id = $('#get_influ_id').val();
                var camp_id = "{{$campaign->id}}";
                $.ajax({
                    url:'{{url("dashboard/influe/complain")}}',
                    type:'post',
                    data:{
                        '_token': '{{ csrf_token() }}' ,'influencer_id':influ_id, 'campaign_id':camp_id
                    },success:function(res){
                        if(res['status'] == true){
                            if(res['influencerComplain'] != null){
                                $('#complain_text').prop('disabled',true);
                                $('#complain_text').val(res['influencerComplain']['complain']);
                                $('#action_camp_complain').hide()
                                $('#complainStatusDiv').show()
                                if(res['influencerComplain']['status'] == 0){
                                    $('#unResolvedBtn').prop('disabled',true);
                                    $('#ResolvedBtn').prop('disabled',false);
                                }else{
                                    $('#unResolvedBtn').prop('disabled',false);
                                    $('#ResolvedBtn').prop('disabled',true);
                                }

                            }else{
                                $('#complain_text').prop('disabled',false);
                                 $('#action_camp_complain').show()
                                 $('#complainStatusDiv').hide()
                            }
                            $('#action_camp_complain').text('Add Complain')
                        }else{
                            console.log('err');
                        }

                    }
                })
            })

            //Update complain Status
            $('.change_status').on('click',function(){
                console.log($(this).data('status'));
                var influ_id    = $('#get_influ_id').val();
                var camp_id     = "{{$campaign->id}}";
                var status      = $(this).data('status');
                $.ajax({
                    url:'{{url("dashboard/influe/complain/update_status")}}',
                    type:'post',
                    data:{
                        '_token': '{{ csrf_token() }}' ,'influencer_id':influ_id, 'campaign_id':camp_id, 'status':status
                    },success:function(res){
                        if(res['status'] == true){
                             Swal.fire(
                                 'success',
                                 'Complain updated successfully',
                                 'success',
                             )
                            $('#camp_complain').modal('hide');
                            exampleTbl.ajax.reload()
                        }else{
                            console.log('err');
                        }

                    }
                })

            })

            //edit complain
            $('#editComplain').on('click',function(){
                $('#complain_text').prop('disabled',false);
                $('#action_camp_complain').show()
                $('#action_camp_complain').text('Edit Complain')
                editStatus = true
            })


            //Add New Complain

            $('#action_camp_complain').on('click',function(){

                var influ_id = $('#get_influ_id').val();
                var camp_id  = "{{$campaign->id}}";
                var comp_txt = $('#complain_text').val();
                $.ajax({
                    url:'{{url("dashboard/influe/complain/store")}}',
                    type:'post',
                    data:{
                        '_token': '{{ csrf_token() }}' ,'influencer_id':influ_id, 'campaign_id':camp_id, 'complain':comp_txt, 'edit' : editStatus
                    },success:function(res){
                        if(res['status'] == true){
                             Swal.fire(
                                 'success',
                                 'Complain added successfully',
                                 'success',
                             )
                            $('#camp_complain').modal('hide');
                        }else{
                            console.log('err');
                        }
                    }
                })

            })


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
