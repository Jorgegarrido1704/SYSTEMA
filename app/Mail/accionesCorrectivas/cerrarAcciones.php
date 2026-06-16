<?php

namespace App\Mail\accionesCorrectivas;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class cerrarAcciones extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $acciones;

    /**
     * Create a new message instance.
     */
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
            subject: 'Cierre de accion correctiva',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->from('acciones_correctivas@mx.bergstrominc.com')->view('emails.accionescorrectivas.cierreAccion')
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
