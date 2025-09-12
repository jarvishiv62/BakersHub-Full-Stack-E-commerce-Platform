<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $previousStatus;
    public $newStatus;

    /**
     * Create a new notification instance.
     *
     * @param Order $order
     * @param string $previousStatus
     * @param string $newStatus
     * @return void
     */
    public function __construct(Order $order, string $previousStatus, string $newStatus)
    {
        $this->order = $order;
        $this->previousStatus = $previousStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Order #{$this->order->order_number} Status Updated")
                    ->line('The status of your order has been updated.')
                    ->line('Order Number: ' . $this->order->order_number)
                    ->line('Previous Status: ' . ucfirst($this->previousStatus))
                    ->line('New Status: ' . ucfirst($this->newStatus))
                    ->action('View Order', url('/orders/' . $this->order->id))
                    ->line('Thank you for shopping with us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'previous_status' => $this->previousStatus,
            'new_status' => $this->newStatus,
            'message' => "Order #{$this->order->order_number} status changed from " . 
                        ucfirst($this->previousStatus) . ' to ' . ucfirst($this->newStatus),
        ];
    }
}
