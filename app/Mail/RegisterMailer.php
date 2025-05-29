<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $mailSubject;
    public $userData;
    //we pass verification link also in $userData variable from MainController
    public function __construct($mailSubject, $userData)
    {
        $this->mailSubject = $mailSubject;
        $this->userData = $userData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            //here we pass $mailSubject to show as subject when user received mail
            subject: $this->mailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            //in this section we have to pass our view blade that will send to the user as message or mail body
            //so now we create a blade template for mail
            view: 'mail-register',
        );
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
