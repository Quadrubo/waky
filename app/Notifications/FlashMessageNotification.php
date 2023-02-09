<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FlashMessageNotification extends Notification implements ShouldBroadcast
{
    public string $message;

    public string $level;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    //public $queue = ;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $message, string $level)
    {
        $this->message = $message;
        $this->level = $level;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the broadcast representation of the notification.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return (new BroadcastMessage([
            'message' => $this->message,
            'level' => $this->level,
        ]))->onConnection('database')->onQueue('notifications');
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
            //
        ];
    }
}
