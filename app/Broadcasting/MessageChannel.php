<?php

namespace App\Broadcasting;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;

class MessageChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, $id): array|bool
    {
        return $user->id == $id;
    }
}
