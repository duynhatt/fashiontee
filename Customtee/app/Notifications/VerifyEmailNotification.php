<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    public function __construct(public string $code)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $appName = config('app.name', 'FashionTee');

        return (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name', $appName))
            ->subject('Mã xác thực tài khoản - ' . $appName)
            ->greeting('Xin chào ' . ($notifiable->name ?? 'bạn') . '!')
            ->line('Cảm ơn bạn đã đăng ký tài khoản tại FASHIONTEENIGGA.')
            ->line('Mã xác thực OTP gồm 6 chữ số để kích hoạt tài khoản của bạn là:')
            ->line("**{$this->code}**")
            ->line('Mã xác thực này có hiệu lực trong vòng **5 phút**.')
            ->line('Nếu bạn không thực hiện đăng ký tài khoản này, vui lòng bỏ qua email.')
            ->salutation('Trân trọng, ');
    }
}

