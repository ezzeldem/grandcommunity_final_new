<?php

namespace App\Repository\Interfaces;

interface GroupListInterFace
{
     public function show($id);
     public function create_groups($request);
     public function delete_all($request);
     public function groupListBrand();
     public function deleteInflueGroup($request);
     public function deleteDislikeInflueGroup($request);

}
