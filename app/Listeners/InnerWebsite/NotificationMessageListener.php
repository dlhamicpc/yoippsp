<?php

namespace App\Listeners\InnerWebsite;

use App\Events\InnerWebsite\NotificationMessageEvent;
use App\Models\NotificationMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationMessageListener
{
    /**
     * Handle the event.
     *
     * @param  NotificationMessageEvent  $event
     * @return void
     */
    public function handle(NotificationMessageEvent $event)
    {
        NotificationMessage::create($event->data);
    }
}
