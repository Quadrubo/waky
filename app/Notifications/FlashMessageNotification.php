<?php

namespace App\Notifications;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class FlashMessageNotification extends Notification implements ShouldBroadcast
{
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
    public function __construct(
        public string $title,
        public string $level,
        public ?string $body = null,
    ) {
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
            'title' => $this->title,
            'level' => $this->level,
            'body' => $this->body,
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
