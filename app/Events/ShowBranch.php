<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShowBranch
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $branch;

	/**
	 * Create a new event instance.
	 *
	 * @param $branch
	 */
    public function __construct($branch)
    {
        $this->branch = $branch;
    }

}
