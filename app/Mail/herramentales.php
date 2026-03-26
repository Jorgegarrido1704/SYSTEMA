<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class herramentales extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $acciones;

    public function __construct ($subject,$acciones)
    {
        $this->acciones = $acciones;
        $this->subject = $subject;
    }

   

        public function build()
        {
            return $this->view('emails.herramentales.avisoHerramentales')
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