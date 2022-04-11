<?php

namespace App\Notifications\Service;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ServiceApproved extends Notification
{
    use Queueable;

    private Service $service;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $service = $this->service;
        return (new MailMessage)
            ->subject('İlan Onaylandı')
            ->line("İlan onaylandı. Artık belirttiğiniz tarihler arasında rezervasyon alabilirsiniz.")
            ->line(new HtmlString("<h4>İlan Bilgileri</h4>"))
            ->line('ID : ' . $service->id)
            ->line('Başlık : ' . $service->title)
            ->line('Adres : ' . $service->address)
            ->action('İlanı Görüntüle', url(route('user.services.edit', $service->id)))
            ->line('Bizi seçtiğiniz için teşekkürler.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'service_title' => $this->service->title,
            'service_id' => $this->service->id,
            'service_slug' => $this->service->slug,
            'service_address' => $this->service->address,
        ];
    }
}
