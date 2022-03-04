<?php

namespace App\Jobs;

use App\Models\CrawlingJob;
use App\Services\CrawlingJobService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class ProcessCrawlingJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // the job definition
    protected $crawlingJob;
    protected $keyword;
    // timeout? for safety, set it at 30 minutes
    public $timeout = 1800;
    // force fail after timeout
    public $failOnTimeout = true;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CrawlingJob $job, string $keyword)
    {
        $this->crawlingJob = $job;
        $this->keyword = $keyword;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CrawlingJobService $service)
    {
        // refresh model to throw error when it's deleted
        // $this->crawlingJob->refresh();  // will throw error when it's deleted

        // do something
        logger("[ProcessCrawlingJob]: Processing crawling job ({$this->crawlingJob->id}, {$this->keyword})", ['job' => $this->crawlingJob, 'keyword' => $this->keyword]);

        // mark status, possibly update progress too
        $service->update($this->crawlingJob, ['status' => 'PROCESSING'], null);
        
        // prevent unncessary work
        if ($this->batch()->cancelled()) {
            $service->update($this->crawlingJob, ['status', 'CANCELLED'], null);
            return;
        }

        // do some heavy work
        sleep(30);

        $service->update($this->crawlingJob, ['status' => "PROCESSING({$this->batch()->processedJobs()}/{$this->batch()->totalJobs})"], null);
        logger("[ProcessCrawlingJob]: -> Done crawling job ({$this->crawlingJob->id}, {$this->keyword})", ['job' => $this->crawlingJob, 'keyword' => $this->keyword]);
    }

    /**
     * Some middleware to prevent job overlapping
     */
    public function middleware() {
        return [
            // no release for duplicates, directly drop
            (new WithoutOverlapping($this->crawlingJob->id . '-' . $this->keyword))->dontRelease()
        ];
    }
}
