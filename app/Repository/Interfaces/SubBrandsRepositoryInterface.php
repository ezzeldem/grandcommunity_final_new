<?php

namespace App\Repository\Interfaces;

interface SubBrandsRepositoryInterface
{
    public function getStatistics();

    public function getSubBrand();

    public function createSubBrand($inputs);

    public function editSubBrand($subBrand);

    public function updateSubBrand($inputs, $subBrand);
}
