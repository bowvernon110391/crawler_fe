<?php

namespace App\Listeners;

use App\Events\CrawlingJobStarted;
use App\Models\CrawlingJob;
use App\Services\CrawlingJobService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Another sync listener to update batch info
 * on a CrawlingJob
 */
class UpdateCrawlingJobBatch
{
    protected $svc;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CrawlingJobService $svc)
    {
        $this->svc = $svc;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CrawlingJobStarted  $event
     * @return void
     */
    public function handle(CrawlingJobStarted $event)
    {
        logger("[UpdateCrawlingJobBatch]: updating job batch data");
        $this->svc->update(
            $event->crawlingJob,
            [
                'batch_id' => $event->batch->id
            ],
            null
        );
    }
}
