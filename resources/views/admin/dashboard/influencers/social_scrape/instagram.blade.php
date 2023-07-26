<style>
    .left_container .img_section #tiktok_image,
    .left_container .img_section #insta_image {
        border-radius: 50%;
        width: 125px;
        height: 125px;
        border: 3px solid #0b1426;
        margin: auto;
    }

    .left_container .img_section #tiktok_username,
    .left_container .img_section #insta_username {
        font-size: 16px;
        margin-top: 10px;
        font-weight: bold;
    }

    .left_container .img_section .tiktok_href,
    .left_container .img_section .insta_href {
        color: #a29e9e;
        text-decoration: underline;
    }

    .left_container .stats #tiktok_followers_count,
    .left_container .stats #tiktok_following,
    .left_container .stats #tiktok_uploads,
    .left_container .stats #insta_followers_count,
    .left_container .stats #insta_following,
    .left_container .stats #insta_uploads {
        font-size: 15px;
        font-weight: bold;
    }

    .left_container .stats small {
        color: #706d6d;
        font-weight: bold;
    }

    .stats {
        margin-top: 50px;
        border-top: 1px solid #cac9c9;
        border-bottom: 1px solid #cac9c9;
        padding: 25px 0 25px 0;
    }

    .left_container .img_section #tiktok_bio,
    .left_container .img_section #insta_bio {
        width: 50%;
        margin: auto;
        margin-bottom: 10px;
    }

    .right_container .main_stats i {
        color: #95BEB0;
        font-size: 19px;
    }

    .right_container .main_stats h5 {
        margin-top: 7px;
    }

    .right_container .main_stats p {
        margin-top: -7px;
    }

    .right_container .main_stats {
        /* border: 1px solid #dcdcdc; */
        padding: 20px 0px 0px 0px;
        border-radius: 3px;
        /* box-shadow: 0px 4px 11px rgb(0 0 0 / 10%); */
    }

    .right_container .charts_section h5 {
        text-align: left;
        margin-bottom: 20px;
    }

    .right_container .charts_section {
        border: 1px solid #dcdcdc;
        box-sizing: border-box;
        box-shadow: 0px 4px 11px rgb(0 0 0 / 10%);
        border-radius: 1px;
        padding: 20px;
        margin-top: 20px;
    }

    /* .right_container {
        display: grid;
        align-items: center;
        height: 100%;
    } */

    .all_media>h5 {
        text-align: left;
        margin-top: 50px !important;
        text-transform: uppercase;
        letter-spacing: 4px;
        font-size: 20px;
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="row padding tiktok_section">

            <div class="loader" style="display: none">
                <div class="loader-wheel"></div>
                <div class="loader-text"></div>
            </div>

            <div class="col-sm-4">
                <div class="left_container">
                    <div class="img_section text-center infl-instgram">
                        <img id="insta_image" src="{{@$instagramData->insta_image}}" alt="user">
                        <h3 id="insta_username">{{@$instagramData->insta_username}}</h3>
                        <p id="insta_bio">{{@$instagramData->bio}}</p>
                        <a class="insta_href" href="{{"https://www.instagram.com/".@$instagramData->insta_username}}">View Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                
                <div class="text-center">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <h3 class="m-b-0 font-light" id="insta_followers_count">{{kmb($instagramData->followers??0)}}</h3><small>Followers</small>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <h3 class="m-b-0 font-light" id="insta_following">{{kmb($instagramData->following) ?? 0}}</h3><small>Following</small>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <h3 class="m-b-0 font-light" id="insta_uploads">{{kmb($instagramData->uploads) ?? 0}}</h3><small>Posts</small>
                        </div>
						<div class="col-lg-3 col-md-3">
                            <h3 class="m-b-0 font-light" id="insta_engangement">{{nr($instagramData->engagement_average_rate??0,1)."%"}}</h3><small>Engagement Rate</small>
                        </div>
                    </div>
                </div>

				 <div class="clearfix"></div>
				<div class="right_container text-center">
                    <div class="averages">
                        <div class="row">
                         
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-12">
                <div class="text-center all_media mt-3" id="insta_videos">
                    <h5 class="mb-3 mt-3">Posts :</h5>
                    <div class="row">
						@if(isset($instagramData->instamedias) && !empty($instagramData->instamedias))
							@foreach($instagramData->instamedias as $video)
							<div class="col-sm-4">
								<div class="card" style=" border: 1px solid #f0c219 !important; ">
									<div class="card-body" style=" height: 322px; width: 100%; position: relative; padding: 0rem;">
										<iframe style="width: 100% !important; height: 100% !important; margin: 0rem !important; border: none !important;" class="instagram-media instagram-media-rendered" id="instagram-embed-0" src="https://www.instagram.com/p/{{$video->shortcode}}/embed/?cr=1&amp;v=14&amp;wp=489&amp;rd=http%3A%2F%2Flocalhost&amp;rp=%2Finfluencer_gc%2Freport%2Fmeshari_alawadi%2Finstagram#%7B%22ci%22%3A0%2C%22os%22%3A1020.1999999284744%2C%22ls%22%3A951.0999999046326%2C%22le%22%3A952.6999999284744%7D" allowtransparency="true" allowfullscreen="true" frameborder="0" height="648" data-instgrm-payload-id="instagram-media-payload-0" scrolling="no" style="background: white; max-width: 450px; width: calc(100% - 2px); border-radius: 3px; border: 1px solid rgb(219, 219, 219); box-shadow: none; display: block; margin: 0px 0px 12px; min-width: 326px; padding: 0px;height:750px;"></iframe>

									</div>
									<div class="card-footer" style="padding: 1rem 0.5rem;display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;">
										
									  <div class="likes-container" style=" display: flex; align-items: center; gap: 9px; ">
											<div class="--count">
												{{$video->likes}}
											</div>
											<div class="icon">
											      <i class="fa fa-heart"></i>
											</div>

										</div>
									<div class="comment-container" style=" display: flex; align-items: center; gap: 9px; ">
											<div class="--count">
											 {{$video->comments}}
											</div>
											<div class="icon">
												<i class="fa fa-comments"></i>
											</div>
										</div>
										
									</div>
								</div>
							</div>
							@endforeach
						@endif	
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


