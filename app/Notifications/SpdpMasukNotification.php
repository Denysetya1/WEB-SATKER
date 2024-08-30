<?php

namespace App\Notifications;

use App\Models\IdentitasTersangka;
use App\Models\PerkaraPidumTersangka;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class SpdpMasukNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $data = [];

    public function __construct(Collection $datas)
    {
        // $identitas = $datas->identitas_tersangka->pluck('id');
        // $spdp = $datas->pluck('no_spdp');
        // $waktu = $datas->pluck('masuk_at');
        foreach ($datas as $key => $data) {
            // dd($data['no_spdp'], $data->identitas_tersangka);
            foreach ($data->identitas_tersangka as $key => $id ) {
                $nama = IdentitasTersangka::find($id)->pluck('nama');
                $perkara['nama'][$key] = $nama[0];
            }
            $perkara['no_spdp'] = $data['no_spdp'];
            $perkara['masuk_at'] = Carbon::parse($data['masuk_at'])->format('d F Y');
        }
        $this->data = $perkara;
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
            ->view('notifications.spdp_masuk', ['data' => $this->data]);
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
