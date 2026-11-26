<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PengumumanBaru implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $judul,
        public string $isi
    ) {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('pengumuman'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'pengumuman.baru';
    }

    public function broadcastWith(): array
    {
        return [
            'judul' => $this->judul,
            'isi' => $this->isi,
        ];
    }
}
