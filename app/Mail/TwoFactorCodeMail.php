<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public string $customerName;

    public function __construct(string $code, string $customerName)
    {
        $this->code = $code;
        $this->customerName = $customerName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Login Verification Code - Capital Shop',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.two-factor',
        );
    }
}
