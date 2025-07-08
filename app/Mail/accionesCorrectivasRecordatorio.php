<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class accionesCorrectivasRecordatorio extends Mailable
{
    use Queueable, SerializesModels;

    public $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Acciones Correctivas Recordatorio'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.accionesCorrectivasMail',
            with: [
                'accion' => $this->content,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
