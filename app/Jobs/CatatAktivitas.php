<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;

class CatatAktivitas implements ShouldQueue, ShouldBeUniqueUntilProcessing, ShouldBeEncrypted
{
    use Batchable, Queueable;

    public function __construct(
        public string $nama
    ) {
        //
    }

    public function middleware(): array
    {
        return [
            (new WithoutOverlapping($this->nama))
                ->releaseAfter(5)
                ->expireAfter(60),

            new RateLimited('aktivitas'),
        ];
    }

    public function handle(): void
    {
        logger("Pengguna {$this->nama} telah melakukan aktivitas.");
    }

    public function uniqueId(): string
    {
        return $this->nama;
    }
}