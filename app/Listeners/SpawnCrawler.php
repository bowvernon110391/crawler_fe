<?php

namespace App\Listeners;

use App\Events\CrawlingJobCreated;
use App\Events\CrawlingJobProgress;
use App\Events\CrawlingJobStarted;
use App\Jobs\ProcessCrawlingJob;
use App\Services\CrawlingJobService;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

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
    }

    /**
     * Handle the event.
     *
     * @param  App\Events\CrawlingJobCreated  $event
     * @return void
     */
    public function handle(CrawlingJobCreated $ev)
    {
        // simply log shit?
        logger('[SpawnCrawler] a crawling job was created!', ['event' => $ev]);
        
        // now we batch jobs, produce crawler for each keyword
        $jobs = array_map(fn($k) => new ProcessCrawlingJob($ev->crawlingJob, $k), $ev->crawlingJob->keywords);

        // dispatch them
        $batch = Bus::batch($jobs)
        // WHEN SUCCESSFUL
        ->then(function (Batch $batch) {
            logger("-> Batch[{$batch->id}] COMPLETED SUCCESSFULLY!");
            // TODO: MARK JOB AS DONE HERE!!!
        })
        // WHEN ERROR
        ->catch(function (Batch $batch, Throwable $ex) {
            Log::error("-> Batch[{$batch->id}] FAILED: {$ex->getMessage()}");
            // TODO: MARK ERROR HERE, POSSIBLY WITH EXPLANATION?
        })
        // ALWAYS EXECUTED
        ->finally(function (Batch $batch) use($ev) {
            logger("-> Batch[{$batch->id}] FINISHED!");
            // TODO: ADD CLEANP CODE HERE
            // always update status no matter if we fail or succeed
            CrawlingJobProgress::dispatch($ev->crawlingJob);
        })
        // ->allowFailures()
        ->dispatch();
        
        // update status + batch data
        logger("-> Batch[{$batch->id}] CREATED.");
        CrawlingJobStarted::dispatch($ev->crawlingJob, $batch);
    }
}
