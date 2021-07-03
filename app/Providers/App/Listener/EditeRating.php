<?php

namespace App\Providers\App\Listener;

use App\Providers\OfferHasNewRating;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EditeRating
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
     * @param  OfferHasNewRating  $event
     * @return void
     */
    public function handle(OfferHasNewRating $event)
    {
        //
    }
}
