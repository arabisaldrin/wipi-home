<?php

namespace App\Notifications;

use App\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class VoucherUsed extends Notification implements ShouldQueue
{
    use Queueable;

    public $voucher;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->voucher->attributesToArray();
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        $code = $this->voucher->code;
        return new BroadcastMessage([
            'title' => 'Voucher used',
            'body' => "Voucher $code has been used",
            'voucher' => $this->voucher->attributesToArray(),
        ]);
    }

}
