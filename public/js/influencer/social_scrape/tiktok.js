$(document).ready(function (){
    $('#pills-tiktok-tab').on('click',function (e){
        e.preventDefault();
        var username = $('#tiktok_uname').val()
        var tiktok_followers = $('#tiktok_followers').val()
        var influ_id = $('#influ_id').val()
        if(tiktok_followers == '' || tiktok_followers == null){
            $('.loader').css('display','flex');
            $('#tiktok_videos .row').empty()
            $.ajax({
                type: 'POST',
                data: {'username':username,'influ_id':influ_id},
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: '/dashboard/influencer/tiktok',
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    var tiktok_user = data.data.user;
                    var tiktok_stats = data.data.stats;
                    var tiktok_videos = data.data.user_get_videos;
                    $('#tiktok_logs_chart').val(JSON.stringify(data.data.tiktok_logs))
                    $('#tiktok_username').text(username)
                    $('#tiktok_uploads').text(tiktok_stats.videoCount)
                    $('#tiktok_followers_count').text(tiktok_stats.followerCount)
                    $('#tiktok_following').text(tiktok_stats.followingCount)
                    $('#tiktok_eng_rate').text(data.data.eng_rate)
                    $('#likes').text(tiktok_stats.heartCount)
                    $('#comments').text(data.data.comments)
                    $('#tiktok_bio').text(tiktok_user.signature)
                    $('#tiktok_followers').val(tiktok_stats.followerCount)
                    $('#tiktok_image').attr('src',tiktok_user.avatarLarger)
                    var user_videos = ``;
                    if(tiktok_videos.length > 0){
                        tiktok_videos.map(function (item){
                            user_videos+= `
                                <div class="col-sm-4">
                                     <iframe class="tiktok-embed" src="https://www.tiktok.com/embed/v2/${item.video_id}" data-video-id="${item.video_id}" style="max-width: 605px;min-width: 325px;height:800px;" > <section>
                                     </section> </iframe>
                                </div>`;
                        })
                    }
                    $('#tiktok_videos .row').append(user_videos);
                    $('.loader').hide();
                    chart_tiktok();
                },
                error: function () {
                    $('.loader').hide();
                    swal("Error!", "Error Happened!", "error");
                }
            });
        }else{

        }

    })





function chart_tiktok(){

    ////////////////////// likes ///////////////////
    let tiktok_logs_chart = $('#tiktok_logs_chart').val();
    tiktok_logs_chart = JSON.parse(tiktok_logs_chart);
    const labels_data = tiktok_logs_chart.labels;
    const followers = {
        labels: labels_data,
        datasets: [
            {
                label: 'Followers',
                data: tiktok_logs_chart.followers,
                fill: false,
                borderColor: '#E7AEC0',
                tension: 0.1
            }
        ]
    };
    const followersConfig = {
        type: 'line',
        data: followers,
    };
    const likesChart = new Chart(
        document.getElementById('likes_chart'),
        followersConfig
    );

    ////////////////////// comments ///////////////////
    const labels_comments = tiktok_logs_chart.labels;
    const comments = {
        labels: labels_comments,
        datasets: [
            {
                label: 'Following',
                data: tiktok_logs_chart.following,
                fill: false,
                borderColor: '#95BEB0',
                tension: 0.1
            }
        ]
    };
    const commentsConfig = {
        type: 'line',
        data: comments,
    };
    const commentsChart = new Chart(
        document.getElementById('comments_chart'),
        commentsConfig
    );
}

    chart_tiktok();

})
