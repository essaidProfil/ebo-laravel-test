<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    protected $product;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $product
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Stock Faible Alert: ' . $this->product->name)
            ->greeting('Bonjour,')
            ->line('Le produit "' . $this->product->name . '" a un stock faible.')
            ->line('Stock actuel : ' . $this->product->stock)
            ->line('Merci de prendre les mesures nécessaires.')
            ->action('Voir le Produit', url('/products/' . $this->product->id))
            ->line('Merci pour votre attention !');
    }
}
