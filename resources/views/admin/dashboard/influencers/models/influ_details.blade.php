<!-- Modal -->
@push('style')
<style>

ul li{
margin-bottom:5px;
}

</style>
@endpush
<div class="modal fade modal-attach" id="influencer_modal" tabindex="-1" role="dialog" aria-labelledby="influencer_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;width: 100%;text-align: center;display: flex;align-items: center;justify-content: center;">
        <div class="modal-content" style="width: 100%">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">influencer Visit Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
            <!-- Expiration date Modal -->
                <div class="modal fade" id="add_expiration_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                {{--                <h5 class="modal-title" id="exampleModalLabel">Add Expiration Date</h5>--}}
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="parent_of_expiration">
                                    <label>Expiration Date</label>
                                    <input type="date" class="form-control" min="{{date('Y-m-d')}}" id="expire_date_input" />
                                    <small class="text-danger" id="expre_date_err"></small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" data-dismiss="modal">Close</button>
                                <button type="button" id="active_user" class="btn">Active</button>
                            </div>
                        </div>
                    </div>
                </div>

<div class="container">
<div class="row">
                    <div class="col-md-4">
                        <div class="well imageuserdetail">
                            <!-- <img class="imagePic img-fluid" src="http://localhost:8000/assets/img/avatar_logo.png" style="width: 100%;height: 100%;object-fit: cover;transform: scale(1);" alt=".."> -->
                        </div>
                    </div>

                    <div class="col-md-8" style="display: flex;text-align: left;border: 1px solid #00000054;border-radius: 10px;padding: 1rem 1.1rem;margin: 1rem 0rem;box-shadow: 0px 1px 3px 1px #0000006b;">
                        <div class="well float-left">
                            <ul>
                                <li class="item">
                                    <span class="badge badge-primary">
                                        Email :-
                                    </span>
                                    <span class="text email">

                                    </span>
                                </li>
                                <li class="item">
                                    <span class="badge badge-primary">
                                        Name :-
                                    </span>
                                    <span class="text name">

                                    </span>
                                </li>

                                <li class="item">
                                    <span class="badge badge-primary">
                                        Phone :-
                                    </span>
                                    <span class="text phone">

                                    </span>
                                </li>
                                <li class="item">
                                    <span class="badge badge-primary">
                                        Instagram :-
                                    </span>
                                    <span class="text insta">

                                    </span>
                                </li>

                                <li class="item">
                                    <span class="badge badge-primary">
                                        WhatsApp :-
                                    </span>
                                    <span class="text whatsapp">

                                    </span>
                                </li>
                                <li class="item">
                                    <span class="badge badge-primary">
                                        TikTok :-
                                    </span>
                                    <span class="text tiktok">

                                    </span>
                                </li>
                                <li class="item">
                                    <span class="badge badge-primary">
                                        SnapChat :-
                                    </span>
                                    <span class="text snapchat">

                                    </span>
                                </li>

                            </ul>
                            <div class="show_icon" style="margin: left auto;"></div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            <div class="modal-footer">

                <div class="divshow">

               </div>
            </div>
        </div>
    </div>

</div>
@push('js')
<script>
    $(document).ready(function() {


        $(document).on('click', '.influencer_modal', function() {
            var influ_id = $(this).attr("data-id");
            $.ajax({
                url: '{{url("dashboard/influe/influ_details")}}',
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'influencer_id': influ_id
                },
                success: function(res) {
                    let route_details = 'social-scrape/'+influ_id
                    if (res['influencerDetails'] != null) {
                        let appear = res['influencerDetails'].active;
                        let alldata = res['influencerDetails'];
                        let userimage = res['influencerDetails'].image;
                        $('.name').html('');
                        $('.email').html('');
                        $('.phone').html('');
                        $('.insta').html('');
                        $('.whatsapp').html('');
                        $('.imageuserdetail').html('');
                        $('.tiktok').html('');
                        $('.snapchat').html('');
                        $('.divshow').html('');
                        $('.show_icon').html('');


                        $('.name').html(res['influencerDetails']['user'].user_name);
                        $('.email').html(res['influencerDetails']['user'].email);
                        $('.phone').html(res['influencerDetails']['user'].phone);
                        // $('.insta').html(res['influencerDetails'].insta_uname);
                        $('.insta').append(`
                            <a target="_blank" href="https://www.instagram.com/"+${res['influencerDetails'].insta_uname}" style="color: #bcd0f7" class="mb-0">${res['influencerDetails'].insta_uname}</a>

                            `);
                        $('.whatsapp').html(res['influencerDetails'] ? res['influencerDetails'].whats_number : '-');
                        $('.imageuserdetail').append(`
                            <img class="imagePic img-fluid" src="${userimage}"
                             style="width: 50%;height: 50%;object-fit: cover;transform: scale(1);" alt="..">

                            `);
                            $('.tiktok').html(res['influencerDetails'].tiktok_uname ?? '------');

                           (res['influencerDetails'].snapchat_uname != null
                           ? $('.snapchat').append(`
                            <a style="color: #bcd0f7" href="https://story.snapchat.com/"+${res['influencerDetails'].snapchat_uname}" target="_blank" class="mb-0">${res['influencerDetails'].snapchat_uname}</a>

                            `):'----');

                $('.show_icon').append(` <a href="${route_details}" target="_blanck" class="btn btn-warning" style="font-size: 15px;padding: 6px 10px; text-align: center;line-height: 21px;">
                    <i class="fas fa-eye fs-6"></i>
                </a>`);


                $('.divshow').append(` <button data-toggle="tooltip" data-placement="top" title="Reject Influencer" class="btn mt-2 mb-2 rejectRow" ${appear == 3 ? 'disabled':''} data-flag="reject" id="accept-${influ_id}" data-id="${influ_id}"><i class="fa fa-times-circle"></i> Reject</button>`)
                if(appear == 2 || appear == 3 || appear == 0 || appear != 1){
                    $('.divshow').append(` <button data-toggle="tooltip" data-placement="top" title="Active Influencer" data-flag="active" class="btn  mt-2 mb-2 acceptRow" id="accept-${influ_id}" data-id="${influ_id}" ><i class="icon-toggle-right"></i> Active </button>`)

                }else{
                    $('.divshow').append(`<button data-toggle="tooltip" data-placement="top" title="Inactivate Influencer" class="btn  mt-2 mb-2 ml-1 InAcceptRow" data-flag="inactive" id="inactive-${influ_id}" data-id="${influ_id}" ><i class="icon-toggle-left"></i> Inactivate </button>`)

                }
                $('.divshow').append(` <button type="button" class="btn " data-dismiss="modal">Close</button>`)

                    } else {

                    }
                }
            })
        });

        function swalAccept(id,data_flag){

            let accetp_swal = Swal.fire({
                title: "Are you sure you want to inactivate?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Inactivate',
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(function (result){
                if (result.isConfirmed){
                    let expire_date = ($('#expire_date_input').val() != '' && $('#expire_date_input').val() != null) ? $('#expire_date_input').val() : -1;
                    $.ajax({
                        url:`/dashboard/influencer-accept/${id}`,
                        type:'post',
                        data:{expire_date,data_flag},
                        headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        success:(data)=>{
                            if(data.status){
                                // $('.acceptRow').attr("disabled", 'disabled');
                                $('.fa-circle').addClass('active')
                                $('.fa-circle').attr('title', 'Active')
                                $('.fa-circle').attr('data-original-title', 'Active')
                                $('#add_expiration_date').modal('hide')
                                $('#expire_date_input').val('')
                                Swal.fire("accepted!",data.message, "success");
                                location.reload();
                            }else{
                                Swal.fire.close();
                                let err = data.message.expirations_date[0];
                                $('#expre_date_err').show();
                                $('#expre_date_err').text(err)
                            }
                        },
                        error:(data)=>{
                            // console.log(data);
                        }
                    })
                } else {
                    $('#add_expiration_date').modal('hide')
                    $('#expire_date_input').val('')
                    Swal.fire("Cancelled", "canceled successfully!", "error");
                }
            })
        }
        $(document).on('click','.rejectRow',function (){
            let id = $(this).data('id');
            let data_flag = $(this).data('flag');
            swalAccept(id,data_flag);
        });
        $(document).on('click','.InAcceptRow',function (){
            let id = $(this).data('id');
            let data_flag = $(this).data('flag');
            swalAccept(id,data_flag);
});
$(document).on('click','.acceptRow',function (){

            $('#expre_date_err').hide();
            $('#expre_date_err').text('')
            let id = $(this).data('id');
            let data_flag = $(this).data('flag');
            $('#add_expiration_date').modal('show')
            $(document).on('click','#active_user',function (){
                swalAccept(id,data_flag);
            });
        });



    })
</script>

@endpush
