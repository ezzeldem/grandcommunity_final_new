<?php
namespace App\Repository;
/**
 * Plan Repository class
 */
class StaticDataInfluencerRepository
{
    /**
     * Get a list of all plans
     *
     * @return array  Array containing list of all plans
     */
    public function ethinkCategory()
    {
        if(\request()->header('Accept-Language') == 'ar')
             return [["id"=>true,"title"=>"متحضر"],["id"=>2,"title"=>"بدوى"]];
         else
              return [["id"=>true,"title"=>"Open-minded"],["id"=>2,"title"=>"Conservative"]];
    }


    public function SortBY()
    {
        if(\request()->header('Accept-Language') == 'ar')
             return [["key"=>"username","title"=>"اسم المستخدم"],["key"=>"followers","title"=>"المتابعين"],
             ["key"=>"following","title"=>"تابع"],["key"=>"uploads","title"=>"رفع"],
             ["key"=>"engagement_average_rate","title"=>"معدل التفاعل"]
            ];
         else
                return [["key"=>"username","title"=>"Username"],["key"=>"followers","title"=>"Followers"],
                ["key"=>"following","title"=>"Following"],["key"=>"uploads","title"=>"Uploads"],
                ["key"=>"engagement_average_rate","title"=>"engagement average rate"]
                ];
    }
    public function speak()
    {
        return [
            1 => 'Yes',
            2 => 'No',
        ];
    }

    public function getTypePhone(){
        return [
            ["id"=>1,"title"=>"Call"],
            ["id"=>2,"title"=>"Office"],
            ["id"=>3,"title"=>"WhatsApp"],
        ];
    }
   public function getfollowersType(){
       return [
        ["id"=>1,"name"=>"SnapChat"],
        ["id"=>2,"name"=>"Instagram"],
        ["id"=>3,"name"=>"FaceBook"],
       ];
    }
    public function face()
    {
        return [
            1 => 'No',
            2 => 'Yes',
        ];
    }
    public function hijab()
    {
        return [
            1 => 'No',
            2 => 'Yes',
        ];
    }



    public function fake()
    {
        return [
            1 => 'No',
            2 => 'Yes',
        ];
    }

    public function share()
    {
        return [
            1 => 'No',
            2 => 'Yes',
        ];
    }


    public function socialClass()
    {

        return [["id"=>1,"title"=>"Class A"],["id"=>2,"title"=>"Class B"],["id"=>3,"title"=>"Class C"]];

    }


    public function recommendedAnyCamp()
    {
        return [["id"=>1,"title"=>"Yes"],["id"=>2,"title"=>"No"]];
    }




    public function accountType()
    {
        if(\request()->header('Accept-Language') == 'ar')
               return [["id"=>1,"title"=>"عام"],["id"=>2,"title"=>"خاص بالمنتجات"],["id"=>3,"title"=>"عام"]];
        else
               return [["id"=>1,"title"=>"Personal"],["id"=>2,"title"=>"Product-based"],["id"=>3,"title"=>"General"]];
    }

    public function citizenStatus()
    {
        if(\request()->header('Accept-Language') == 'ar')
               return [["id"=>1,"title"=>"مواطن محلي "],["id"=>2,"title"=>"مغترب"]];
         else
              return [["id"=>1,"title"=>"Local"],["id"=>2,"title"=>"Expat"]];
    }

    public function socialCoverage()
    {
        if(\request()->header('Accept-Language') == 'ar')
               return [["key"=>"instagram","value"=>"انستقرام"], ["key"=>"snapchat","value"=>"سناب شات"],["key"=>"tiktok","value"=>"تك توك"],["key"=>"twitter","value"=>"تويتر"],["key"=>"facebook","value"=>"فيس بوك"]];
        else
             return [["key"=>"instagram","value"=>"Instagram"],["key"=>"snapchat","value"=>"Snapchat"],["key"=>"tiktok","value"=>"Tiktok"],["key"=>"twitter","value"=>"Twitter"],["key"=>"facebook","value"=>"Facebook"]];
    }

	public static function getInfluencerMartialStatus()
    {
		if(\request()->header('Accept-Language') == 'ar')
		    return [['id' => 1, 'name' => 'اعزب'],['id' => 2, 'name' => 'متزوج'],['id' => 3, 'name' => 'مطلق']];
			else
			return [['id' => 1, 'name' => 'single'],['id' => 2, 'name' => 'married'],['id' => 3, 'name' => 'divorced']];

    }



    public function rating()
    {
        return [
            1 => '★',
            2 => '★★',
            3 => '★★★',
            4 => '★★★★',
            5 => '★★★★★',
        ];
    }

    public function ratingArr()
    {
        return [["key"=>1,"value"=>'★'],["key"=>2,"value"=>'★★'],["key"=>3,"value"=>'★★★'],["key"=>4,"value"=>'★★★★'],["key"=>5,"value"=>'★★★★★'] ];

    }

    public function chatResponseSpeed()
    {
        return [["id"=>1,"title"=>"Fast"],["id"=>2,"title"=>"Normal"],["id"=>3,"title"=>"Late"]];
    }

    public function behavior()
    {

        return [["id"=>1,"title"=>"Good"],["id"=>2,"title"=>"Bad"]];
    }



    public function coverageRating()
    {
        return [["id"=>1,"title"=>"Good"],["id"=>2,"title"=>"Bad"],["id"=>3,"title"=>"Wonderfull"]];

    }

}
