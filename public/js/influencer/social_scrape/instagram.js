$(document).ready(function (){

    // $(window).on('load', function() {
    //     $('#pills-insta-tab').trigger('click');
    // })

    $('#pills-insta-tab').on('click',function (e){
        e.preventDefault();
        var username = $('#instagram_uname').val()
        var instagram_followers = $('#instagram_follwers').val()
        var influ_id = $('#influ_id').val()
        if(instagram_followers==''||instagram_followers==null){
            $('.loader').css('display','flex');
            $('#insta_videos .row').empty();
            $.ajax({
                type: 'POST',
                headers:{'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: '/dashboard/influencer/instagram',
                dataType: 'json',
                data:{'user_name':username,'influ_id':influ_id},
                success: function (data) {
                    if(data.status){
                        var insta_videos = data.data.media;
                        $('#insta_username').text(username)
                        $('#insta_logs_chart').val(JSON.stringify(data.data.insta_logs))
                        $('#insta_followers_count').text(data.data.followers)
                        $('#insta_following').text(data.data.following)
                        $('#instagram_follwers').val(data.data.followers)
                        $('#insta_uploads').text(data.data.uploads)
                        $('#insta_bio').text(data.data.bio)
                        $('#likes_insta').text(data.data.total_likes)
                        $('#comments_insta').text(data.data.total_comments)
                        $('#insta_image').attr('src',data.data.insta_image)
                        $('#insta_engangement').text(data.data.average_engagement+'%')
                        var user_videos = ``;
                        if(insta_videos.length > 0){
                            insta_videos.map(function (item){
                                user_videos+= `
                                <div class="col-sm-4">
                                    <iframe class="instagram-media instagram-media-rendered" id="instagram-embed-0" src="https://www.instagram.com/p/${item.shortcode}/embed/?cr=1&amp;v=14&amp;wp=489&amp;rd=http%3A%2F%2Flocalhost&amp;rp=%2Finfluencer_gc%2Freport%2Fmeshari_alawadi%2Finstagram#%7B%22ci%22%3A0%2C%22os%22%3A1020.1999999284744%2C%22ls%22%3A951.0999999046326%2C%22le%22%3A952.6999999284744%7D" allowtransparency="true" allowfullscreen="true" frameborder="0" height="648" data-instgrm-payload-id="instagram-media-payload-0" scrolling="no" style="background: white; max-width: 450px; width: calc(100% - 2px); border-radius: 3px; border: 1px solid rgb(219, 219, 219); box-shadow: none; display: block; margin: 0px 0px 12px; min-width: 326px; padding: 0px;height:800px;"></iframe>
                                </div>`;
                            })
                        }
                        $('#insta_videos .row').append(user_videos);
                        $('.loader').css('display','none');
                        chart_insta();
                    }

                },
                error: function () {
                    $('.loader').css('display','none');
                    Swal.fire("Error!","This Account Fake... User Name Not Found","error")
                }
            });
        }

    })

    function chart_insta(){

        ////////////////////// likes ///////////////////
        let insta_logs_chart = $('#insta_logs_chart').val();
        insta_logs_chart = JSON.parse(insta_logs_chart);
        const labels_data = insta_logs_chart.labels;
        const followers = {
            labels: labels_data,
            datasets: [
                {
                    label: 'Followers',
                    data: insta_logs_chart.followers,
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
            document.getElementById('likes_chart_insta'),
            followersConfig
        );

        ////////////////////// comments ///////////////////
        const labels_comments = insta_logs_chart.labels;
        const comments = {
            labels: labels_comments,
            datasets: [
                {
                    label: 'Following',
                    data: insta_logs_chart.following,
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
            document.getElementById('comments_chart_insta'),
            commentsConfig
        );
    }

    chart_insta();
})
