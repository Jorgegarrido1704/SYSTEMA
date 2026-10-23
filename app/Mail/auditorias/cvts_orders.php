<?php

namespace App\Mail\auditorias;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class cvts_orders extends Mailable
{
    use Queueable, SerializesModels;

     public $subject;

    public $acciones;
    public $results;
    public function __construct($acciones,$results, $subject)
    {
        $this->acciones = $acciones;
        $this->results = $results;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Daily CVTS Orders report ',
        );
    }

      public function build()
    {
        return $this->from('CVTS@mx.bergstrominc.com')->view('emails.auditorias.cvts_orders_mail')
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
