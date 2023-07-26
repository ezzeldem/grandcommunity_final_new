<?php


namespace App\Http\Traits\SocialScrape;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as gRequest;
use App\Models\ScrapeTiktok;
use App\Models\MediaTiktok;
use App\Models\Influencer;
use App\Http\Resources\API\Brand_dashboard\TiktokScraperResource;
use App\Models\LogTiktok;
use Carbon\Carbon;

trait TiktokScrapeTrait
{
	public function scrapeTiktok($influencer)
    {
        $influencertiktok  =isset($influencer->tiktok) ? $influencer->tiktok : (object)[];
		$settingCheckDate = Carbon::now()->subDays(10)->toDateString();
		if(empty($influencertiktok) ||  empty($influencertiktok->last_check_date) || (Carbon::parse($influencertiktok->last_check_date)->format("Y-m-d") < $settingCheckDate )){
			$presponse =$this->callTiktokApi(trim($influencer->tiktok_uname));
				$userData = ($presponse &&  $presponse != '1' && !empty($presponse))? $presponse['user'] : [];
				  if(!empty($userData)){
				    $userData['influe_brand_id'] = $influencer->id;
					 $userData['type'] = 1;
			         $influencertiktok = $this->InsertTikTokData($userData);
				   }
		}
		return new TiktokScraperResource($influencertiktok);
     }


	 public function scrapTiktokById($influencer){

		$presponse = $this->CallTiktokByIDApi($influencer->tiktok_id);
		$userData = ($presponse && $presponse != '1' && !empty($presponse['user']))? $presponse['user'] : [];
			if(!empty($userData)){
					$userData['influe_brand_id'] = $influencer->id;
					$userData['type'] = 1;
                    $influencertiktok = $this->InsertTikTokData($userData);
			}
	 }

	 public function InsertTikTokData($userData){
	  try{

		$engagement_rate_array = []; $media_arr=[]; $likes_array = [];
		$data['influe_brand_id'] = $userData['influe_brand_id'];
		$data['type'] = $userData['type'];
		$data['tiktok_id'] = $userData['uid'];
		$data['tiktok_username'] = $userData['unique_id'];
		$data['name'] =$userData['nickname'];
		$data['tiktok_image'] = $userData['avatar_thumb']['url_list'][0];
		$data['bio']  = isset($userData['signature']) ? $userData['signature'] : '' ;
		$data['followers'] = $userData['follower_count'];
		$data['following'] = isset($userData['following_count']) ? $userData['following_count'] : 0;
		$data['uploads']= isset($userData['aweme_count']) ? $userData['aweme_count'] : 0 ;
		$data['total_likes'] = $userData['total_favorited'];
		$data['is_private'] = $userData['privacy_setting']['following_visibility'] == 2 ? 1 : 0;
		$data['is_verified'] = isset($userData['verification_type']) ? 1 : 0;
		$data['last_check_date'] = Carbon::now();

		       $postresponse =$this->CallTiktokPostApi($data['tiktok_id']);

                $media_response = (isset($postresponse['aweme_list'])) ? $postresponse['aweme_list'] : [] ;
				if ($media_response && !empty($media_response)) {
					foreach ($media_response as $key=>$media) {
						$media_arr[$key]['video_id'] =$media['statistics']["aweme_id"];
						$media_arr[$key]['shortcode'] =$media["author"]["avatar_thumb"]["url_list"][0];
						$media_arr[$key]['likes'] =$media['statistics']["digg_count"];
						$media_arr[$key]['comments'] =$media["statistics"]["comment_count"];
						$media_arr[$key]['view'] =$media["statistics"]["play_count"];
						$media_arr[$key]['share'] =$media["statistics"]["share_count"];
						$media_arr[$key]['type'] = 1 ;

						$likes_array[] = $media['statistics']["digg_count"];
						$media_stat_count = $media["statistics"]["play_count"] > 0 ?  $media["statistics"]["play_count"] : 1;

						$engagement_rate_array[$key] = nr((($media['statistics']["digg_count"] + $media["statistics"]["comment_count"]+$media["statistics"]["share_count"]) /$media_stat_count )* 100, 2);
                   }
				}

				   $eng_ag_count = count($engagement_rate_array) > 0 ? count($engagement_rate_array) : 1;
				   $data['average_engagement']=count($likes_array) > 0 ? number_format(array_sum($engagement_rate_array) / $eng_ag_count, 2) : 0;
				   $insertData = ScrapeTiktok::updateOrCreate(['influe_brand_id'=>$data['influe_brand_id'],'type'=>$data['type']],$data);
				   if(count($media_arr) > 0)
				   {
					  MediaTiktok::where('tiktok_id', $insertData->id)->delete();
					   foreach ($media_arr as $item){
						   $post_arr[] = ['tiktok_id'=>$insertData->id,'video_id'=>$item['video_id'],'media_url'=>$item['shortcode'],'likes'=>$item['likes'],'comments'=>$item['comments'],'type'=>$item['type'],'view'=>$item['view'],'share'=>$item['share']];
					   }
					   MediaTiktok::insert($post_arr);
				   }

            LogTiktok::create([
                        'tiktok_id' => $insertData->id,
                        'followers' => $data['followers'],
                        'following' => $data['following'],
                        'uploads'   => $data['uploads'],
                        'tiktok_username' => $data['tiktok_username'],
                        'engagement_average_rate' => $data['average_engagement'],
                 ]);

				   return $insertData;
			}catch (\Exception $ex){
				return response()->json(['status'=>false],500);
			}
	 }


	public function callTiktokApi($user_name){
      try{
			$client = new Client();
			$presponse = $client-> get('https://tokapi-mobile-version.p.rapidapi.com/v1/user/@'.$user_name, [
				'headers' => [
				    "content-type"=>"application/octet-stream",
					"x-rapidapi-host"=>'tokapi-mobile-version.p.rapidapi.com',
					"x-rapidapi-key"=>'ad51d62d52msh403618c1113ce3ep1f1609jsn618d21b54d29'
				],
			]);

			return  json_decode($presponse->getBody(), true);
		} catch (\Exception $e) {
				return 1;
		}
	}


	public function CallTiktokPostApi($user_name){
      try{
        $client = new Client();
		$presponse = $client-> get('https://tokapi-mobile-version.p.rapidapi.com/v1/post/user/'.$user_name.'/posts?count=10&with_pinned_posts=1', [
			'headers' => [
			    "content-type"=>"application/octet-stream",
				"x-rapidapi-host"=>'tokapi-mobile-version.p.rapidapi.com',
				"x-rapidapi-key"=>'ad51d62d52msh403618c1113ce3ep1f1609jsn618d21b54d29'
			],
		 ]);

		return  json_decode($presponse->getBody(), true);

		} catch (\Exception $e) {
			return 1;
        }
	}


	public function CallTiktokByIDApi($tiktokId){
		try{
			$client = new Client();
			$presponse = $client-> get('https://tokapi-mobile-version.p.rapidapi.com/v1/user/'.$tiktokId, [
				'headers' => [
				    "content-type"=>"application/octet-stream",
					"x-rapidapi-host"=>'tokapi-mobile-version.p.rapidapi.com',
					"x-rapidapi-key"=>'ad51d62d52msh403618c1113ce3ep1f1609jsn618d21b54d29'
				],
			]);

			return  json_decode($presponse->getBody(), true);
		} catch (\Exception $e) {
				return 1;
		}
	}


}
