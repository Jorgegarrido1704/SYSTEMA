<?php

namespace App\Mail\accionesCorrectivas;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class eliminacionCausas extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $subject;

    public $acciones;

    public function __construct($acciones, $subject)
    {
        $this->acciones = $acciones;
        $this->subject = $subject;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Eliminación de causa raíz o contención para la acción correctiva',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->view('emails.accionescorrectivas.eliminacionCausaRaiz')
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
