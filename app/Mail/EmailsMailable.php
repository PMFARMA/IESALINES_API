<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailsMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $textomsg;
    public $asuntomsg;
    public $urlToFront;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($textomsg,$asuntomsg,$urlToFront)
    {
        $this->textomsg =$textomsg;
        $this->asuntomsg = $asuntomsg;
        $this->urlToFront =$urlToFront;

    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        // return $this->subject($amsg);
        return new Envelope(
            // subject: 'Enhorabuena! Has sido seleccionado como Jurado de los Premios Aspid',
            subject: $this->asuntomsg,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'message-received',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
