
<div class="modal fade effect-newspaper show" id="camp_confirmation_coverage" tabindex="-1" role="dialog" aria-labelledby="camp_complain"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="camp_complain">
                   Coverage
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="image" style="width: 130px;height: 130px;border-radius: 50%;overflow: hidden;margin: 1rem auto;box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;">
                    <img class="imagePic img-fluid" src="" style="width: 50%;height: 50%;object-fit: cover;transform: scale(1.1);" alt="..">
                </div>
                <div class="labels">
                    <label class="inflencer_name" style="font-size: 24px" ></label>
                </div>
                <div class="labels">
                    <label class="inflencer_username" style="font-size: 16px"></label>
                </div>

                <div class="row mb-4">

                        <div class="col-6">
                            <div class="row">
                                <input type="radio" name="status" class="control-form col-9 change_confirm_status" value="0">
                                <label class="col-3">yes</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <input type="radio" name="status" class="control-form col-9 change_confirm_status" value="1">
                                <label class="col-3">no</label>
                            </div>
                        </div>


                    <input type="hidden" id="get_influ_id" value="">
                    {{--  <div class="col-sm-12 col-md-12 mt-2" id="complainStatusDiv" style="display:none;">
                        <button class="btn btn-danger change_status" data-status="0" id="unResolvedBtn">Un-Resolved</button>
                        <button class="btn btn-success change_status" data-status="1" id="ResolvedBtn">Resolved</button>
                        <button class="btn btn-primary" id="editComplain">Edit Complain</button>
                    </div>  --}}
                </div>
            </div>
            <div class="modal-footer" style="justify-content: space-between !important;">
                <div class="btn">
                    <button type="button" id="action_camp_confirm_complain" class="btn">Update Coverage</button>
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
            //let editStatus = false



            //Update complain Status
            $('.change_confirm_status').on('click',function(){

                var influ_id    = $('#get_influ_id').val();
                var camp_id     = "{{$campaign->id}}";
                //var status      = $(this).data('status');
                var status      = $(this).val();
                if(status == 0){

                }

            })

            //edit complain
            $('#editComplain').on('click',function(){
                $('#complain_text').prop('disabled',false);
                $('#action_camp_complain').show()
                $('#action_camp_complain').text('Edit Complain')
                editStatus = true
            })


            //Add New Complain

            $('#action_camp_confirm_complain').on('click',function(){
                let reqUrl=''
                let data='';
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
