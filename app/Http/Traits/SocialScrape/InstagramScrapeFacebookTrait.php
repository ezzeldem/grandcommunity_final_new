<?php


namespace App\Http\Traits\SocialScrape;


use App\Models\LogInstagram;
use App\Models\MediaInstagram;
use App\Models\ScrapeInstagram;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Instagram\Api;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as gRequest; 

trait InstagramScrapeFacebookTrait
{


    public function scrapiacebook($influencer){

		$presponse = $this->callInstagramApi2($influencer->insta_uname);
		//dd($presponse);
		$userData = ($presponse && $presponse != '1' && !empty($presponse['business_discovery']))? $presponse['business_discovery'] : [];
		if(!empty($userData)){
		    $userData['influe_brand_id'] = $influencer->id;
			$userData['type'] = 1;
			$this->InsertData2($userData);
		}
    }


	public function InsertData2($userData){
		  $data=[];$likes_array = [];$comments_array = [];$hashtags_array = [];$engagement_rate_array =[];$details=[];$media_arr=[];

		    $data['influe_brand_id'] = $userData['influe_brand_id'];
		    $data['type'] = $userData['type'];
		    $data['insta_id'] = $userData['ig_id'];
			$data['insta_username'] = $userData['username'];
			$data['name'] =isset($userData['name']) ? $userData['name'] : '';
			$data['bio']  = isset($userData['biography']) ? $userData['biography'] : '';
			$data['followers'] = $userData['followers_count'];
			$data['following'] = $userData['follows_count'];
			$data['uploads'] = $userData['media_count'];
			$data['is_private'] =0;// $userData['is_private'];	
			$data['is_verified'] = 0;//$userData['is_verified'];
			$data['last_check_date'] = Carbon::now();
			$data['insta_image']=isset($userData["profile_picture_url"]) ? $userData["profile_picture_url"] :  '';

			if($data['is_private']) {
				$data['average_engagement_rate'] = 0;
				$data['details'] = '';
			} else {
			    
			    if(isset($userData['media'])){
                $media_response = $userData['media']['data'];
				if ($media_response && !empty($media_response)) {
				
					foreach ($media_response as $key=>$media) {

						$split = explode("/", $media["permalink"]);
                        $shortcode = (empty($split[count($split)-1])) ? $split[count($split)-2] : $split[count($split)-1];
                        $likes = 10;//$media["like_count"];
						$media_arr[$key]=[
							  'media_id'=>$media["id"],
							 'shortcode'=>$shortcode,
							 'caption'=>isset($media['caption']) ? $media['caption'] : '',
							 'likes'=>$likes,
							 'comments'=>$media['comments_count'],
							 'media_type'=>$media['media_type'],
							 'type'=>0
						];
					
 
						$likes_array[$shortcode] = $likes;
						$comments_array[$shortcode] = $media['comments_count'];
						$data['followers'] = $data['followers'] == 0 ? 1 : $data['followers'];
						$engagement_rate_array[$shortcode] = nr(($likes +  $media['comments_count']) / $data['followers'] * 100, 2);
	
	                   if(isset($media['caption']) && !empty($media['caption'])){
						$hashtags = $this->get_hashtags2($media['caption']);
						foreach ($hashtags as $hashtag) {
							if (!isset($hashtags_array[$hashtag])) {
								$hashtags_array[$hashtag] = 1;
							} else {
								$hashtags_array[$hashtag]++;
							}
						}
	                   }
					}
				}
				$data['engagement_average_rate']=count($likes_array) > 0 ? number_format(array_sum($engagement_rate_array) / count($engagement_rate_array), 2) : 0;
				$data['total_likes'] = array_sum($likes_array);
				$data['total_comments'] = array_sum($comments_array);
				$data['avg_comments'] = count($comments_array) > 0 ? round($data['total_comments'] / count($comments_array)) : 0;
				$data['avg_likes'] = count($likes_array) > 0 ? round($data['total_likes'] / count($likes_array)) : 0;
				$details['top_hashtags'] =array_slice($hashtags_array, 0, 15);;
				$data['details'] = json_encode($details);


				$insrtedId = ScrapeInstagram::updateOrCreate(['influe_brand_id'=>$data['influe_brand_id'],'type'=>$data['type']],$data);
				if(count($media_arr) > 0)
				{
					MediaInstagram::where('instagram_id', $insrtedId->id)->delete();
					foreach ($media_arr as $item){
						MediaInstagram::create(['instagram_id'=>$insrtedId->id,'media_id'=>$item['media_id'],'shortcode'=>$item['shortcode'],'likes'=>$item['likes'],'comments'=>$item['comments'],'type'=>$item['type'],'caption'=>$item['caption'],'media_type'=>$item['media_type']]);
					}
				}
			    }
			}
			
	}

 

	public function get_hashtags2($string) {

        preg_match_all('/(?:#)([\p{L}\p{N}_](?:(?:[\p{L}\p{N}_]|(?:\.(?!\.))){0,28}(?:[\p{L}\p{N}_]))?)/u', $string, $array);
        return $array[1];

    }


	public function callInstagramApi2($username){
	 try{
	     $accessToken = 'EAADnKDVVKeUBAGOZAUu7ZCOKp6ZAhZCBzwHlJuiVB1wkGfXE5ZAkOShB5eWuuMemlonlHODuqw7EpD5UcbQOHARKrEnZCSee5N77mfz4XK7yS3phDUDZCU8UQt9ZAqaSW9dFIcAvpDu8KV15gZCsOgSHOZBYmzFliC2eBnKWB1kweuRpa2wIZCNrFvp8oWZBOdzVoFQj2GpMCR3xZAAZDZD';
	      $pageId = '910396765677324';
          $instagramAccountId = '17841400607443892';
          $endpoint ='https://graph.facebook.com/v5.0/'.$instagramAccountId;
		  $igParams = array(
			'fields' => 'business_discovery.username(' . $username . '){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{like_count,comments_count,media_url,permalink,media_type,caption}}',
			'access_token' => $accessToken
		);
	
		$endpoint .= '?' . http_build_query( $igParams );
		$client = new Client();
		$presponse = $client-> get($endpoint);
             return  json_decode($presponse->getBody(), true);

		} catch (\Exception $e) {
					return 1;
		}
	}
}
