<?php

namespace App\Listeners;

use App\Offer;
use App\Providers\OfferHasNewReview;
use App\Review;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EditeRating
{
 
    /**
     * Handle the event.
     *
     * @param  OfferHasNewReview  $event
     * @return void
     */
    public function handle($event)
    {
        $offer = Offer::where('id', $event->offerId)->firstOrFail();
        
	    $offer->rating = Review::where('offer_id' ,'=' ,$event->offerId)->avg('rating');
	    $offer->save();

    }
}
