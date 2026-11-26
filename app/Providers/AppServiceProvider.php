<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('aktivitas', function (object $job) {
            return Limit::perMinute(3);
        });

        Queue::before(function (JobProcessing $event) {
            logger('Job mulai diproses: ' .
                $event->job->payload()['displayName']);
        });

        Queue::after(function (JobProcessed $event) {
            logger('Job berhasil diproses: ' .
                $event->job->payload()['displayName']);
        });

        Queue::exceptionOccurred(function (JobExceptionOccurred $event) {
            logger('Job mengalami exception: ' .
                $event->job->payload()['displayName']);

            logger('Pesan error: ' . $event->exception->getMessage());
        });

        Queue::failing(function (JobFailed $event) {
            logger('Job gagal secara permanen: ' .
                $event->job->payload()['displayName']);

            logger('Penyebab kegagalan: ' .
                $event->exception->getMessage());
        });
    }
}