<?php

namespace App\Events;

use App\User;
use App\GroupMessage;
use App\GroupMessageMember;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GroupCreated implements ShouldBroadcast 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $user;
    /**
     * Message details
     *
     * @var Message
     */
    public $group;
    // public $created_at;
    public $members;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, GroupMessage $group, $members)
    {
        $this->user = $user;
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
        return new Channel('groups1');
    }
}
