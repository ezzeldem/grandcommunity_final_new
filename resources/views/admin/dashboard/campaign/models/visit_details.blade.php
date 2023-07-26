<!-- Modal -->
<div class="modal fade" id="visit_details" tabindex="-1" role="dialog" aria-labelledby="visit_details" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;width: 70%;text-align: center;display: flex;align-items: center;justify-content: center;">
        <div class="modal-content" style="width: 100%">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Influencer Visit Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="image" style="width: 130px;height: 170px;border-radius: 50%;margin: 1rem auto;">
                    <img class="imagePic img-fluid" src="" style="width: 50%;height: 50%;object-fit: cover;transform: scale(1.1);" alt="..">
                </div>
                <div class="labels">
                    <label class="inflencer_name" style="font-size: 24px" ></label>
                </div>
                <div class="labels">
                    <label class="inflencer_username" style="font-size: 16px"  ></label>
                </div>
                <div class="" style="width: 100% !important;overflow-x: scroll;">
                    <table class="table">
                        <thead class="" style="height: 35px;text-align: center;">
                        <tr>
                            <th scope="col">Qr Code</th>
                            <th scope="col">Code</th>
                            <th scope="col">Valid</th>
                            <th scope="col">Number Of Uses</th>
                            <th scope="col">Valid Number Of Uses</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <a title="ImageName" id="qrcode">
                                    <img alt="ImageName" style="width: 66px;height: 66px">
                                </a>
                            </td>
                            <td>
                                <div class="copy-text-area d-flex justify-content-center">
                                    <textarea readonly id="code" class="_username_influncer"></textarea>
                                    <button title="copy" class="copy_btn ml-3 _username_influncer" onClick="copyElementToClipboard('#code')"><i class="fa fa-clone"></i></button>
                                </div>
                            </td>
                            <td><div id="valid" style="font-size: 16px"></div></td>
                            <td><div id="noOfUses" class="inflencer_username" style="font-size: 16px"></div></td>
                            <td>
                                <div class="d-flex justify-content-start align-items-start flex-row">
                                    <div id="validTimes" class="inflencer_username" style="font-size: 16px"></div>
                                    <a href="javascript:void(0);"  class="editValidTime ml-3" onclick="editQrCodeTime(this);" id="edit_validtime"><i style="color:#ea6c0a;font-size:22px" class="fas fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <form id="editvalidTime_form" class=" mt-2 mb-2" style="display: none;">
                        <div class="" style="margin-left: 13px;display: flex;justify-content: flex-start;align-items: flex-start;gap: 15px;">
                            <label class="" style="margin-top: 9px">Valid Number Of Uses</label>
                            <div class="">
                                <input type="hidden" name="camp_influ_id" class="camp_influ_id">
                                <input class="form-control" type="Number" min="0" name="validTime_input" id="validTime_input" value="1">
                                <ul class="parsley-errors-list filled" id="parsley-id-11"><li class="parsley-required validTime_input_error"></li></ul>
                            </div>
                            <div class="">
                                <button type="button" class="btn btn-info" id="editTime_btn" onclick="SaveValidTime(this);">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row p-2">
                    <div class="d-flex justify-content-center" style="width: 100%;"  id="test_code_card">
                        <div class="card border-info col-md-12 mb-3" >
                            <div class="card-header">Test Code / Qrcode</div>
                            <div class="card-body text-info">
                                <table class="table">
                                    <thead class="thead-dark" style="height: 35px;text-align: center;">
                                    <tr>
                                        <th scope="col">Test QrCode</th>
                                        <th scope="col">Test Code</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <a title="ImageName" id="test_qrcode">
                                                <img alt="ImageName" style="width: 66px;">
                                            </a>
                                        </td>
                                        <td>
                                            <div class="copy-text-area d-flex justify-content-center">
                                                <textarea readonly id="test_code"></textarea>
                                                <button title="copy" class="copy_btn ml-3" onClick="copyElementToClipboard('#test_code')"><i class="fa fa-clone"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row p-4" id="visit_model" style="display:none">
                    @can('delete campaigns')
                        <button type="button" class="btn btn-danger  mr-2 float-right" style="border-radius:8px;" id="del-All">
                            <i class="fas fa-trash-alt"></i> Delete Selected
                        </button>
                    @endcan
                    <table class="table mt-2" id="visits">
                        <thead class="" style="height: 35px;text-align: center; background: #0047b161;">
                        <tr>
                            <th>
                                <input name="select_all" id="select_all" type="checkbox" />
                            </th>
                            <th scope="col">
                                Visit Date
                            </th>
                            <th scope="col">
                                Code Type
                            </th>
                        </tr>
                        </thead>
                        <tbody id="visits_table_data">

                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row p-4" id="campaignStatus" style="display:none">
                    <div style="display: inline-flex;">
                        <label for="confirm_status" style=" margin-right: 151px; ">
                        <input type="radio" id="confirm_status" name="campaign_influencer_status" value="1">
                        &nbsp;Confirm</label><br>
                        &nbsp;<label for="pending_status" style=" margin-right: 151px; ">
                        <input type="radio" id="pending_status" name="campaign_influencer_status" value="0">
                        Pending</label><br>
                        &nbsp;<label id="status_visit_input" for="visit_status">
                        <input type="radio" id="visit_status" name="campaign_influencer_status" value="2">
                        Visit</label><br>
                    </div>
                </div>
                <div class="row p-4" id="confirmation_model" style="display:none">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label> Confirmation Date</label>
                            <input type="hidden" name="campaign_influ_id" value="">
                            <input type="date" class="form-control" name="confirmation_date" id="confirm_date" >
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 mt-2" >
                        <div class="form-group">
                            <label class="control-label col-md-4">Brief</label>
                            <div style="display: inline-flex;">
                                <label for="brief_no" style=" margin-right: 151px; ">
                                    <input type="radio" id="brief_no" name="brief_stats" value="0">
                                    &nbsp;Not sent
                                </label>
                                <br>
                                &nbsp;
                                <label for="brief_yes">
                                    <input type="radio" id="brief_yes" name="brief_stats" value="1">
                                    sent
                                </label>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 mt-2" >
                        <div class="form-group">
                            <label class="control-label col-md-4">Coverage</label>
                            <div style="display: inline-flex;">
                                <label for="coverage_no" style=" margin-right: 151px; ">
                                <input type="radio" id="coverage_no" name="confirmation_coverage_stats" value="0">
                                &nbsp;Not Uploaded</label><br>
                                &nbsp;<label for="coverage_yes">
                                <input type="radio" id="coverage_yes" name="confirmation_coverage_stats" value="1">
                                Uploaded</label><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 mt-2" id="dataAppend"></div>
                </div>

                <div class="row p-4" id="visit_date_model" style="display:none">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label> Visit Date</label>
                            <input type="hidden" name="campaign_influ_id" value="">
                            <input type="date" class="form-control" name="visit_date" id="visit_date" >
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label> Branch </label>
                            <select class="form-control" name="branch" id="branch_id">
                                <option>Select Branch</option>
                                @foreach($allBranches as $branch)
                                    <option value='{{$branch->id}}'>{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn" id="updateConfirmation" style="display:none;">Update</button>
                <button type="button" class="btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).on('click','.details_moodal',function (){
            //Get Base Inforamtion Ready
            $('#visits td .check-box1').prop('checked', this.checked);
            $('#get_influ_id').val($(this).attr('data-id'));
            $('#confirmation_model').hide();
            $('#visit_model').hide();
            $('#campaignStatus').hide();
            $('#visit_date_model').hide();
            $('#updateConfirmation').hide();
            var influ_id = $('#get_influ_id').val();
            var camp_id = "{{$campaign->id}}";

            //Get Data Based on Tabs Session (Confirm - Visit)
            if(localStorage.getItem('TapType') == 'confirmed'){
                console.log('open confirmaed');
                $('#confirmation_model').show();
                $("#confirm_status").click();
                $('#campaignStatus').show();
                $('#updateConfirmation').show();
                 $("#status_visit_input").show();
                $('#visit_model').hide();
                getCampaignInfluencer(influ_id, camp_id);
            }else if(localStorage.getItem('TapType') == 'visit'){
                $("#status_visit_input").hide();
                $('#campaignStatus').show();
                $('#updateConfirmation').show();
                //$('#visits_table_data').remove();
                $('#visits_table_data').find('tr').remove();
                $('#visit_model').show();
                $.ajax({
                    url:'{{url("dashboard/influe/get_visits")}}',
                    type:'post',
                    data:{
                        '_token': '{{ csrf_token() }}' ,'influencer_id':influ_id, 'campaign_id':camp_id
                    },success:function(res){
                        // console.log('influencerVisits',res);
                        if(res['influencerVisits'] != null){
                            var actual_date= moment(res['influencerVisits']['visit_date']).format('YYYY-MM-DD');
                            var branch_id = res['influencerVisits']['branch_id'];
                            $('#visit_date').val(actual_date);
                            $('[name="branch"]').val(res['influencerVisits']['branch_id']).change();
                            $.each(res['influencerVisits'], function(i,v){
                            if(v.used_code_type == 0){
                                var code = '<span class="btn btn-primary"><i class="fas fa-qrcode"></i>Qr Code</span>';
                            }else if(v.used_code_type == 1){
                                var code = '<span class="btn btn-info"><i class="fas fa-code"></i>Code</span>';
                            }else{
                                var code = '<span class="btn btn-warning"><i class="fas fa-magnifying-glass"></i>Search Manually</span>';
                            }
                            $('#visits_table_data').append(`
                                <tr id="row_${v.id}">
                                    <td>
                                        <input type="checkbox" value="${v.id}" class="check-box1">
                                    </td>
                                    <td>${v.actual_date}</td>
                                    <td>${code}</td>
                                </tr>
                            `)
                            });

                        }else{

                        }
                    }
                })
            }
        });

        $('[name="campaign_influencer_status"]').on('change',function(){
            var influ_id = $('#get_influ_id').val();
            var camp_id = "{{$campaign->id}}";
            $('#confirmation_model').hide();
            if($(this).val() == 1){
                $('#confirmation_model').show();
                $('#visit_date_model').hide();
            }else if($(this).val() == 2){
                $('#confirmation_model').hide();
                $('#visit_date_model').show();
                getCampaignInfluencer(influ_id, camp_id);
            }else{
                $('#visit_date_model').hide();
                $('#confirmation_model').hide();
            }
        })

        function getCampaignInfluencer(influ_id, camp_id){
            $.ajax({
                url:'{{url("dashboard/influe/get_confirmation")}}',
                type:'post',
                data:{
                    '_token': '{{ csrf_token() }}' ,'influencer_id':influ_id, 'campaign_id':camp_id
                },success:function(res){
                    $('[name="campaign_influ_id"]').val(res['influencerConfirmation']['id']);
                    var confirm_date= moment(res['influencerConfirmation']['confirmation_date']).format('YYYY-MM-DD');
                    var coverage_date= moment(res['influencerConfirmation']['coverage_date']).format('YYYY-MM-DD');
                    $('#confirm_date').val(confirm_date);

                    if(res['influencerConfirmation']['brief'] == null){
                        $('#brief_no').attr('checked', true);
                    }else{
                        $('#brief_yes').attr('checked', true);
                    }

                    if(res['influencerConfirmation']['coverage_date'] == null){
                        $('#coverage_no').attr('checked', true);
                    }else{
                        $('#coverage_yes').attr('checked', true);
                        $('#ConfirmationCoverageDate').remove();
                        $('#dataAppend').append(`<div class="col-sm-12 col-md-12">
                            <div class="form-group" id="ConfirmationCoverageDate">
                                <label> Coverage Date</label>
                                <input type="date" class="form-control" name="coverage_date" value="${coverage_date}" id="coverage_date">
                            </div>
                        </div>`);
                    }
                    console.log(res,date);
                }
            })
        }
        // select all
        $('#visits input[name="select_all"]').click(function () {
            $('#visits td .check-box1').prop('checked', this.checked);
        });


        $(document).on('click','#del-All',function (){
            selectedIds = $("#visits td input[class='check-box1']:checkbox:checked").map(function(){
                return $(this).val();
            }).toArray();
            if(selectedIds.length){
                console.log(selectedIds)
            }else{
                Swal.fire("warning", "please select ids", "warning");
            }
            $.ajax({
                type: 'POST',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: '{{route("dashboard.campaign.influencers.visits.delete_all")}}',
                data: {selectedIds:selectedIds},
                dataType: 'json',
                success: function (data) {
                    if(data.status){
                        $('#visit_details').modal('hide')
                        Swal.fire("Deleted!", "Deleted Successfully!", "success");
                        $.each(selectedIds,function(i,v){
                            $('#row_'+v).remove();
                        })
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });




        $('input[name="confirmation_coverage_stats"]').on("change",function() {
            $('#ConfirmationCoverageDate').remove();
            if(this.value == 1){
                $('#dataAppend').append(`
                    <div class="col-sm-12 col-md-12 " id="ConfirmationCoverageDate" >
                            <div class="form-group">
                                <label> Coverage Date</label>
                                <input type="date" class="form-control" name="coverage_date" id="coverage_date" >
                            </div>
                    </div>
                `);
            }else{
                $('#ConfirmationCoverageDate').remove();
                //$('#camp_status .modal-body .row #ConfirmationCoverageDate').text('');
            }
        });

        $('#updateConfirmation').on('click',function(){
            var influ_id = $('#get_influ_id').val();
            console.log(influ_id);
            var camp_id = "{{$campaign->id}}";
            var confirmation_date = $('[name="confirmation_date"]').val();
            var brief = $('[name="brief_stats"]').val();
            var status = $('input[name="campaign_influencer_status"]:checked').val();
            var visit_date  =$('#visit_date').val();
            var branch_id  =$('#branch_id').val();
            if($('input[name="confirmation_coverage_stats"]:checked').val() == 1){
                var coverage_date = $('#coverage_date').val();
            }else{
                var coverage_date = null;
            }
            $.ajax({
                url:'{{ url("/dashboard/influe/confirmation/update") }}',
                type:'post',
                data:{'_token': '{{ csrf_token() }}', 'status': status, 'influencer_id':influ_id, 'campaign_id':camp_id, 'confirmation_date':confirmation_date,
                'brief':brief, 'coverage_date':coverage_date, 'branch_id':branch_id,'visit_date':visit_date},
                success:function(res){
                    if(res['status'] == true){
                        Swal.fire(
                            'success',
                            'Complain updated successfully',
                            'success',
                        )
                        $('#visit_details').modal('hide');
                        exampleTbl.ajax.reload()
                    }else{
                        console.log('err');
                    }
                }
            });
        });
    </script>
@endpush
