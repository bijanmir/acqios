<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactOwnerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $listing;
    public $sender;

    public function __construct($listing, $sender)
    {
        $this->listing = $listing;
        $this->sender = $sender;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), 'Acqios')
            ->subject("New Inquiry About Your Listing")
            ->view('emails.contact_owner')
            ->with([
                'listing' => $this->listing,
                'sender' => $this->sender,
            ]);
    }

}
