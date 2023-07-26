<?php


namespace App\Http\Traits\SocialScrape;


use App\Models\MediaTwitter;
use App\Models\ScrapeTwitter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as gRequest;
use App\Http\Resources\API\Brand_dashboard\TwitterScraperResource;
use App\Models\LogTwitter;

trait TwitterScrapeTrait
{


	public function scrapTwitter($influencer){

		$influencerTwitter  = isset($influencer->twitter) ? $influencer->twitter : (object)[];
		$settingCheckDate = Carbon::now()->subDays(10)->toDateString();
		if(empty($influencerTwitter) ||  empty($influencerTwitter->last_check_date) || (Carbon::parse($influencerTwitter->last_check_date)->format("Y-m-d") < $settingCheckDate )){
			$presponse = $this->CallTwitterApi(trim($influencer->twitter_uname));
					$userData = ($presponse && $presponse != '1' && !empty($presponse['data']['user']['result']))? $presponse['data']['user']['result'] : [];

					if(!empty($userData) && $userData['__typename'] == "User"){
					    $userData['influe_brand_id'] = $influencer->id;
						$userData['type'] = 1;
                            $influencerTwitter = $this->twitterInsertData($userData);
					}
		}

		 return new TwitterScraperResource($influencerTwitter);
	 }


	public function scrapTwitterById($influencer){

		$presponse = $this->CallTwitterByIDApi($influencer->twitter_id);
		$userData = ($presponse && $presponse != '1' && !empty($presponse['user']))? $presponse['user'] : [];
			if(!empty($userData) && $userData['__typename'] == "User"){
					$userData['influe_brand_id'] = $influencer->id;
					$userData['type'] = 1;
                    $influencerInstagram = $this->twitterInsertData($userData);
			}

	}


	public function twitterInsertData($userData){

	try{
		$data=[];$media_arr=[];

		    $data['influe_brand_id'] = $userData['influe_brand_id'];
		    $data['type'] = $userData['type'];
		    $data['twitter_id'] = $userData['rest_id'];
			$data['twitter_username'] = ($userData['legacy']) ? $userData['legacy']['screen_name'] : '';
			$data['name'] =($userData['legacy']) ? $userData['legacy']['name']:'';
			$data['bio']  = ($userData['legacy'])?$userData['legacy']['description']:'';
			$data['followers'] = ($userData['legacy'])?$userData['legacy']['followers_count']:0;
			$data['following'] = ($userData['legacy'])?$userData['legacy']['favourites_count']:0;
			$data['uploads'] = ($userData['legacy'])?$userData['legacy']['media_count']:0;
			$data['is_verified'] = ($userData['legacy'] && $userData['legacy']['verified'])?$userData['legacy']['verified']:0;
			$data['twitter_image']=($userData['legacy'])?$userData['legacy']["profile_image_url_https"] :'';
			$data['last_check_date'] = Carbon::now();

				$postresponse =$this->CallTwitterPostApi($data['twitter_id']);

                $media_response = isset($postresponse['data']['user']['result']['timeline_v2']['timeline']['instructions'][1]) ? $postresponse['data']['user']['result']['timeline_v2']['timeline']['instructions'][1]['entries'] : [];
				if ($media_response && !empty($media_response)) {
					foreach ($media_response as $key=>$item) {

						if(isset($item['content']['itemContent'])){
						   $media = $item['content']['itemContent']['tweet_results']['result'];

						   if(isset($media)){
								$media_arr[$key]['caption'] =isset($media["legacy"]['full_text']) ? $media["legacy"]['full_text'] :'' ;
								$media_arr[$key]['favorite_count'] =isset($media["legacy"]["favorite_count"]) ? $media["legacy"]["favorite_count"] :0;
								$media_arr[$key]['quote_count'] = isset($media["legacy"]["quote_count"]) ? $media['legacy']["quote_count"] :0;
								$media_arr[$key]['reply_count'] =isset($media["legacy"]["reply_count"]) ? $media['legacy']["reply_count"] :0;
								$media_arr[$key]['retweet_count'] =isset($media["legacy"]["retweet_count"]) ? $media['legacy']["retweet_count"] :0;
								$media_arr[$key]['shortcode'] =isset($media["legacy"]["conversation_id_str"]) ? $media["legacy"]["conversation_id_str"] :'';
						     }
					       }


					}
				}


				$insertData = ScrapeTwitter::updateOrCreate(['influe_brand_id'=>$data['influe_brand_id'],'type'=>$data['type']],$data);
				if(count($media_arr) > 0)
				{
					MediaTwitter::where('twitter_id', $insertData->id)->delete();
					foreach ($media_arr as $item){
						$post_arr[] = ['twitter_id'=>$insertData->id,'shortcode'=>$item['shortcode'],'caption'=>$item['caption'],'favorite_count'=>$item['favorite_count'],'quote_count'=>$item['quote_count'],'reply_count'=>$item['reply_count'],'retweet_count'=>$item['retweet_count']];
					}
					MediaTwitter::insert($post_arr);
				}

				LogTwitter::create([
                    'twitter_id' => $insertData->id,
                    'followers' => $data['followers'],
                    'following' => $data['following'],
                    'uploads' => $data['uploads'],
                    'twitter_username' => $data['twitter_username'],
                    'engagement_average_rate' => 0,
                ]);

				return $insertData;

	}catch (\Exception $ex){
         return response()->json(['status'=>false],500);
    }

	}




	public function CallTwitterApi($user_name){

		try{
			$client = new Client();
			$presponse = $client-> get('https://twitter135.p.rapidapi.com/UserByScreenName/?username='.$user_name, [
				'headers' => [
					"x-rapidapi-host"=>'twitter135.p.rapidapi.com',
					"x-rapidapi-key"=>'ad51d62d52msh403618c1113ce3ep1f1609jsn618d21b54d29'
				],
			]);

		      return json_decode($presponse->getBody(), true);
		} catch (\Exception $e) {
				return 1;
		}
	}



	public function CallTwitterByIDApi($twitter_id){

		try{
			$client = new Client();
			$presponse = $client-> get('https://twitter135.p.rapidapi.com/v2/UserByRestId/?id='.$twitter_id, [
				'headers' => [
					"x-rapidapi-host"=>'twitter135.p.rapidapi.com',
					"x-rapidapi-key"=>'ad51d62d52msh403618c1113ce3ep1f1609jsn618d21b54d29'
				],
			]);

		      return json_decode($presponse->getBody(), true);
		} catch (\Exception $e) {
				return 1;
		}
	}

	public function CallTwitterPostApi($insta_id){
		try{
				$client = new Client();
				$presponse = $client-> get('https://twitter135.p.rapidapi.com/UserTweets/?id='.$insta_id.'&count=12', [
					'headers' => [
						"x-rapidapi-host"=>'twitter135.p.rapidapi.com',
						"x-rapidapi-key"=>'ad51d62d52msh403618c1113ce3ep1f1609jsn618d21b54d29'
					],
				]);

				return json_decode($presponse->getBody(), true);
	    } catch (\Exception $e) {
				return 1;
		}
	}

	public function twitter_get_hashtags($string) {

        preg_match_all('/(?:#)([\p{L}\p{N}_](?:(?:[\p{L}\p{N}_]|(?:\.(?!\.))){0,28}(?:[\p{L}\p{N}_]))?)/u', $string, $array);


        return $array[1];

    }
}

