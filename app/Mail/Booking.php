<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Booking extends Mailable
{
    use Queueable, SerializesModels;

  public $owner_email;
  public $duration;
  public $date_time;
  public $owner_phone;
  public $address;
  public $postcode;
  public $subject; 
  public $name_user; 
  public $amount;

    public function __construct($duration, $date_time, $owner_email, $owner_phone, $address, $postcode, $subject, $name_user, $amount)
    {
        $this->duration = $duration;
        $this->owner_email = $owner_email;
        $this->date_time = $date_time;
        $this->owner_phone = $owner_phone;
        $this->address = $address;
        $this->postcode = $postcode;
        $this->subject = $subject;
        $this->name_user = $name_user;
        $this->amount = $amount;


    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.booking',
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
