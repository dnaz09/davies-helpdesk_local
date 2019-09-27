<?php

namespace App\Events;

use App\GroupMessageMessage;
use App\GroupMessage;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GroupMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @return user
     * @return gmessage
     * Create a new event instance.
     *
     * @return void
     */
    public $user;
    public $gmessage;
    public $group;
    public $members;
    public function __construct(User $user, GroupMessageMessage $gmessage, GroupMessage $group, $members)
    {
        $this->user = $user;
        $this->gmessage = $gmessage;
        $this->group = $group;
        $this->members = $members;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('groupchat');
    }
}
