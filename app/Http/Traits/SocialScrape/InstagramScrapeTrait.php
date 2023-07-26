<?php


namespace App\Http\Traits\SocialScrape;


use App\Models\LogInstagram;
use App\Models\Influencer;
use App\Models\MediaInstagram;
use App\Models\ScrapeInstagram;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Instagram\Api;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as gRequest;
use App\Http\Resources\API\Brand_dashboard\InstagramScraperResource;
use Illuminate\Support\Facades\Log;

trait InstagramScrapeTrait
{
	public function scrapInstagram($influencer)
	{
		$influencerInstagram  = isset($influencer->instagram) ? $influencer->instagram : (object)[];
		$settingCheckDate = Carbon::now()->subDays(10)->toDateString();
		if (empty($influencerInstagram) ||  empty($influencerInstagram->last_check_date) || (Carbon::parse($influencerInstagram->last_check_date)->format("Y-m-d") < $settingCheckDate)) {
			$presponse = $this->CallInstagramApi(trim($influencer->insta_uname));
			$userData = ($presponse && $presponse != '1' && !empty($presponse['user'])) ? $presponse['user'] : [];
			if (!empty($userData)) {
				$userData['influe_brand_id'] = $influencer->id;
				$userData['type'] = 1;
				$influencerInstagram = $this->InsertData($userData);
			}
		}
		return new InstagramScraperResource($influencerInstagram);
	}

	public function scrapInstagramById($influencer)
	{
		$presponse = $this->CallInstagramByIDApi($influencer->insta_id);
		$userData = ($presponse && $presponse != '1' && !empty($presponse['user'])) ? $presponse['user'] : [];
		if (!empty($userData)) {
			$userData['influe_brand_id'] = $influencer->id;
			$userData['type'] = 1;
			$influencerInstagram = $this->InsertData($userData);
		}
	}


	public function InsertData($userData)
	{
		try {
			$data = [];
			$likes_array = [];
			$comments_array = [];
			$hashtags_array = [];
			$mentions_array = [];
			$engagement_rate_array = [];
			$details = [];
			$media_arr = [];
			$reel_arr = [];
			$reel_updated_code_arr = [];

			$data['influe_brand_id'] = $userData['influe_brand_id'];
			$data['type'] = $userData['type'];
			$data['insta_id'] = $userData['pk'];
			$data['insta_username'] = $userData['username'];
			$data['name'] = $userData['full_name'];
			$data['bio']  = $userData['biography'];
			$data['followers'] = $userData['follower_count'];
			$data['following'] = $userData['following_count'];
			$data['uploads'] = $userData['media_count'];
			$data['is_private'] = $userData['is_private'];
			$data['is_verified'] = $userData['is_verified'];
			$data['insta_image'] = $userData["profile_pic_url"];
			$data['last_check_date'] = Carbon::now();

			if ($data['is_private']) {
				$data['average_engagement_rate'] = 0;
				$data['details'] = '';
			} else {
				$postresponse = $this->CallInstagramPostApi($data['insta_id']);
				$media_response = $postresponse['data']['user']['edge_owner_to_timeline_media']['edges'];
				if ($media_response && !empty($media_response)) {

					$media_response = array_slice((array)$media_response, 0, 12);
					$post_code_arr = [];
					foreach ($media_response as $key => $item) {
						$media = $item['node'];
						$caption = isset($media['edge_media_to_caption']['edges'][0]['node']['text']) ? $media['edge_media_to_caption']['edges'][0]['node']['text'] : "";
						$media_arr[$key]['media_id'] = $media["id"];
						$media_arr[$key]['shortcode'] = $media["shortcode"];
						$media_arr[$key]['caption'] = $caption;
						$media_arr[$key]['likes'] = (int)($media["edge_media_preview_like"]["count"] > 0) ? $media["edge_media_preview_like"]["count"] : 0;
						$media_arr[$key]['comments'] = (int)$media["edge_media_to_comment"]["count"];
						$media_arr[$key]['media_type'] = strtoupper(explode('Graph', $media["__typename"])[1]);
						$media_arr[$key]['type'] = $media['is_video'] ? 1 : 0;
						$post_code_arr[] = $media["shortcode"];


						$likes_array[$media["shortcode"]] = $media["edge_media_preview_like"]["count"];
						$comments_array[$media["shortcode"]] = $media["edge_media_to_comment"]["count"];
						$followers = ($data['followers'] > 0) ? $data['followers'] : 1;
						$engagement_rate_array[$media["shortcode"]] = nr(($media["edge_media_preview_like"]["count"] +  $media["edge_media_to_comment"]["count"]) / $followers * 100, 2);

						$hashtags = $this->get_hashtags($caption);
						foreach ($hashtags as $hashtag) {
							if (!isset($hashtags_array[$hashtag])) {
								$hashtags_array[$hashtag] = 1;
							} else {
								$hashtags_array[$hashtag]++;
							}
						}
						$mentions = $this->get_mentions($caption);
						foreach ($mentions as $mention) {
							if (!isset($mentions_array[$mention])) {
								$mentions_array[$mention] = 1;
							} else {
								$mentions_array[$mention]++;
							}
						}
					}
				}


				/** reels */
				$reelResponse = $this->CallInstagramReelsApi($data['insta_id']);
				$reels_response = $reelResponse['items'];
				$reel_code_arr = [];
				if ($reels_response && !empty($reels_response)) {
					$reels_response = array_slice((array)$reels_response, 0, 12);

					foreach ($reels_response as $reel_item) {
						$reel = $reel_item['media'];
						if (!empty($post_code_arr) && !in_array($reel["code"], $post_code_arr)) {
							$reel_arr[$key]['media_id'] = $reel["pk"];
							$reel_arr[$key]['shortcode'] = $reel["code"];
							$reel_arr[$key]['caption'] = isset($reel['caption']['text']) ? $reel['caption']['text'] : '';
							$reel_arr[$key]['likes'] = (int)($reel['like_count'] > 0) ? $reel['like_count'] :  0;
							$reel_arr[$key]['comments'] = (int)$reel['comment_count'];
							$reel_arr[$key]['media_type'] = ($reel['media_type'] == 2) ? 'VIDEO' : 'SIDECAR';
							$reel_arr[$key]['type'] = ($reel['media_type'] == 2) ? 1 : 0;
							$reel_arr[$key]['post_type'] = '["1"]';
						}
						$reel_code_arr[] = $reel["code"];
					}
				}
			}
			
			$data['engagement_average_rate'] = count($likes_array) > 0 ? number_format(array_sum($engagement_rate_array) / count($engagement_rate_array), 2) : 0;
			$data['total_likes'] = array_sum($likes_array);
			$data['total_comments'] = array_sum($comments_array);
			$data['avg_comments'] = count($comments_array) > 0 ? round($data['total_comments'] / count($comments_array)) : 0;
			$data['avg_likes'] = count($likes_array) > 0 ? round($data['total_likes'] / count($likes_array)) : 0;
			$details['top_hashtags'] = array_slice($hashtags_array, 0, 15);
			$details['top_mentions'] = array_slice($mentions_array, 0, 15);
			$data['details'] = json_encode($details);


			$insertData = ScrapeInstagram::updateOrCreate(['influe_brand_id' => $data['influe_brand_id'], 'type' => $data['type']], $data);

			if (count($media_arr) > 0) {
				MediaInstagram::where('instagram_id', $insertData->id)->delete();
				$post_arr = [];
				foreach ($media_arr as $item) {
					$post_reel_type = '["0"]';
					if (!empty($reel_code_arr) && in_array($item['shortcode'], $reel_code_arr))
						$post_reel_type = '["0","1"]';

					$post_arr[] = ['instagram_id' => $insertData->id, 'media_id' => $item['media_id'], 'shortcode' => $item['shortcode'], 'likes' => $item['likes'], 'comments' => $item['comments'], 'type' => $item['type'], 'caption' => $item['caption'], 'media_type' => $item['media_type'], 'post_reel_type' => $post_reel_type];
				}
				MediaInstagram::insert($post_arr);
			}

			if (count($reel_arr) > 0) {
				$reel_insert_arr = [];
				foreach ($reel_arr as $reel_item) {
					$post_reel_type = '["1"]';
					$reel_insert_arr[] = ['instagram_id' => $insertData->id, 'media_id' => $reel_item['media_id'], 'shortcode' => $reel_item['shortcode'], 'likes' => $reel_item['likes'], 'comments' => $reel_item['comments'], 'type' => $reel_item['type'], 'caption' => $reel_item['caption'], 'media_type' => $reel_item['media_type'], 'post_reel_type' => $post_reel_type];
				}
				MediaInstagram::insert($reel_insert_arr);
			}

			LogInstagram::create([
				'instagram_id' => $insertData->id,
				'followers' => $data['followers'],
				'following' => $data['following'],
				'uploads' => $data['uploads'],
				'instagram_username	' => $data['insta_username'],
				'engagement_average_rate' => $data['engagement_average_rate']
			]);

			return $insertData;
		} catch (\Exception $ex) {
			return response()->json(['status' => false], 500);
		}
	}


	public function CallInstagramApi($user_name)
	{
		try {
			$client = new Client();
			$presponse = $client->get('https://instagram-scraper-2022.p.rapidapi.com/ig/info_username/?user=' . $user_name, [
				'headers' => [
					"x-rapidapi-host" => 'instagram-scraper-2022.p.rapidapi.com',
					"x-rapidapi-key" => 'ad51d62d52msh403618c1113ce3ep1f1609jsn618d21b54d29'
				],
			]);

			return json_decode($presponse->getBody(), true);
		} catch (\Exception $e) {
			return 1;
		}
	}

	public function CallInstagramPostApi($insta_id)
	{
		try {
			$client = new Client();
			$presponse = $client->get('https://instagram-scraper-2022.p.rapidapi.com/ig/posts/?id_user=' . $insta_id, [
				'headers' => [
					"x-rapidapi-host" => 'instagram-scraper-2022.p.rapidapi.com',
					"x-rapidapi-key" => 'ad51d62d52msh403618c1113ce3ep1f1609jsn618d21b54d29'
				],
			]);
			return json_decode($presponse->getBody(), true);
		} catch (\Exception $e) {
			return 1;
		}
	}


	public function CallInstagramByIDApi($instaId)
	{

		try {
			$client = new Client();
			$presponse = $client->get('https://instagram-scraper-2022.p.rapidapi.com/ig/info/?id_user=' . $instaId, [
				'headers' => [
					"x-rapidapi-host" => 'instagram-scraper-2022.p.rapidapi.com',
					"x-rapidapi-key" => 'ad51d62d52msh403618c1113ce3ep1f1609jsn618d21b54d29'
				],
			]);

			return json_decode($presponse->getBody(), true);
		} catch (\Exception $e) {
			return 1;
		}
	}



	public function CallInstagramReelsApi($insta_id)
	{
		try {
			$client = new Client();
			$presponse = $client->get('https://instagram-scraper-2022.p.rapidapi.com/ig/reels_posts/?id_user=' . $insta_id, [
				'headers' => [
					"x-rapidapi-host" => 'instagram-scraper-2022.p.rapidapi.com',
					"x-rapidapi-key" => 'ad51d62d52msh403618c1113ce3ep1f1609jsn618d21b54d29'
				],
			]);

			return json_decode($presponse->getBody(), true);
		} catch (\Exception $e) {
			return 1;
		}
	}


	public function get_hashtags($string)
	{

		preg_match_all('/(?:#)([\p{L}\p{N}_](?:(?:[\p{L}\p{N}_]|(?:\.(?!\.))){0,28}(?:[\p{L}\p{N}_]))?)/u', $string, $array);


		return $array[1];
	}

	public function get_mentions($string)
	{

		preg_match_all('/(?:@)([\p{L}\p{N}_](?:(?:[\p{L}\p{N}_]|(?:\.(?!\.))){0,28}(?:[\p{L}\p{N}_]))?)/u', $string, $array);


		return $array[1];
	}
}