<?php

namespace App\Listeners;

use App\Events\MessageCreated;
use App\Notifications\User\NewMessageCreatedNotification;

class NewMessageNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param MessageCreated $event
     * @return void
     */
    public function handle(MessageCreated $event)
    {
        $event->message->to->notify(new NewMessageCreatedNotification($event->message));
    }
}
