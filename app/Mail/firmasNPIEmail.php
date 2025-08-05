<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class firmasNPIEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $accion;

    public function __construct($accion, $subject)
    {
        $this->accion = $accion;
        $this->subject = $subject;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.firmasNPIMail',
            with: ['accion' => $this->accion],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
