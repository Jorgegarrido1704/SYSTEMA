<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
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
            from: new Address('new_product_introduction@mx.bergstrominc.com', 'Firmas Completas'),
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
