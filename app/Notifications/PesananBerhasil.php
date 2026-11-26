<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PesananBerhasil extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $nama,
        public string $nomorPesanan,
        public int $total
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pesanan Berhasil!')
            ->greeting('Halo, ' . $this->nama . '!')
            ->line('Pesanan Anda berhasil dibuat.')
            ->line('Nomor Pesanan: ' . $this->nomorPesanan)
            ->line('Total Pembayaran: Rp ' . number_format($this->total, 0, ',', '.'))
            ->action('Lihat Pesanan', url('/'))
            ->line('Terima kasih telah berbelanja!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'nama' => $this->nama,
            'nomor_pesanan' => $this->nomorPesanan,
            'total' => $this->total,
            'pesan' => 'Pesanan Anda berhasil dibuat.',
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'nama' => $this->nama,
            'nomor_pesanan' => $this->nomorPesanan,
            'total' => $this->total,
            'pesan' => 'Pesanan Anda berhasil dibuat.',
        ]);
    }
}
