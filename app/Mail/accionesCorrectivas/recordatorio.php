<?php

namespace App\Mail\accionesCorrectivas;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class recordatorio extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $acciones;

    public function __construct($subject, $acciones)
    {
        $this->subject = $subject;
        $this->acciones = $acciones;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->view('emails.accionescorrectivas.recordatorio')
            ->subject($this->subject);
    }

    public function content(): Content
    {
        return new Content('');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
