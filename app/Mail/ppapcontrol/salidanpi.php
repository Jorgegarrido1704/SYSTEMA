<?php

namespace App\Mail\ppapcontrol;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class salidanpi extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $content;

    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    public function build()
    {
        return $this->view('emails.npi.salidaNpi')
            ->subject($this->subject);
    }

    public function content(): Content
    {
        // Return an empty content instance
        return new Content('');
    }

    public function attachments(): array
    {
        return [];
    }
}
