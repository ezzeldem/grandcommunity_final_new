$(document).ready(function (){
    $('#pills-snapchat-tab').on('click',function (e){
        e.preventDefault();
        var username = $('#snapchat_uname').val()
        var snapchat_followers = $('#snapchat_follwers').val()
        var influ_id = $('#influ_id').val()

        if(snapchat_followers == ''||snapchat_followers == null){
            $('.loader').css('display','flex');
            $('#snap_videos .row').empty();
            $.ajax({
                type: 'POST',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: '/dashboard/influencer/snapchat',
                dataType: 'json',
                data:{'user_name':username,'influ_id':influ_id},
                success: function (data) {
                    console.log(data)
                    if(data.data[0]){
                        var snap_profile = data.data[0];
                        $('#snapchat_username').text(snap_profile.username)
                        $('#snap_followers_count').text(snap_profile.followers)
                        $('#snapchat_follwers').val(snap_profile.followers)
                        $('#snap_uploads').text(snap_profile.uploads)
                        $('#snap_bio').text(snap_profile.bio)
                        $('#snap_image').attr('src',snap_profile.snap_image)
                        $('#snap_engangement').text(snap_profile.engagement_average_rate+'%')

                        var user_videos = ``;
                        if(snap_profile.media.length > 0){
                            snap_profile.media.map(function (item){
                                user_videos+= `
                             <div class="col-sm-4">
                                <video style="height:600px;margin-top:20px;" src="https://cf-st.sc-cdn.net/d/${item.video_id}.80.IRZXSOY?uc=12" controls></video>
                            </div>`;

                            })
                        }
                        $('#snap_videos .row').append(user_videos);
                    }
                    $('.loader').css('display','none');

                },
                error: function () {
                    $('.loader').css('display','none');
                    swal("Error!","Error Happened","error")
                }
            });
        }

    })
})
