<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\InnerWebsite\NotificationMessageEvent;
use App\Listeners\InnerWebsite\NotificationMessageListener;

use App\Events\InnerWebsite\BillPaymentPostedEvent;
use App\Listeners\InnerWebsite\BillPaymentPostedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NotificationMessageEvent::class => [
            NotificationMessageListener::class,
        ],
        BillPaymentPostedEvent::class => [
            BillPaymentPostedListener::class,
        ],
        
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
