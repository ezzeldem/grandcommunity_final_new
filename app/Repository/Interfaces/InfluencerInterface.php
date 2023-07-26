<?php

namespace App\Repository\Interfaces;


interface InfluencerInterface
{
    public function index();
    public function create();
    public function regenerateCodes($id);
    public function generateCodes($influencer);
    public function store($request);
    public function createUser($request);
    public function socialScrap($influencer_data);
    public function edit($influence);
    public function update( $request,  $influence);
    public function getInfluencer($request);
    public function getInfluencerdata();
    public function UpdateInfluencerdata();
    public function getNationalities();
    public function getCountries();
    public function getGovernorate();
    public function getBrand();
    public function getStatus();
    public function destroy($influence);
    public function import();
    public function export($request);
    public function delete_all($request);
    public function edit_all($request);
    public function AddInflue_to_group($request);
    public function addGroups($groups, $influe, $brand_id,$country);
    public function restore_all($request);
    public function restore_influ_dislikes($request);
    public function delete_fav_all($request);
    public function getCountryState($id);
    public function getCityState($id);
    public function statictics();
}
