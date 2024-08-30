<?php

namespace App\Notifications;

use App\Models\PidumAktiviti;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TugasNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $data = [];
    public function __construct($id)
    {
        $data = PidumAktiviti::find($id);
        $data['deadline'] = Carbon::parse($data['deadline'])->format('d F Y');
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to('-4245000877')
            // ->to($notifiable->telegram_chat_id)
            ->view('notifications.tugas_baru', ['data' => $this->data]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
