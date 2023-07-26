<?php

namespace App\Http\Controllers;

use App\Events\CampaignVisitedNotification;
use App\Models\User;
use App\Models\Campaign;
use App\Events\NotifyEvent;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use App\Notifications\NotifyOwner;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MessageNotification;
use App\Repository\Interfaces\NotificationInterface;

class NotificationController extends Controller
{
    protected $notification = null;

    // UserRepositoryInterface is the interface
    public function __construct(NotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    public function getNotifications()
    {
        return $this->notification->getNotifications();
    }
}
