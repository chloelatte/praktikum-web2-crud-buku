<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SelamatDatangMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $nama;

    public function __construct($nama)
    {
        $this->nama = $nama;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat Datang di Website Kami!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.selamat-datang',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
