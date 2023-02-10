<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;

class UseComputerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        public string $computerName,
        public bool $computerInUse,
        public Carbon $timestamp
    ) {
        $this->connection = 'database';
        $this->queue = 'notifications';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebhookChannel::class];
    }

    public function toWebhook($notifiable)
    {
        return WebhookMessage::create()
            ->data([
                'embeds' => [
                    [
                        'title' => $this->getEmbedTitle(),
                        'description' => $this->getEmbedDescription(),
                        'color' => $this->getEmbedColor(),
                        'timestamp' => $this->timestamp,
                    ],
                ],
            ])
            ->header('Content-Type', 'application/json');
    }

    public function getEmbedTitle()
    {
        return 'Computer '.trim($this->computerName).' is now '.($this->computerInUse ? 'in use.' : 'not in use.');
    }

    public function getEmbedDescription()
    {
        return ! $this->computerInUse ? 'Maybe you can shut it down?' : '';
    }

    public function getEmbedColor()
    {
        return $this->computerInUse ? '5763719' : '15548997';
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
