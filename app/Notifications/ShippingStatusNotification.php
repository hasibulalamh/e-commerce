<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShippingStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($order, $status)
    {
        $this->order = $order;
        $this->status = $status;
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
        $statusText = ucfirst($this->status);
        
        return (new MailMessage)
            ->subject('Order Status Updated - #' . $this->order->id)
            ->greeting('Hello ' . $this->order->name . '!')
            ->line('Your order #**' . $this->order->id . '** status has been updated to: **' . $statusText . '**. ')
            ->line($this->getStatusMessage())
            ->action('Track Order', route('customer.order.detail', $this->order->id))
            ->line('Thank you for shopping with us!');
    }

    protected function getStatusMessage()
    {
        return match($this->status) {
            'confirmed' => 'We have confirmed your order and it will be prepared for shipping soon.',
            'shipped' => 'Great news! Your order has been shipped and is on its way to you.',
            'delivered' => 'Your order has been delivered. We hope you love your purchase!',
            'cancelled' => 'Your order has been cancelled. If you have any questions, please contact our support.',
            default => 'Your order status has changed.'
        };
    }
}
