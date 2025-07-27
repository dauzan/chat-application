<?php

namespace App\Listeners;

use App\Events\ChatCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\ChatNotification;

class SendChatCreatedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChatCreated $event): void
    {
        foreach(user::whereNot('id', $event->chat->user_id)->cursor() as $user) {
            $user->notify(new ChatNotification($event->chat));
        }
    }
}
