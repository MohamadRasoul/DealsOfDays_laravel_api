<?php

namespace App\Providers;

use App\Events\ShowBranch;
use App\Events\ShowOffer;
use App\Events\OfferHasReview;
use App\Listeners\IncViewToBranch;
use App\Listeners\IncViewToOffer;
use App\Listeners\EditeRating;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ShowBranch::class => [
            IncViewToBranch::class,
        ],
        ShowOffer::class => [
            IncViewToOffer::class,
        ],
	    OfferHasReview::class => [
            EditeRating::class,
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
