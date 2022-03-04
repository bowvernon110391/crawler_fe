<?php

namespace App\Jobs;

use App\Models\CrawlingJob;
use App\Services\CrawlingJobService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class ProcessCrawlingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // the job definition
    protected $crawlingJob;
    // timeout? for safety, set it at 30 minutes
    public $timeout = 1800;
    // force fail after timeout
    public $failOnTimeout = true;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CrawlingJob $job)
    {
        $this->crawlingJob = $job;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CrawlingJobService $service)
    {
        // do something
        logger("[ProcessCrawlingJob]: Processing crawling job", ['job' => $this->crawlingJob]);

        // mark status
        $service->update($this->crawlingJob, ['status' => 'PROCESSING'], null);
        
        sleep(30);

        $service->update($this->crawlingJob, ['status' => 'DONE'], null);
    }

    /**
     * Some middleware to prevent job overlapping
     */
    public function middleware() {
        return [
            // no release for duplicates, directly drop
            (new WithoutOverlapping($this->crawlingJob->id))->dontRelease()
        ];
    }
}
