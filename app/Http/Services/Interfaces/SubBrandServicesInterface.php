<?php

namespace App\Http\Services\Interfaces;

interface SubBrandServicesInterface
{
    public function all();

    public function getSubBrands();

    public function store($request);

    public function edit($subBrand,$request);

    public function update($request, $subBrand);

    public function createSubBrandBranches($request, $subBrand);

    public function updateSubBrandBranches($request, $subBrand);

    public function export($request);
}
