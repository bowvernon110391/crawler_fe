<?php

namespace App\Listeners;

use App\Events\CrawlingJobCreated;
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
            // $this->service->update($jobdef, [ 'status' => 'DONE' ], null);
        })
        // WHEN ERROR
        ->catch(function (Batch $batch, Throwable $ex) {
            Log::error("-> Batch[{$batch->id}] FAILED: {$ex->getMessage()}");
            // TODO: MARK ERROR HERE, POSSIBLY WITH EXPLANATION?
            // $this->service->update($jobdef, [ 'status' => 'ERROR' ], null);
        })
        // ALWAYS EXECUTED
        ->finally(function (Batch $batch) {
            logger("-> Batch[{$batch->id}] FINISHED!");
            // TODO: ADD CLEANP CODE HERE
        })
        ->dispatch();
        
        // update status + batch data
        logger("-> Batch[{$batch->id}] CREATED.");

        app()->make(CrawlingJobService::class)->update($ev->crawlingJob, [
            'status' => 'STARTED',
            'batch_id' => $batch->id
        ], null);
        /* $this->service->update($jobdef, [
            'status' => 'CREATED',
            'batch_id' => $batch->id
        ], null); */
    }
}
