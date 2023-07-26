<?php


namespace App\Http\Traits\SocialScrape;


use App\Models\Influencer;
use App\Models\LogInstagram;
use App\Models\MediaInstagram;
use App\Models\ScrapeInstagram;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Instagram\Api;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

trait CompareTrait
{


    public function InstaCompare($request){

        $username_one = $request->user_one;
        $username_two = $request->user_two;
        if (Influencer::where('insta_uname', '=', $username_one)->exists() && Influencer::where('insta_uname', '=', $username_two)->exists()) {
            $data_userone = Influencer::where('insta_uname', '=', $username_one)->first();
            $data_usertwo = Influencer::where('insta_uname', '=', $username_two)->first();
            if($data_userone->instagram && $data_usertwo->instagram){
                $data_all = [];

                //Data use one
                $data_all['one']['data'] = $data_userone->instagram->toArray();
                $data_all['one']['data']['insta_image'] = "data:image/x-icon;base64,".base64_encode(file_get_contents($data_all['one']['data']['insta_image']));
                $data_all['one']['data']['private'] = false;
                $data_all['one']['media'] = $data_userone->instagram->instamedias->toArray();
                $data_all['one']['log'] = $data_userone->instagram->instalogs->toArray();

                //Data user two
                $data_all['two']['data'] = $data_usertwo->instagram->toArray();
                $data_all['two']['data']['insta_image'] = "data:image/x-icon;base64,".base64_encode(file_get_contents($data_all['two']['data']['insta_image']));
                $data_all['two']['media'] = $data_usertwo->instagram->instamedias->toArray();
                $data_all['two']['data']['private'] = false;
                $data_all['two']['log'] = $data_usertwo->instagram->instalogs->toArray();

                $data_all['exist'] = true;

                return $data_all;
            }
        }else{
            $data_all['exist'] = false;
            $data_all = [];
            $data_user_one = $this->ScrapeData($username_one);
            $data_user_two = $this->ScrapeData($username_two);

            $data_all['one']['data']['avg_comments'] = $data_user_one->avg_comments;
            $data_all['one']['data']['avg_likes'] = $data_user_one->avg_likes;
            $data_all['one']['data']['engagement_average_rate'] = $data_user_one->average_engagement;
            $data_all['one']['data']['insta_username'] = $data_user_one->getUserName();
            $data_all['one']['data']['name'] = $data_user_one->getFullName();
            $data_all['one']['data']['total_comments'] = array_sum($data_user_one->comments);
            $data_all['one']['data']['total_likes'] = array_sum($data_user_one->likes);
            $data_all['one']['data']['followers'] = $data_user_one->getFollowers();
            $data_all['one']['data']['following'] = $data_user_one->getFollowing();
            $data_all['one']['data']['private'] = $data_user_one->isPrivate();
            $data_all['one']['media']= $data_user_one->medias_data;
            $data_all['one']['data']['insta_image'] = "data:image/x-icon;base64,".base64_encode(file_get_contents($data_user_one->getProfilePicture()));

            $data_all['two']['data']['avg_comments'] = $data_user_two->avg_comments;
            $data_all['two']['data']['avg_likes'] = $data_user_two->avg_likes;
            $data_all['two']['data']['engagement_average_rate'] = $data_user_two->average_engagement;
            $data_all['two']['data']['insta_username'] = $data_user_two->getUserName();
            $data_all['two']['data']['name'] = $data_user_two->getFullName();
            $data_all['two']['data']['total_comments'] = array_sum($data_user_two->comments);
            $data_all['two']['data']['total_likes'] = array_sum($data_user_two->likes);
            $data_all['two']['data']['followers'] = $data_user_two->getFollowers();
            $data_all['two']['data']['following'] = $data_user_two->getFollowing();
            $data_all['two']['data']['private'] = $data_user_two->isPrivate();
            $data_all['two']['media']= $data_user_two->medias_data;
            $data_all['two']['data']['insta_image'] = "data:image/x-icon;base64,".base64_encode(file_get_contents($data_user_two->getProfilePicture()));



            return $data_all;

        }
    }

    public function ScrapeData($user_name){
        try{
            $average_engagement=[];
            $likes_array=[];
            $comments_array=[];
            $medias_data=[];

            $cachePool = new FilesystemAdapter('Instagram', 0, __DIR__ . '/../cache');
            $api = new Api($cachePool);
            $api->login('yasseromar206', '123456HIMA'); // mandatory

            $profile = $api->getProfile($user_name);

            if(!$profile->isPrivate()){
                foreach ($profile->getMedias() as $key=>$media)
                    {
                        $media_array = $media->toArray();
                        $medias_data[$key]['video_id'] = $media_array['shortcode'];
                        $medias_data[$key]['id'] = $media_array['id'];
                        $likes_array[$media->getShortCode()] = $media->getLikes();
                        $comments_array[$media->getShortCode()] = $media->getComments();
                        $average_engagement[$media->getShortCode()]=nr(($media->getLikes() + $media->getComments()) / $profile->getFollowers() * 100, 2);
                    }
            }

            $profile->average_engagement=count($likes_array) > 0 ? number_format(array_sum($average_engagement) / count($average_engagement), 2) : 0;
            $profile->avg_comments = count($comments_array) > 0 ? round(array_sum($comments_array) / count($comments_array)) : 0;
            $profile->avg_likes = count($likes_array) > 0 ? round(array_sum($likes_array) / count($likes_array)) : 0;
            $profile->comments = $comments_array ? $comments_array : [];
            $profile->likes = $likes_array ? $likes_array : [];
            $profile->medias_data = $medias_data ? $medias_data : [];

            return $profile;

        }catch (\Exception $ex){
            return response()->json(['status'=>false],500);
        }
    }


}
