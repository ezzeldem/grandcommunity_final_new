<?php


namespace App\Http\Traits\SocialScrape;
use App\Models\MediaSnapchat;
use App\Models\ScrapeSnapchat;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;
use App\Http\Resources\API\Brand_dashboard\SnapchatScraperResource;
use App\Models\LogSnapchat;
use Illuminate\Support\Facades\Log;

trait SnapchatScrapeTrait
{
    //scrape snapchat
    public function scrapeSnap($influencer)
    {
		$influencerSnapchat  = isset($influencer->snapchat) ? $influencer->snapchat : (object)[];
		$settingCheckDate = Carbon::now()->subDays(5)->toDateString();
		if(empty($influencerSnapchat) ||  empty($influencerSnapchat->last_check_date) || (Carbon::parse($influencerSnapchat->last_check_date)->format("Y-m-d") < $settingCheckDate )){
			$userData =$this->callSnapChatApi(trim($influencer->snapchat_uname));
				if($userData != '1'){
					$userData['influe_brand_id'] = $influencer->id;
						$userData['type'] = 1;
					$influencerSnapchat = $this->InsertSnapData($userData);
				}
		}

		//dd($influencerSnapchat);
		return new SnapchatScraperResource($influencerSnapchat);
     }

	public function InsertSnapData($profile){
	try{
		$data['influe_brand_id'] = $profile['influe_brand_id'];
		$data['type'] = $profile['type'];
		$profile = $profile[0];
			$userProfile = $profile->userProfile;
			$media_arr=[]; $totalView=[];$totalShare=[];

	    if(!isset($userProfile->publicProfileInfo))
		{
			$data['snap_username'] = (string)$userProfile->userInfo->username;
			$data['snap_image'] = isset($profile->userProfile->userInfo->bitmoji3d) ? $profile->userProfile->userInfo->bitmoji3d->avatarImage->url : '';
			$data['name'] =html_entity_decode($userProfile->userInfo->displayName);
			$data['is_private'] = 1;
			$data['followers']  = 0;
			$data['is_verified'] = 0;
		}else{
			$data['snap_username'] = (string)$userProfile->publicProfileInfo->username;
			$data['snap_image'] = (string)$userProfile->publicProfileInfo->profilePictureUrl;
			$data['name'] =(string)html_entity_decode($userProfile->publicProfileInfo->title);
			$data['bio']  = (string)html_entity_decode($userProfile->publicProfileInfo->bio);
			$data['followers'] = $userProfile->publicProfileInfo->subscriberCount;
			$data['uploads'] = count($profile->spotlightHighlights);
			$data['is_private'] = ($profile->pageMetadata->pageType == 'NOT_FOUND') ? 1 : 0;
			$data['is_verified'] = $userProfile->publicProfileInfo->badge;
		}
		$data['last_check_date'] = Carbon::now();

		foreach ($profile->spotlightHighlights as $key=>$media)
        {
            $mediaurl=$media->snapList[0]->snapUrls->mediaUrl;
			$media_id = $media->snapList[0]->snapId->value;
			$media_type = $media->snapList[0]->snapMediaType;

            $share_count = isset($profile->spotlightHighlightsMetadata[$key]->engagementStats->shareCount) ? $profile->spotlightHighlightsMetadata[$key]->engagementStats->shareCount : 0;
            $view_count = isset($profile->spotlightHighlightsMetadata[$key]->engagementStats->viewCount) ?(int)$profile->spotlightHighlightsMetadata[$key]->engagementStats->viewCount : 0;
            $media_arr[$key] = ['media_id'=>$media_id,'shortcode'=>$mediaurl,'view'=>(int)$view_count,'share'=>$share_count,'media_type'=>$media_type];
            $totalView[$key] = $view_count;
            $totalShare[$key] = $share_count;
        }

			$views_sum = array_sum($totalView);
			$views_count = count($totalView) > 0 ? count($totalView) : 1 ;
			$engangment_rate = nr(($views_sum / $views_count) * 100);
				$data['total_views'] = array_sum($totalView);
				$data['total_share'] = array_sum($totalShare);
		        $data['engagement_average_rate']=number_format((int)$engangment_rate , 2);

		   $insertData = ScrapeSnapchat::updateOrCreate(['influe_brand_id'=>$data['influe_brand_id'],'type'=>$data['type']],$data);
		   if(count($media_arr) > 0)
		   {
			MediaSnapchat::where('snapchat_id', $insertData->id)->delete();
				foreach ($media_arr as $item){
					$post_arr[] = ['snapchat_id'=>$insertData->id,'media_id'=>$item['media_id'],'shortcode'=>$item['shortcode'],'view'=>$item['view'],'share'=>$item['share'],'media_type'=>$item['media_type']];
				}
				MediaSnapchat::insert($post_arr);
			}

            LogSnapchat::create([
                'snapchat_id' => $insertData->id,
                'followers' => $data['followers'],
                'uploads' => $data['uploads'],
                'snapchat_username' => $data['snap_username'],
                'engagement_average_rate' => $data['engagement_average_rate'],
            ]);

        return $insertData;
		}catch (\Exception $ex){
			return response()->json(['status'=>false],500);
	   }
	}


	public function callSnapChatApi($user_name){
		try{
			$client = new \Goutte\Client();//create a new client.
			$crawler = $client->request('GET', 'https://story.snapchat.com/s/'.$user_name );//go to site

			$data1 = $crawler->filterXpath("//script[@id='__NEXT_DATA__']")->extract(array('type'));
			$new_data = [];

			$descriptions = $crawler->filter('#__NEXT_DATA__')->each(function ($node) use(&$request,&$new_data)
			{
				$profileInfo=json_decode($node->html())->props->pageProps;
				array_push($new_data,$profileInfo);
			});

			return $new_data;

	  } catch (\Exception $e) {
		return 1;
     }

	}

}
