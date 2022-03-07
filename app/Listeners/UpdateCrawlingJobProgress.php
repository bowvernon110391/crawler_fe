<?php

namespace App\Listeners;

use App\Events\CrawlingJobProgress;
use App\Models\CrawlingJob;
use App\Services\CrawlingJobService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * For this listener we should run it in sync 
 * (not using queue, because crawling job takes a long time)
 */
class UpdateCrawlingJobProgress /* implements ShouldQueue */
{
    use InteractsWithQueue;

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
     * @param  App\Events\CrawlingJobProgress  $ev
     * @return void
     */
    public function handle(CrawlingJobProgress $event)
    {
        if ($event->crawlingJob->batch->canceled()) {
            // event canceled!
            logger("[UpdateCrawlingJobProgress]: job is canceled!");
            $this->svc->update($event->crawlingJob, [ 'status' => 'CANCELLED' ], null);
        } else if ($event->crawlingJob->batch->finished()) {
            // mark done
            logger("[UpdateCrawlingJobProgress]: job done!");
            $this->svc->update($event->crawlingJob, [ 'status' => 'DONE' ], null);
        } else {
            // update progress
            logger("[UpdateCrawlingJobProgress]: progress {$event->crawlingJob->batch->progress()}%...");
            $this->svc->update($event->crawlingJob, [ 'status' => "PROCESSING {$event->crawlingJob->batch->progress()}" ], null);
        }
    }
}
