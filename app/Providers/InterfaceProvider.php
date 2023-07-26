<?php

namespace App\Providers;



use App\Http\Services\SubBrandServices;
use App\Repository\GroupListRepository;
use App\Repository\SubBrandsRepository;
use Illuminate\Support\ServiceProvider;
use App\Http\Services\Eloquent\Campaign;
use App\Repository\InfluencerRepository;
use App\Repository\NotificationRepository;
use App\Repository\Interfaces\GroupListInterFace;
use App\Repository\Interfaces\InfluencerInterface;
use App\Http\Services\Interfaces\CampaignInterface;
use App\Repository\Interfaces\NotificationInterface;
use App\Http\Services\Interfaces\SubBrandServicesInterface;
use App\Repository\Interfaces\SubBrandsRepositoryInterface;

class InterfaceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationInterface::class,NotificationRepository::class);
        $this->app->bind(CampaignInterface::class,Campaign::class);
        $this->app->bind(GroupListInterFace::class,GroupListRepository::class);
        $this->app->bind(SubBrandServicesInterface::class,SubBrandServices::class);
        $this->app->bind(SubBrandsRepositoryInterface::class,SubBrandsRepository::class);
        $this->app->bind(InfluencerInterface::class,InfluencerRepository::class);


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
