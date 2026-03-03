<?php

namespace App\Mail\accionesCorrectivas;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class cincoPorques extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $acciones;

    public function __construct($acciones, $subject)
    {
        $this->acciones = $acciones;
        $this->subject = $subject;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Descripción de cinco porques ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->view('emails.accionescorrectivas.registroPorques')
            ->subject($this->subject);
    }

    public function content(): Content
    {
        return new Content('');
    }

    public function attachments(): array
    {
        return [];
    }
}
