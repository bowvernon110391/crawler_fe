<?php

namespace App\Listeners;

use App\Events\CrawlingJobCreated;
use App\Jobs\ProcessCrawlingJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SpawnCrawler implements ShouldQueue
{
    use InteractsWithQueue;

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
     * @param  App\Events\CrawlingJobCreated  $event
     * @return void
     */
    public function handle(CrawlingJobCreated $event)
    {
        // simply log shit?
        logger('[SpawnCrawler] a crawling job was created!', ['event' => $event]);
        ProcessCrawlingJob::dispatch($event->crawlingJob);
    }
}
