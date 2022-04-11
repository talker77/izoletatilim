<?php

namespace App\Notifications\User;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageCreatedNotification extends Notification
{
    use Queueable;

    private Message $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = $this->message;

        return (new MailMessage)
            ->subject('Yeni mesajın var.')
            ->line($message->from->full_name . " tarafından yeni mesajın var.")
            ->action('Mesajları Gör', url(route('user.chat.index', ['from' => $message->from_id])));
    }
}
