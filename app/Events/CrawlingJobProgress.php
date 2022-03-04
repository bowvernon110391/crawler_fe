<?php

namespace App\Events;

use App\Models\CrawlingJob;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CrawlingJobProgress
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $crawlingJob;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CrawlingJob $crawlingJob)
    {
        $this->crawlingJob = $crawlingJob;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('job.' . $this->crawlingJob->id);
    }
}
