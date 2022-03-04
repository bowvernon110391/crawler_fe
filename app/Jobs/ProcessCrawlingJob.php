<?php

namespace App\Jobs;

use App\Events\CrawlingJobProgress;
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
    public function handle()
    {
        // log
        logger("[ProcessCrawlingJob]: -> Crawling started. ({$this->crawlingJob->id}, {$this->keyword})", ['job' => $this->crawlingJob, 'keyword' => $this->keyword]);
        // mark status, possibly update progress too
        CrawlingJobProgress::dispatch($this->crawlingJob);
        
        // prevent unncessary work
        if ($this->batch()->cancelled()) {
            // tell user?
            logger("[ProcessCrawlingJob]: -> Crawling canceled. ({$this->crawlingJob->id}, {$this->keyword})!");
            return;
        }

        // do some heavy work
        sleep(random_int(1, 5));
        // also, randomly spawn error
        if (random_int(0, 100) > 160) {
            throw new \Exception("Fail at keyword: {$this->keyword}");
        }

        // $service->update($this->crawlingJob, ['status' => "PROCESSING({$this->batch()->processedJobs()}/{$this->batch()->totalJobs})"], null);
        logger("[ProcessCrawlingJob]: -> Done crawling job ({$this->crawlingJob->id}, {$this->keyword})", ['job' => $this->crawlingJob, 'keyword' => $this->keyword]);
        // update again after another work
        CrawlingJobProgress::dispatch($this->crawlingJob);
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
