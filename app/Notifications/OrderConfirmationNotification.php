<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('Order Confirmation - #' . $this->order->id)
            ->greeting('Hello ' . $this->order->name . '!')
            ->line('Thank you for shopping with Capital Shop. We have received your order and it is being processed.')
            ->line('**Order Summary:**')
            ->line('Order ID: #' . $this->order->id)
            ->line('Total Amount: ৳' . number_format($this->order->total, 2));

        if ($this->order->coupon_code) {
            $mailMessage->line('Coupon Applied: ' . $this->order->coupon_code);
            $mailMessage->line('Discount: ৳' . number_format($this->order->discount_amount, 2));
        }

        return $mailMessage
            ->line('Shipping Address: ' . $this->order->address . ', ' . $this->order->city)
            ->action('View Order Details', route('customer.order.detail', $this->order->id))
            ->line('Thank you for choosing us!');
    }
}
