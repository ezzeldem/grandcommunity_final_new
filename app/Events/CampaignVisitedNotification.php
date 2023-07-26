<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CampaignVisitedNotification implements ShouldBroadcast
{
    public $influenceName;
    public $campaignName;
    public $notify;
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($influenceName,$campaignName,$notify)
    {
        $this->notify = $notify;
        $this->campaignName = $campaignName;
        $this->influenceName= $influenceName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('campaignvisit');
    }


    public function broadcastAs(){
        return "visit.campaign";
    }
}
