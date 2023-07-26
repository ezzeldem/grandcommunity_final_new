<?php

namespace App\Http\Services\Interfaces;

interface CampaignInterface{

    public function getBrands();
    public function getCountries();
    public function getStates();
    public function getStateCities($id);
    public function getStatus();
    public function getSubBrands($id);
    public function getSubBrandBranches($id);
    public function createCampaign($data,$branch, $branchesWithCompliment);
    public function brandSecret($request);
    public function campaignCountryFavourite($campaign,$data);
    public function campaignInfluencers($data, $campaign);
    public function updateCampaign($request,$campaign);
    public function datatable($request);
    public function updateBrandAndSubBrandInfo($request);
    public function show($campaign);
    public function campaignLog($id);
    public function campaignLogAjax($request,$id);
	public function updateInfluencerStatus($request);
}
