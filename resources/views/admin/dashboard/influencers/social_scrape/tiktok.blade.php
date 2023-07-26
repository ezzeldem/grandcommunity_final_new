
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
                        <img id="tiktok_image" src="{{$tiktokdata->tiktok_image}}" alt="user">
                        <h3 id="tiktok_username">@ {{@$tiktokdata->tiktok_username}}</h3>
                        <p id="tiktok_bio">{{$tiktokdata->bio ?? 'Influencer bio'}}</p>
                        <a class="tiktok_href" href="{{"https://www.tiktok.com/@".@$tiktokdata->tiktok_username}}">View Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
               
                <div class=" text-center">
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <h3 class="m-b-0 font-light" id="tiktok_followers_count">{{nr($tiktokdata->followers??0)}}</h3><small>Followers</small>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <h3 class="m-b-0 font-light" id="tiktok_following">{{$tiktokdata->following ?? 0}}</h3><small>Following</small>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <h3 class="m-b-0 font-light" id="tiktok_uploads">{{$tiktokdata->total_likes ?? 0}}</h3><small>likes</small>
                            </div>
							<div class="col-lg-3 col-md-3">
                                <h3 class="m-b-0 font-light" id="tiktok_uploads">{{nr($tiktokdata->engagement_average_rate??0,1)."%"}}</h3><small>Engagement Rate</small>
                            </div>
                        </div>
                    </div>
            </div>

           
            <div class="col-sm-12">
                <div class="text-center all_media mt-3" id="tiktok_videos">
                    <h5 class="mb-3 mt-3">Posts :</h5>
                    <div class="row">
					@if(isset($tiktokdata->tiktokmedias) && !empty($tiktokdata->tiktokmedias))		
                        @foreach($tiktokdata->tiktokmedias as $video)
                        <div class="col-sm-4">
						<div class="card" style=" border: 1px solid #f0c219 !important; ">
                            <iframe class="tiktok-embed" src="{{"https://www.tiktok.com/embed/v2/".$video->video_id.""}}" data-video-id="{{$video->video_id}}" style="max-width: 605px;min-width: 325px;height:800px;">
                             </iframe>
							 <div class="card-footer" style="padding: 1rem 0.5rem;display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;">	
							 <div class="likes-container" style=" display: flex; align-items: center; gap: 9px; ">
											<div class="--count">
												{{$video->likes}}
											</div>
											<div class="icon">
											      <i class="fa fa-heart"></i>
											</div>

										</div>
										<div class="likes-container" style=" display: flex; align-items: center; gap: 9px; ">
											<div class="--count">
												{{$video->comments}}
											</div>
											<div class="icon">
											      <i class="fa fa-comments"></i>
											</div>

										</div>		  
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
										
									</div>
                        </div> </div>
                        @endforeach
					@endif	
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
