<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeliveryOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public string $otp,
        public string $channel
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Delivery Confirmation Code - Order #' . $this->order->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.delivery-otp',
            with: ['channel' => $this->channel],
        );
    }
}
