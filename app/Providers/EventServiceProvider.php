<?php

namespace App\Providers;

use App\Events\MessageCreated;
use App\Listeners\LoggingListener;
use App\Listeners\NewMessageNotification;
use App\Models\Product\Urun;
use App\Models\ServiceComment;
use App\Models\ServiceCompanyComment;
use App\Observers\ServiceCommentObserver;
use App\Observers\ServiceCompanyCommentObserver;
use App\Observers\UrunObserver;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        MessageLogged::class => [
            LoggingListener::class
        ],
        MessageCreated::class => [
            NewMessageNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        ServiceComment::observe(ServiceCommentObserver::class);
        ServiceCompanyComment::observe(ServiceCompanyCommentObserver::class);
    }
}
