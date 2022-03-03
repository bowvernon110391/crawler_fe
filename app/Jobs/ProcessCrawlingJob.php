<?php

namespace App\Jobs;

use App\Models\CrawlingJob;
use App\Services\CrawlingJobService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCrawlingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $crawlingJob;
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
}
