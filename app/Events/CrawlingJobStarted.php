<?php

namespace App\Events;

use App\Models\CrawlingJob;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CrawlingJobStarted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $crawlingJob;
    public $batch;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CrawlingJob $crawlingJob, Batch $batch)
    {
        $this->crawlingJob = $crawlingJob;
        $this->batch = $batch;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
