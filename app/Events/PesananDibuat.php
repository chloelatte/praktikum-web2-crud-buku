<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PesananDibuat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $userId,
        public string $nomorPesanan,
        public int $total
    ) {
        //
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->userId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'pesanan.dibuat';
    }

    public function broadcastWith(): array
    {
        return [
            'nomor_pesanan' => $this->nomorPesanan,
            'total' => $this->total,
            'pesan' => 'Pesanan baru berhasil dibuat!',
        ];
    }
}
