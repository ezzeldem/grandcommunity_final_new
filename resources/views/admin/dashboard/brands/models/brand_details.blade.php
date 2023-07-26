<div class="modal fade" id="brand_modal" tabindex="-1" role="dialog" aria-labelledby="brand_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 100%;width: 100%;text-align: center;display: flex;align-items: center;justify-content: center;">
        <div class="modal-content" style="width: 100%">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="well imageuserdetail">
                                <!-- <img class="imagePic img-fluid" src="http://localhost:8000/assets/img/avatar_logo.png" style="width: 100%;height: 100%;object-fit: cover;transform: scale(1);" alt=".."> -->
                            </div>
                        </div>

                        <div class="col-12" style="display: flex;text-align: left;border: 1px solid #00000054;border-radius: 10px;padding: 1rem 1.1rem;margin: 1rem 0rem;box-shadow: 0px 1px 3px 1px #0000006b;">
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
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn" id="updateConfirmation" style="display:none;">Update</button>
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <div class="divshow">

                </div>
            </div>
        </div>
    </div>

</div>
@push('js')
<script>
    $(document).ready(function() {


        $(document).on('click', '.brand_modal', function() {
            $('#exampleModalLongTitle').text('')
            var brand_id = $(this).attr("data-id");
            var type = $(this).attr("data-type");
            if(!type){
                type = 'brand'
            }
            if(type == 'brand'){
                $('#exampleModalLongTitle').text('Brand Details')
            }else{
                $('#exampleModalLongTitle').text('Influencer Details')
            }
            $.ajax({
                url: '{{url("dashboard/brand/brand_details")}}',
                type: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'brand_id': brand_id,
                    'type': type
                },
                success: function(res) {
                    let route_details = '/dashboard/brands/'+brand_id
                    if (res['BrandDetails'] != null) {
                        let userimage = res['BrandDetails'].image;
                        $('.name').html('');
                        $('.email').html('');
                        $('.phone').html('');
                        $('.insta').html('');
                        $('.whatsapp').html('');
                        $('.imageuserdetail').html('');
                        $('.tiktok').html('');
                        $('.snapchat').html('');
                        $('.divshow').html('');

                        $('.name').html(res['BrandDetails']['user'].user_name);
                        $('.email').html(res['BrandDetails']['user'].email);
                        $('.phone').html(res['BrandDetails']['user'].phone);
                        (res['BrandDetails'].insta_uname != null ?
                       
                            $('.insta').append(`<a target="_blank" href="https://www.instagram.com/${res['BrandDetails'].insta_uname}" style="color: #bcd0f7" class="mb-0">${res['BrandDetails'].insta_uname}</a> `) :
                            $('.insta').html('---'));
                        $('.whatsapp').html(res['BrandDetails'].whatsapp ?? '------');
                        $('.imageuserdetail').append(`
                            <img class="imagePic img-fluid" src="${userimage}"
                             style="width: 50%;height: 50%;object-fit: cover;transform: scale(1);" alt="..">

                            `);
                        $('.tiktok').html(res['BrandDetails'].tiktok_uname != "null" ? res['BrandDetails'].tiktok_uname : '------');
                        (res['BrandDetails'].snapchat_uname != null ? $('.snapchat').append(`<a style="color: #bcd0f7" href="https://story.snapchat.com/"+${res['BrandDetails'].snapchat_uname}" target="_blank" class="mb-0">${res['BrandDetails'].snapchat_uname}</a>`) : $('.snapchat').html('----'));
                        $('.divshow').append(` <a href="${route_details}" target="_blanck" class="btn" style="font-size: 15px;padding: 6px 10px; text-align: center;line-height: 21px;color:#fff">
                    <i class="fas fa-eye fs-6"></i>
                </a>`);



                    } else {

                    }
                }
            })


        });

    })
</script>

@endpush
