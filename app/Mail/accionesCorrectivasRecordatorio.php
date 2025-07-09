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

    public $acciones;

public function __construct($acciones)
{
    $this->acciones = $acciones;
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
            'accion' => $this->acciones,
        ]
    );
}

    public function attachments(): array
    {
        return [];
    }
}
