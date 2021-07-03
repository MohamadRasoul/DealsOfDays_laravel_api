<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferHasReview
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	public $offerId;

	/**
	 * Create a new event instance.
	 *
	 * @param $offer
	 */
	public function __construct($offerId)
	{
		$this->offerId = $offerId;
	}

}
