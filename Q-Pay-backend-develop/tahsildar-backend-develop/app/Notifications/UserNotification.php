<?php

namespace App\Notifications;

use App\Notifications\Concerns\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;

class UserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $title;

    private string $body;

    private array $payload;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title,$body,$payload)
    {
        $this->title = $title;
        $this->body = $body;
        $this->payload = $payload;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return [FcmChannel::class,'database'];
    }


    public function toFcm($notifiable)
    {
        if ($notifiable->fcm_token)
        {
            $platform = $notifiable->fcm_platform;
            $payload = $this->payload;
            foreach ($payload as $key => $item) {
                if ($item == null)
                    $payload[$key] = '';
                if (! is_string($item)) {
                    $payload[$key] = strval($item);
                }
            }
            $payload['id'] = $this->id;
            $payload['title'] = $this->title;
            $payload['body'] = $this->body;
            if ($platform == 'android')
            {
                return FcmMessage::create()
                    ->setData($payload);
            }
            else{
                return FcmMessage::create()
                    ->setData($payload)
                    ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                        ->setTitle($payload['title'])
                        ->setBody($payload['body']));
            }
        }
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
            'title' => $this->title,
            'body' => $this->body,
            'payload' => $this->payload
        ];
    }
}
