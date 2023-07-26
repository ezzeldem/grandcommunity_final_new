
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
                        <img id="insta_image" src="{{@$snapchatData->snap_image}}" alt="user">
                        <h3 id="insta_username">{{@$snapchatData->snap_username}}</h3>
                        <p id="insta_bio">{{@$snapchatData->bio}}</p>
                        <a class="insta_href"  href="{{"https://story.snapchat.com/@".@$snapchatData->snap_username}}">View Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                
                <div class="text-center">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <h3 class="m-b-0 font-light" id="insta_followers_count">{{nr($snapchatData->followers??0)}}</h3><small>Followers</small>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <h3 class="m-b-0 font-light" id="insta_uploads">{{$snapchatData->uploads ?? 0}}</h3><small>Posts</small>
                        </div>
						<div class="col-lg-3 col-md-3">
                            <h3 class="m-b-0 font-light" id="insta_engangement">{{nr($snapchatData->engagement_average_rate??0,1)."%"}}</h3><small>Engagement Rate</small>
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
					@if(isset($snapchatData->snapmedias) && !empty($snapchatData->snapmedias))	
					    @foreach($snapchatData->snapmedias as $video)
							<div class="col-sm-4">

							<div class="card" style=" border: 1px solid #f0c219 !important; ">
							    <video style="height:450px;margin-top:20px;" src="{{$video->shortcode}}" controls></video>
								<div class="card-footer" style="padding: 1rem 0.5rem;display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;">	
									  <div class="likes-container" style=" display: flex; align-items: center; gap: 9px; ">
											<div class="--count">
												{{$video->share}}
											</div>
											<div class="icon">
											      <i class="fa fa-share"></i>
											</div>

										</div>
									<div class="comment-container" style=" display: flex; align-items: center; gap: 9px; ">
											<div class="--count">
											 {{$video->view}}
											</div>
											<div class="icon">
												<i class="fa fa-eye"></i>
											</div>
										</div>
										
									</div></div>

							</div>
                        @endforeach
					@endif	
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

  