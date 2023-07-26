
<div class="modal fade" id="visit_details" tabindex="-1" role="dialog" aria-labelledby="visit_details" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;width: 100%;text-align: center;display: flex;align-items: center;justify-content: center;">
        <div class="modal-content" style="width: 100%">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">influencer Visit Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="create_import">
                <button type="button" class="btn " id="imports"  data-toggle="modal" data-target="#import_excels">
                    <i class="icon-share-alternitive"></i> import
                </button>
        </div>
            <div class="modal-body">
                <div class="image" style="width: 130px;height: 130px;border-radius: 50%;overflow: hidden;margin: 1rem auto;box-shadow: 0 3px 1px -2px #0003, 0 2px 2px #00000024, 0 1px 5px #0000001f;">
                    <img class="imagePic img-fluid" src="" style="width:50%;height:50%;object-fit: cover;transform: scale(1.1);" alt="..">
                </div>
                <div class="labels">
                    <label class="inflencer_name" style="font-size: 24px" ></label>
                </div>
                <div class="labels">
                    <label class="inflencer_username" style="font-size: 16px"  ></label>
                </div>
                <div class="" style="width: 100% !important;overflow-x: scroll;">
                    <table class="table">
                        <thead class="" style="height: 35px;text-align: center; background: #0047b161;">
                        <tr>
                            <th scope="col">QrCode</th>
                            <th scope="col">Code</th>
                            <th scope="col">Valid</th>
                            <th scope="col">No.of uses</th>
                            <th scope="col">Valid Times</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <a title="ImageName" id="qrcode">
                                    <img alt="ImageName" style="width: 66px;">
                                </a>
                            </td>
                            <td>
                                <div class="copy-text-area d-flex justify-content-center">
                                    <textarea readonly id="code"></textarea>
                                    <button title="copy" class="copy_btn ml-3" onClick="copyElementToClipboard('#code')"><i class="fa fa-clone"></i></button>
                                </div>
                            </td>
                            <td><div id="valid" style="font-size: 16px"></div></td>
                            <td><div id="noOfUses" class="inflencer_username" style="font-size: 16px"></div></td>
                            <td>
                                <div class="d-flex justify-content-start align-items-start flex-row">
                                    <div id="validTimes" class="inflencer_username" style="font-size: 16px"></div>
                                    <a href="javascript:void(0);"  class="editValidTime ml-3" onclick="editQrCodeTime(this);" id="edit_validtime"><i style="color:#fff;font-size:22px" class="fas fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <form id="editvalidTime_form" class=" mt-2 mb-2" style="display: none;">
                        <div class="" style="margin-left: 13px;display: flex;justify-content: flex-start;align-items: flex-start;gap: 15px;">
                            <label class="" style="margin-top: 9px">Valid Time</label>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
    // $(document).ready(function () {
        // console.log('test');
                // $(document).on('click','#confirm_all', function (event){
                    // console.log(231564);
                //     event.preventDefault();
                //     localStorage.setItem("ModalStatus", 'visit');
                //     $('#camp_status .modal-body').text('');
                //     selectedIds = $("#exampleTbl td input[class='check-box1']:checkbox:checked").map(function(){
                //         return $(this).val();
                //     }).toArray();
                //     var locale = localStorage.getItem("ModalStatus");
                //     console.log(locale);
                //     if(selectedIds.length){
                //         $('#camp_status .modal-body').append(
                //             `<form style="display:flex;align-items :center ; gap :20px" id="campaign_status_not_visit" action="{{  url('dashboard/influe/confirm') }}" method="POST">
                //             @csrf
                //             <div class="row mb-4">


                //                     <div class="col-sm-12 col-md-12 mt-2" >
                //                     <div class="form-group">

                //                     <div style="display: inline-flex;">

                //                     Are you sure  return  user to confirmed


                //                         Yes</label><br>
                //                         </div>
                //                         </div>
                //                         </div>
                //                         </div>

                //                         </form>`
                //         )

                //         $('#camp_status').modal('show');
                //     }else{
                //         Swal.fire("warning", "please select ids for confirmation", "warning");
                //     }
                // });
            // });

            // $('#campaign_status_not_visit').on('click', function(){
            //     console.log(010165465);
            // });

    </script>
@endpush
