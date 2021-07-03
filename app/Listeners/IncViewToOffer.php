<?php

namespace App\Listeners;

use App\Events\ShowOffer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncViewToOffer
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
     * @param  ShowOffer  $event
     * @return void
     */
    public function handle($event)
    {
        $event->offer->increment('views');
        //$event->offer->category->increment('views');

    }
}
