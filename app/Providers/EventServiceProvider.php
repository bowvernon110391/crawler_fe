<?php

namespace App\Providers;

use App\Events\CrawlingJobCreated;
use App\Events\CrawlingJobProgress;
use App\Events\CrawlingJobStarted;
use App\Listeners\SpawnCrawler;
use App\Listeners\UpdateCrawlingJobBatch;
use App\Listeners\UpdateCrawlingJobProgress;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // crawling job
        CrawlingJobCreated::class => [
            SpawnCrawler::class
        ],
        // when crawler is spawned
        CrawlingJobStarted::class => [
            UpdateCrawlingJobBatch::class
        ],
        // when crawling job has progress
        CrawlingJobProgress::class => [
            UpdateCrawlingJobProgress::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
