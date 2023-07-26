<?php
namespace App\Http\Services;
use App\Http\Services\Interfaces\CampaignInterface;

class CampaignService{

    private $Model;

    public function __construct(CampaignInterface $customModel) {
        $this->Model = $customModel;
    }

    /** get Brands
     * @return mixed
     */
    public function getBrands() {
        return $this->Model->getBrands();
    }

    /** get Countries
     * @return mixed
     */
    public function getCountries(){
        return $this->Model->getCountries();
    }

    /** get Country States
     * @return mixed
     */
    public function getStates(){
        return $this->Model->getStates();
    }

    /** get State Cities
     * @param $id
     * @return mixed
     */
    public function getStateCities($id){
        return $this->Model->getStateCities($id);
    }

    /** get Campaign Status
     * @return mixed
     */
    public function getStatus(){
        return $this->Model->getStatus();
    }

    /** get Sub Brands
     * @return mixed
     */
    public function getSubBrands($id){
        return $this->Model->getSubBrands($id);
    }

    /** get SubBrands Branches
     * @param $id
     * @return mixed
     */
    public function getSubBrandBranches($id){
        return $this->Model->getSubBrandBranches($id);
    }

    /** store Campaign
     * @param $data
     * @return mixed
     */
    public function createCampaign($data,$branch, $branchesWithCompliment = []){
        return $this->Model->createCampaign($data,$branch, $branchesWithCompliment);
    }

    /**
     * @param $campaign
     * @param $data
     * @return mixed
     * store campaign Country Favourite
     */
    public function campaignCountryFavourite($campaign,$data){
        return $this->Model->campaignCountryFavourite($campaign,$data);
    }

    /**campaign Influencers
     * @param $data
     * @param $campaign
     */
    public function campaignInfluencers($data, $campaign){
        return $this->Model->campaignCountryFavourite($data, $campaign);
    }

    /**
     * create brand secrets with permissions
     * @param $request
     * @return mixed
     */
    public function brandSecret($request){
        return $this->Model->brandSecret($request);
    }

    /**
     * update campaign
     * @param $request
     * @param $campaign
     * @return mixed
     */
    public function updateCampaign($request,$campaign){
        return $this->Model->updateCampaign($request,$campaign);
    }

    public function campaignLog($id){
        return $this->Model->campaignLog($id);
    }

    public function campaignLogAjax($request,$id){
        return $this->Model->campaignLogAjax($request,$id);
    }


    /** datatable
     * @param $request
     * @return mixed
     */
    public function datatable($request){
        return $this->Model->datatable($request);
    }

    /** update Brand And ubBrand Info (phone, whatsapp)
     * @param $request
     * @return mixed
     */
    public function updateBrandAndSubBrandInfo($request){
        return $this->Model->updateBrandAndSubBrandInfo($request);
    }


	public function updateInfluencerStatus($request){
		return $this->Model->updateInfluencerStatus($request);
	}

    /**show
     * @param $campaign
     * @return mixed
     */
    public function show($campaign){
        return $this->Model->show($campaign);
    }

    public static function campaignObjectives(){
        $arr[]=(object)['dataoption'=>'data-one',"id"=>1,"title"=>"Application","no_of_coverage"=>2 , "names"=>[['dataoption'=>'data-one','random'=>1,'id'=>3,'title'=>'GiftCoverage'],['dataoption'=>'data-one','random'=>2,'id'=>1,'title'=>"ApplicationCoverage"]]];
        $arr[]=(object)['dataoption'=>'data-two',"id"=>2,"title"=>"Share","no_of_coverage"=>1 , "names"=>[['dataoption'=>'data-two','random'=>3,'id'=>1,'title'=>'Coverage']]];
        $arr[]=(object)['dataoption'=>'data-three',"id"=>3,"title"=>"Event","no_of_coverage"=> 2, "names"=>[['dataoption'=>'data-three','random'=>4,'id'=>2,'title'=>'InvitationCoverage'], ['dataoption'=>'data-three', 'random'=>5,'id'=>1,'title'=>'VisitCoverage']]];
        $arr[]=(object)['dataoption'=>'data-four',"id"=>4,"title"=>"Visit","no_of_coverage"=>1 ,"names"=>[['dataoption'=>'data-four','random'=>6,'id'=>1,'title'=>'Coverage']]];
        $arr[]=(object)['dataoption'=>'data-five',"id"=>5,"title"=>"Delivery","no_of_coverage"=>1,"names"=>[['dataoption'=>'data-five','random'=>7,'id'=>1,'title'=>'Coverage']]];
               return $arr;
      }

      public static function drawSocailObjective($key = "instagram"){
        $postType =[
          (object)["id"=>1,"name"=>"image"],
          (object)["id"=>2,"name"=>"video"]
        ];
        if(in_array($key,["instagram","facebook"])){
          $arr[]=(object)["key"=>"post","value"=>"posts","post_type"=>$postType];
          $arr[]=(object)["key"=>"reel","value"=>"reels","post_type"=>$postType];
        }
        if(in_array($key,["instagram","facebook","snapchat","tiktok"])){
           $arr[]=(object)["key"=>"story","value"=>"story","post_type"=>$postType];
        }
        if(in_array($key,["youtube","tiktok"])){
               $arr[]=(object)["key"=>"video","value"=>"video"];
        }
               return $arr;
    }
}
