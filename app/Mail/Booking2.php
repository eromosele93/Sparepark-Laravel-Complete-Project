<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Booking2 extends Mailable
{
    use Queueable, SerializesModels;
public $name_owner;
public $hours;
public $on;
public $cus_email;
public $subject2;
public $address2;
public $postcode2;
public $amount2;


    /**
     * Create a new message instance.
     */
    public function __construct($name_owner, $hours, $on, $cus_email, $subject2, $address2, $postcode2, $amount2)
    {
        $this->name_owner = $name_owner;
        $this->hours = $hours;
        $this->on = $on;
        $this->cus_email = $cus_email;
        $this->subject2 = $subject2;
        $this->address2 = $address2;
        $this->postcode2 = $postcode2;
        $this->amount2 = $amount2;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject:  $this->subject2,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.booking2',
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
