<?php

namespace App\Notifications\Reservation;

use App\Models\Reservation;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PendingReservationRequestNotification extends Notification
{
    use Queueable;

    private Reservation $reservation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $service = $this->reservation->service;
        $reservation = $this->reservation;
        return (new MailMessage)
            ->subject('Onay Bekleyen Rezervasyonun Var.')
            ->line("{$service->title} için {$reservation->start_date}-{$reservation->end_date} tarihleri arasında yeni rezervasyon isteği aldın.")
            ->line('İşlem yapmak için aşağıda bulunan butona tıklayınız.')
            ->line(new HtmlString("<h4>Rezervasyon Detayları</h4>"))
            ->line("Rezervasyon ID : " . $reservation->id)
            ->line("Giriş : " . $reservation->start_date)
            ->line("Çıkış : " . $reservation->end_date)
            ->line("Fiyat : " . $reservation->price . " ₺")
            ->line("Gün : " . $reservation->day_count)
            ->line("Toplam : " . $reservation->total_price . " ₺")
            ->action('Detayları Göster', url(route('user.reservations.show', ['reservation' => $reservation->id])));
    }

    /**
     * save notification detail to database.
     * @param User $user
     * @return array
     */
    public function toArray(User $user)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'service_title' => $this->reservation->service->title,
            'user_full_name' => $this->reservation->user->full_name,
            'user_email' => $this->reservation->user->email,
            'start_date' => createdAt($this->reservation->start_date),
            'end_date' => createdAt($this->reservation->end_date),
            'day_count' => $this->reservation->day_count,
            'price_per_day' => $this->reservation->price,
            'total_price' => $this->reservation->total_price,
        ];
    }

}
