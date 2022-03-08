<?php

namespace App\Jobs;

use App\Events\CrawlingJobProgress;
use App\Models\CrawlingJob;
use App\Services\CrawlingJobService;
use App\Services\ItemService;
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
    public function handle(ItemService $service)
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
        /* sleep(random_int(1, 5));
        // also, randomly spawn error
        if (random_int(0, 100) > 70) {
            throw new \Exception("Fail at keyword: {$this->keyword}");
        } */

        // call the script and service

        // call it?
        $keyword = $this->keyword;
        $lockId = $this->crawlingJob->id . '-' . $keyword;
        $page = 1;
        $number = 60;

        $count = 0;
        while (true) {
            // build command
            $cmd = build_crawl_command($keyword, $page, $number, $lockId);
            logger("[ProcessCrawlingJob]: -> exec($cmd)");

            // execute it for real
            $json = exec($cmd, $result, $stat);

            if (!$stat) {
                // normal
                $data = json_decode($json);

                // append more?
                logger("[ProcessCrawlingJob]: -> RAW DATA", $result);
                logger("[ProcessCrawlingJob]: -> PARSED DATA", [ 'parsed' => $data ]);

                $dataCount = count($data);

                logger("[ProcessCrawlingJob]: -> GOT {$dataCount} DATA!");

                if (!$dataCount) {
                    // stop crawler, 
                    logger("[ProcessCrawlingJob]: -> No more result. Stopping crawler...");
                    break;
                }
            } else if ($stat != 2) {
                // error happens. stop crawler?
                logger("[ProcessCrawlingJob]: EXCEPTION", [
                    'exception' => $result,
                    'code' => $stat,
                    'keyword' => $keyword,
                    'page' => $page,
                    'number' => $number,
                    'lockId' => $lockId
                ]);
                throw new \Exception(print_r($result, false), $stat);
            } else {
                // duplicate process... just bail
                logger("[ProcessCrawlingJob]: -> Duplicate lock {$lockId}");
                return ;
            }

            $page++;

            // maybe sleep a bit to avoid suspicion?
            sleep(5);
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
