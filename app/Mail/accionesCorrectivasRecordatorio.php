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

    public $accion;

public function __construct($accion)
{
    $this->accion = $accion;
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
            'accion' => $this->accion,
        ]
    );
}

    public function attachments(): array
    {
        return [];
    }
}
