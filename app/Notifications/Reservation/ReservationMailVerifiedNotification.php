<?php

namespace App\Notifications\Reservation;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationMailVerifiedNotification extends Notification
{
    use Queueable;

    private Reservation $reservation;

    /**
     * Create a new notification instance.
     *
     * @param Reservation $reservation
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
