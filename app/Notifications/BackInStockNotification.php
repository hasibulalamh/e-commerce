<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BackInStockNotification extends Notification
{
    use Queueable;

    protected $product;

    /**
     * Create a new notification instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
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
        return (new MailMessage)
            ->subject('🔥 Good News! ' . $this->product->name . ' is back in stock!')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Great news! An item from your wishlist is now back in stock.')
            ->line('**Product:** ' . $this->product->name)
            ->line('**Price:** ৳' . number_format($this->product->final_price, 2))
            ->action('View Product', url('/product/details/' . $this->product->id))
            ->line('Hurry up and grab yours before it runs out again!')
            ->line('Thank you for shopping with us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'message' => 'Back in stock!'
        ];
    }
}
