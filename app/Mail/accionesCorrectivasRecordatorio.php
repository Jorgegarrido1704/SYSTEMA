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
    
    Public $subject;
    public $acciones;

public function __construct($acciones, $subject)
{
    $this->acciones = $acciones;
    $this->subject = $subject;
}




    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Acciones Correctivas Recordatorio'
        );
    }

      public function build()
    {
        return $this->view('emails.accionesCorrectivasMail')
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
