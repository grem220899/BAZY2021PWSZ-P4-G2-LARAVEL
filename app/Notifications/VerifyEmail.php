<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
//    use Queueable;

    // change as you want
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }
        return (new MailMessage)
            ->greeting('Witaj!')
            ->subject('Email Weryfikacyjny')
            ->line('Kliknij przycisk poniżej, aby zweryfikować swój adres e-mail.')
            ->action(
                ('Weryfikuj konto'),
                $this->verificationUrl($notifiable)
            )
            ->line('Jeśli nie utworzyłeś konta, żadne dalsze działania nie są wymagane.');

    }
}