<?php

namespace App\Mail\maquinasCorte;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class mailmaquinascorte extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $acciones; // Esta variable estará disponible automáticamente en la vista blade

    public function __construct($acciones, $subject)
    {
        $this->acciones = $acciones;
        $this->subject = $subject;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject, // Usamos la variable dinámica que pasamos desde el Job
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.maquinasdecorte', // Tu vista HTML del correo
            with: [
                'accion' => $this->acciones, // Mapeamos 'accion' para que coincida con tu vista
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
