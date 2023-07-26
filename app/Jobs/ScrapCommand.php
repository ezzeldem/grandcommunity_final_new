<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Traits\SocialScrape\InstagramScrapeTrait;

class ScrapCommand implements ShouldQueue
{
    public $influencers;
    public $scrap;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,InstagramScrapeTrait;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($influencers)
    {
        $this->influencers = $influencers;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       return $this->scrapInstagram($this->influencers);
    }
}
